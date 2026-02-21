<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\CourseSession;
use App\Models\User;
use App\Models\Diskusi;

class CourseSessionController extends Controller
{
    /**
     * 🔒 Helper: pastikan kelas milik dosen login
     */
    protected function authorizeKelas(Kelas $kelas)
    {
        if ($kelas->dosen_id !== auth('dosen')->id()) {
            abort(403, 'Anda tidak berhak mengakses kelas ini');
        }
    }

    /**
     * =====================================================
     * DETAIL SESSION (BERDASARKAN SESSION ID - AMAN)
     * =====================================================
     */
    public function show($sessionId)
    {
        $session = CourseSession::with([
                'materis',
                'discussions.sender',
                'kelas.mataKuliah'
            ])
            ->whereHas('kelas', function ($q) {
                $q->where('dosen_id', auth('dosen')->id());
            })
            ->findOrFail($sessionId);

        $kelas = $session->kelas;

        $this->authorizeKelas($kelas);

        // Hitung user online (aktif 5 menit terakhir)
        $onlineUsers = User::where('last_seen', '>=', now()->subMinutes(5))->count();

        return view('dosen.session.detail', compact('session', 'kelas', 'onlineUsers'));
    }

    /**
     * =====================================================
     * DETAIL SESSION (BERDASARKAN KELAS + SESSION)
     * =====================================================
     */
    public function detail($kelasId, $sessionId)
    {
        $kelas = Kelas::where('id', $kelasId)
            ->where('dosen_id', auth('dosen')->id())
            ->firstOrFail();

        $session = $kelas->courseSessions()
            ->with([
                'materis',
                'discussions.sender',
                'kelas.mataKuliah'
            ])
            ->findOrFail($sessionId);

        $onlineUsers = User::where('last_seen', '>=', now()->subMinutes(5))->count();

        return view('dosen_manage_session_detail', compact('session', 'kelas', 'onlineUsers'));
    }

    /**
     * =====================================================
     * SIMPAN PESAN DISKUSI (AMAN + VALID + TERPROTEKSI)
     * =====================================================
     */
    public function storeDiskusi(Request $request, $sessionId)
    {
        // 1️⃣ Validasi
        $request->validate([
            'message' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'voice'   => 'nullable|file|max:10240',
        ]);

        // 2️⃣ Cek kosong
        if (
            empty($request->message) &&
            !$request->hasFile('image') &&
            !$request->hasFile('voice')
        ) {
            return $request->wantsJson()
                ? response()->json(['error' => 'Pesan tidak boleh kosong!'], 422)
                : back()->with('error', 'Pesan tidak boleh kosong!');
        }

        // 3️⃣ SECURITY FIX:
        // Pastikan session milik dosen login
        $session = CourseSession::whereHas('kelas', function ($q) {
                $q->where('dosen_id', auth('dosen')->id());
            })
            ->findOrFail($sessionId);

        // 4️⃣ Upload file jika ada
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('diskusi/images', 'public')
            : null;

        $voicePath = $request->hasFile('voice')
            ? $request->file('voice')->store('diskusi/voices', 'public')
            : null;

        // 5️⃣ Simpan ke database
        $diskusi = Diskusi::create([
            'session_id'  => $session->id,
            'sender_type' => get_class(auth('dosen')->user()),
            'sender_id'   => auth('dosen')->id(),
            'message'     => $request->message,
            'image'       => $imagePath,
            'voice'       => $voicePath,
        ]);

        // 6️⃣ Response untuk AJAX
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'diskusi' => [
                    'id'      => $diskusi->id,
                    'message' => $diskusi->message,
                    'image'   => $diskusi->image ? asset('storage/' . $diskusi->image) : null,
                    'voice'   => $diskusi->voice ? asset('storage/' . $diskusi->voice) : null,
                    'time'    => $diskusi->created_at->format('H:i'),
                    'sender'  => auth('dosen')->user()->nama,
                ]
            ]);
        }

        // 7️⃣ Fallback non-AJAX
        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}