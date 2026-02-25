<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Events\DiscussionCreated;
use App\Models\CourseSession;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

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
    $request->validate([
        'message'     => 'nullable|string',
        'image'       => 'nullable|image|max:2048',
        'voice'       => 'nullable|mimes:mp3,wav,ogg,webm|max:5120',
        'sender_type' => 'nullable|string',
    ]);

    $senderId = null;
    $senderType = null;

    $requestedSender = $request->input('sender_type');

    if ($requestedSender === 'mahasiswa' && Auth::guard('mahasiswa')->check()) {
        $senderId = Auth::guard('mahasiswa')->id();
        $senderType = 'mahasiswa';
    } elseif ($requestedSender === 'dosen' && Auth::guard('dosen')->check()) {
        $senderId = Auth::guard('dosen')->id();
        $senderType = 'dosen';
    }

    if (!$senderId) {
        return response()->json(['error' => 'Sesi login tidak valid.'], 403);
    }

    $pathImage = $request->hasFile('image')
        ? $request->file('image')->store('diskusi/images', 'public')
        : null;

    $pathVoice = $request->hasFile('voice')
        ? $request->file('voice')->store('diskusi/voices', 'public')
        : null;

    if (!$request->message && !$pathImage && !$pathVoice) {
        return response()->json(['error' => 'Konten pesan tidak boleh kosong.'], 422);
    }

    $discussion = \App\Models\Discussion::create([
        'session_id'  => $sessionId,
        'sender_id'   => $senderId,
        'sender_type' => $senderType,
        'message'     => $request->message,
        'image'       => $pathImage,
        'voice'       => $pathVoice,
    ]);

    // 🔎 Ambil session + kelas untuk notif
    $session = \App\Models\Session::with('kelas')->findOrFail($sessionId);
    $dosenId = $session->kelas->dosen_id;

    // 🔔 Kirim notif jika pengirim mahasiswa
    if ($senderType === 'mahasiswa') {
        \App\Models\Notification::create([
            'user_id'   => $dosenId,
            'user_type' => 'dosen',
            'type'      => 'info',
            'title'     => 'Pesan Diskusi Baru',
            'message'   => 'Mahasiswa <b>' . Auth::guard('mahasiswa')->user()->name . '</b> mengirim pesan pada diskusi sesi.',
            'url'       => route('dosen.session.show', $sessionId),
            'is_read'   => false,
        ]);
    }

    $discussion->load('sender');

    broadcast(new \App\Events\DiscussionCreated($discussion))->toOthers();

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