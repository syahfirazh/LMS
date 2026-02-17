<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseSession;
use App\Models\Diskusi;
use App\Models\Dosen;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    // =========================================================
    // DETAIL SESSION + DISKUSI (AMAN MULTI KELAS)
    // =========================================================
    public function manage($sessionId)
    {
        /** @var Dosen $dosen */
        $dosen = Auth::guard('dosen')->user();

        // 🔒 Ambil session via kelas milik dosen
        $session = CourseSession::whereHas('kelas', function ($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id);
            })
            ->with(['discussions.sender', 'materis', 'kelas'])
            ->findOrFail($sessionId);

        // Update last seen dosen
        $dosen->update([
            'last_seen' => now()
        ]);

        $onlineUsers = Dosen::where(
            'last_seen',
            '>=',
            now()->subMinutes(5)
        )->count();

        return view('dosen.session.manage', compact(
            'session',
            'onlineUsers'
        ));
    }

    // =========================================================
    // STORE DISKUSI (TERIKAT SESSION + KELAS + DOSEN)
    // =========================================================
    public function storeDiskusi(Request $request, $sessionId)
    {
        $request->validate([
            'message' => 'nullable|string',
            'image'   => 'nullable|image|max:2048',
            'voice'   => 'nullable|file|mimes:webm,wav,mp3|max:5120',
        ]);

        /** @var Dosen $dosen */
        $dosen = Auth::guard('dosen')->user();

        // 🔒 Pastikan session milik kelas dosen
        $session = CourseSession::whereHas('kelas', function ($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id);
            })
            ->findOrFail($sessionId);

        $imagePath = null;
        $voicePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('diskusi', 'public');
        }

        if ($request->hasFile('voice')) {
            $voicePath = $request->file('voice')
                ->store('diskusi', 'public');
        }

        $diskusi = Diskusi::create([
            'session_id'  => $session->id,
            'sender_id'   => $dosen->id,
            'sender_type' => Dosen::class,
            'message'     => $request->message,
            'image'       => $imagePath,
            'voice'       => $voicePath,
        ]);

        $diskusi->load('sender');

        return response()->json([
            'id'      => $diskusi->id,
            'sender'  => $diskusi->sender?->name,
            'is_me'   => true,
            'message' => $diskusi->message,
            'image'   => $diskusi->image,
            'voice'   => $diskusi->voice,
            'time'    => $diskusi->created_at->format('d M H:i'),
        ]);
    }
}
