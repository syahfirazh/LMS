<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Events\DiscussionCreated;
use App\Models\CourseSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;
use App\Models\DosenNotification;

class DiscussionController extends Controller
{
    public function messages($sessionId)
    {
        $discussions = Discussion::with('sender')
            ->where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($discussions);
    }

    public function store(Request $request, $sessionId)
    {
        try {
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
                return response()->json(['success' => false, 'error' => 'Sesi login tidak valid.'], 403);
            }

            $pathImage = $request->hasFile('image')
                ? $request->file('image')->store('diskusi/images', 'public')
                : null;

            $pathVoice = $request->hasFile('voice')
                ? $request->file('voice')->store('diskusi/voices', 'public')
                : null;

            if (!$request->message && !$pathImage && !$pathVoice) {
                return response()->json(['success' => false, 'error' => 'Konten pesan tidak boleh kosong.'], 422);
            }

            $discussion = Discussion::create([
                'session_id'  => $sessionId,
                'sender_id'   => $senderId,
                'sender_type' => $senderType,
                'message'     => $request->message,
                'image'       => $pathImage,
                'voice'       => $pathVoice,
            ]);

            // NOTIFIKASI DISKUSI (Teks Sederhana)
            try {
                $session = CourseSession::with('kelas')->findOrFail($sessionId);
                $dosenId = $session->kelas->dosen_id ?? null;

                if ($senderType === 'mahasiswa' && $dosenId) {
                    DosenNotification::create([
                        'dosen_id'  => $dosenId,
                        'type'      => 'info',
                        'title'     => 'Diskusi',
                        'message'   => 'Ada 1 pesan diskusi.',
                        'url'       => route('dosen.course.session.detail', ['kelas' => $session->kelas_id, 'session' => $sessionId]),
                        'is_read'   => false,
                    ]);
                }
            } catch (\Exception $notifError) {
                Log::error('Gagal membuat notifikasi: ' . $notifError->getMessage());
            }

            $discussion->load('sender');
            broadcast(new DiscussionCreated($discussion))->toOthers();

            $fotoPath = $discussion->sender->foto_profil ?? $discussion->sender->foto ?? null;

            return response()->json([
                'success' => true,
                'diskusi' => [
                    'id'            => $discussion->id,
                    'message'       => $discussion->message,
                    'image'         => $discussion->image ? asset('storage/' . $discussion->image) : null,
                    'voice'         => $discussion->voice ? asset('storage/' . $discussion->voice) : null,
                    'time'          => $discussion->created_at->format('H:i'),
                    'sender_name'   => $discussion->sender->nama ?? 'User',
                    'sender_type'   => $discussion->sender_type,
                    'sender_avatar' => $fotoPath ? asset('storage/' . $fotoPath) : null,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'error'   => 'System Error: ' . $e->getMessage()
            ], 500);
        }
    }

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