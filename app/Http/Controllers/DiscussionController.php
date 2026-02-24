<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Events\DiscussionCreated;
use App\Models\CourseSession;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    /**
     * Mengambil riwayat diskusi untuk session tertentu (API)
     */
    public function messages($sessionId)
    {
        // Sertakan data sender untuk membedakan avatar dan nama di frontend
        $discussions = Discussion::with('sender')
            ->where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($discussions);
    }

    /**
     * Menyimpan pesan baru ke dalam Diskusi Grup Kelas
     */
    public function store(Request $request, $sessionId)
    {
        // 1. Validasi input, tambahkan validasi untuk sender_type
        $request->validate([
            'message'     => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'voice'       => 'nullable|mimes:mp3,wav,ogg,webm|max:5120',
            'sender_type' => 'nullable|string', 
        ]);

        $senderId = null;
        $senderType = null;

        // 2. Tangkap siapa pengirim yang dikirim dari form hidden input
        $requestedSender = $request->input('sender_type');

        // 3. Logika Pengecekan Guard yang kebal tabrakan session browser
        if ($requestedSender === 'mahasiswa' && Auth::guard('mahasiswa')->check()) {
            $senderId = Auth::guard('mahasiswa')->id();
            $senderType = 'mahasiswa'; // Map ke App\Models\Mahasiswa
        } elseif ($requestedSender === 'dosen' && Auth::guard('dosen')->check()) {
            $senderId = Auth::guard('dosen')->id();
            $senderType = 'dosen'; // Map ke App\Models\Dosen
        } else {
            // Fallback (jika form tidak mengirim sender_type karena alasan tertentu)
            if (Auth::guard('mahasiswa')->check() && !Auth::guard('dosen')->check()) {
                $senderId = Auth::guard('mahasiswa')->id();
                $senderType = 'mahasiswa';
            } elseif (Auth::guard('dosen')->check()) {
                $senderId = Auth::guard('dosen')->id();
                $senderType = 'dosen';
            }
        }

        // Jika tetap tidak ketemu siapa yang login
        if (!$senderId) {
            return response()->json(['error' => 'Sesi login telah habis atau tidak valid. Silakan login kembali.'], 403);
        }

        $pathImage = null;
        $pathVoice = null;

        if ($request->hasFile('image')) {
            $pathImage = $request->file('image')->store('diskusi/images', 'public');
        }

        if ($request->hasFile('voice')) {
            $pathVoice = $request->file('voice')->store('diskusi/voices', 'public');
        }

        // Validasi agar tidak mengirim pesan kosong total
        if (!$request->message && !$pathImage && !$pathVoice) {
            return response()->json(['error' => 'Konten pesan tidak boleh kosong.'], 422);
        }

        $discussion = Discussion::create([
            'session_id'  => $sessionId,
            'sender_id'   => $senderId,
            'sender_type' => $senderType,
            'message'     => $request->message,
            'image'       => $pathImage,
            'voice'       => $pathVoice,
        ]);

        // Load relasi sender agar data nama/foto tampil di realtime broadcast
        $discussion->load('sender');

        broadcast(new DiscussionCreated($discussion))->toOthers();

        return response()->json([
            'success' => true,
            'diskusi' => [
                'id'          => $discussion->id,
                'message'     => $discussion->message,
                'image'       => $discussion->image ? asset('storage/' . $discussion->image) : null,
                'voice'       => $discussion->voice ? asset('storage/' . $discussion->voice) : null,
                'time'        => $discussion->created_at->format('H:i'),
                'sender_name' => $discussion->sender->nama ?? 'User',
                'sender_type' => $discussion->sender_type,
            ]
        ]);
    }

    /**
     * Halaman index diskusi (Opsional, jika ingin halaman khusus diskusi)
     */
    public function index($sessionId = null)
    {
        $session = $sessionId ? CourseSession::findOrFail($sessionId) : CourseSession::first();
        $discussions = [];

        if ($session) {
            $discussions = Discussion::with('sender')
                ->where('session_id', $session->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('messages', compact('discussions', 'session'));
    }
}