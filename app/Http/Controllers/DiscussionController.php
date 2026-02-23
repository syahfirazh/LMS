<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Events\DiscussionCreated;
use App\Models\CourseSession;   

class DiscussionController extends Controller
{
    /**
     * Ambil semua pesan berdasarkan session
     */
    public function messages($sessionId)
    {
        return response()->json(
            Discussion::where('session_id', $sessionId)
                ->orderBy('created_at', 'asc')
                ->get()
        );
    }

    /**
     * Kirim pesan (text / image / voice)
     */
    public function store(Request $request, $sessionId)
    {
        $request->validate([
            'message' => 'nullable|string',
            'image'   => 'nullable|image|max:2048',
            'voice'   => 'nullable|mimes:mp3,wav,ogg|max:5120',
        ]);

        $pathImage = null;
        $pathVoice = null;

        if ($request->hasFile('image')) {
            $pathImage = $request->file('image')
                ->store('diskusi', 'public');
        }

        if ($request->hasFile('voice')) {
            $pathVoice = $request->file('voice')
                ->store('diskusi', 'public');
        }

        $discussion = Discussion::create([
            'session_id' => $sessionId,
            'sender_id'  => auth()->id(),
            'sender_type'=> auth('dosen')->check() ? 'dosen' : 'mahasiswa',
            'message'    => $request->message,
            'image'      => $pathImage,
            'voice'      => $pathVoice,
        ]);

        broadcast(new DiscussionCreated($discussion))->toOthers();

        return response()->json($discussion);
    }

    public function index()
{
    // ambil session pertama milik user (contoh aman)
    $session = \App\Models\CourseSession::first();

    $discussions = [];

    if ($session) {
        $discussions = \App\Models\Discussion::where('session_id', $session->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    return view('messages', compact('discussions', 'session'));
}
}