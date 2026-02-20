<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\CourseSession;
use App\Models\User;
use App\Models\Diskusi; // <-- Wajib dipanggil untuk insert data chat

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
     * DETAIL SESSION (AMAN, BERDASARKAN SESSION ID)
     * =====================================================
     */
    public function show($sessionId)
    {
        // PERBAIKAN: discussions.sender agar relasi pengirim terbaca
        $session = CourseSession::with(['materis', 'discussions.sender', 'kelas.mataKuliah'])
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

        // PERBAIKAN: discussions.sender agar profil/foto tampil
        $session = $kelas->courseSessions()
            ->with(['materis', 'discussions.sender', 'kelas.mataKuliah'])
            ->findOrFail($sessionId);

        // Hitung user online
        $onlineUsers = User::where('last_seen', '>=', now()->subMinutes(5))->count();

        return view('dosen_manage_session_detail', compact('session', 'kelas', 'onlineUsers'));
    }

    /**
     * =====================================================
     * SIMPAN PESAN DISKUSI (TEKS, GAMBAR, VOICE NOTE)
     * =====================================================
     */
    public function storeDiskusi(\Illuminate\Http\Request $request, $sessionId)
    {
        // 1. Validasi
        $request->validate([
            'message' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'voice'   => 'nullable|file|max:10240', 
        ]);

        // 2. Cek kosong
        if (empty($request->message) && !$request->hasFile('image') && !$request->hasFile('voice')) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Pesan tidak boleh kosong!'], 422);
            }
            return back()->with('error', 'Pesan tidak boleh kosong!');
        }

        $session = \App\Models\CourseSession::findOrFail($sessionId);

        // 3. Proses File
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('diskusi/images', 'public') : null;
        $voicePath = $request->hasFile('voice') ? $request->file('voice')->store('diskusi/voices', 'public') : null;

        // 4. Simpan ke Database
        $diskusi = \App\Models\Diskusi::create([
            'session_id'  => $session->id, 
            'sender_type' => get_class(auth('dosen')->user()), 
            'sender_id'   => auth('dosen')->id(),
            'message'     => $request->message,
            'image'       => $imagePath,
            'voice'       => $voicePath,
        ]);

        // 5. JIKA REQUEST DARI JAVASCRIPT (AJAX), KEMBALIKAN DATA JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'diskusi' => [
                    'message' => $diskusi->message,
                    'image'   => $diskusi->image ? asset('storage/' . $diskusi->image) : null,
                    'voice'   => $diskusi->voice ? asset('storage/' . $diskusi->voice) : null,
                    'time'    => $diskusi->created_at->format('H:i'),
                    'sender'  => auth('dosen')->user()->nama // Ambil nama dosen
                ]
            ]);
        }

        // Kalau bukan dari JS, fallback ke cara lama
        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}