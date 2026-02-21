<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenMessageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX - Sidebar + Default Chat
    |--------------------------------------------------------------------------
    */
    public function index(Request $request, $mahasiswa)
{
    $dosen = Auth::guard('dosen')->user();

    $chatMessages = Message::where(function ($q) use ($dosen, $mahasiswa) {
            $q->where('sender_type', 'dosen')
              ->where('sender_id', $dosen->id)
              ->where('receiver_type', 'mahasiswa')
              ->where('receiver_id', $mahasiswa);
        })
        ->orWhere(function ($q) use ($dosen, $mahasiswa) {
            $q->where('sender_type', 'mahasiswa')
              ->where('sender_id', $mahasiswa)
              ->where('receiver_type', 'dosen')
              ->where('receiver_id', $dosen->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return view('topic', compact('chatMessages', 'mahasiswa'));
}

    /*
    |--------------------------------------------------------------------------
    | SEND MESSAGE
    |--------------------------------------------------------------------------
    */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'body' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $dosen = Auth::guard('dosen')->user();

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat', 'public');
        }

        $message = Message::create([
            'sender_type'   => 'dosen',
            'sender_id'     => $dosen->id,
            'receiver_type' => 'mahasiswa',
            'receiver_id'   => $request->receiver_id,
            'body'          => $request->body,
            'image_path'    => $imagePath,
            'is_read'       => 0
        ]);

        return response()->json([
            'success' => true,
            'body'    => $message->body,
            'image'   => $message->image_path,
            'time'    => $message->created_at->format('H:i')
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FETCH CHAT (AJAX AUTO REFRESH)
    |--------------------------------------------------------------------------
    */
    public function fetch($mahasiswa)
{
    $dosen = Auth::guard('dosen')->user();

    $messages = Message::where(function ($q) use ($dosen, $mahasiswa) {
            $q->where('sender_type', 'dosen')
              ->where('sender_id', $dosen->id)
              ->where('receiver_type', 'mahasiswa')
              ->where('receiver_id', $mahasiswa);
        })
        ->orWhere(function ($q) use ($dosen, $mahasiswa) {
            $q->where('sender_type', 'mahasiswa')
              ->where('sender_id', $mahasiswa)
              ->where('receiver_type', 'dosen')
              ->where('receiver_id', $dosen->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return view('partials.chat_messages', compact('messages'));
}
}
