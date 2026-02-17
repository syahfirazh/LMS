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
    public function index(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();

        // Ambil semua pesan yang melibatkan dosen
        $messages = Message::where(function ($q) use ($dosen) {
                $q->where('sender_type', 'dosen')
                  ->where('sender_id', $dosen->id);
            })
            ->orWhere(function ($q) use ($dosen) {
                $q->where('receiver_type', 'dosen')
                  ->where('receiver_id', $dosen->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Group conversation untuk sidebar
        $conversations = $messages->groupBy(function ($item) use ($dosen) {
            return $item->sender_id == $dosen->id
                ? $item->receiver_id
                : $item->sender_id;
        });

        $selectedMahasiswa = $request->mahasiswa ?? null;

        $chatMessages = collect();

        if ($selectedMahasiswa) {
            $chatMessages = $messages->filter(function ($msg) use ($selectedMahasiswa) {
                return $msg->sender_id == $selectedMahasiswa ||
                       $msg->receiver_id == $selectedMahasiswa;
            });

            // 🔥 Auto mark as read
            Message::where('sender_type', 'mahasiswa')
                ->where('sender_id', $selectedMahasiswa)
                ->where('receiver_type', 'dosen')
                ->where('receiver_id', $dosen->id)
                ->where('is_read', 0)
                ->update(['is_read' => 1]);
        }

        return view('dosen_messages', compact(
            'conversations',
            'chatMessages',
            'selectedMahasiswa'
        ));
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
    public function fetch($mahasiswa_id)
    {
        $dosen = Auth::guard('dosen')->user();

        $messages = Message::where(function ($q) use ($dosen, $mahasiswa_id) {
                $q->where('sender_type', 'dosen')
                  ->where('sender_id', $dosen->id)
                  ->where('receiver_type', 'mahasiswa')
                  ->where('receiver_id', $mahasiswa_id);
            })
            ->orWhere(function ($q) use ($dosen, $mahasiswa_id) {
                $q->where('sender_type', 'mahasiswa')
                  ->where('sender_id', $mahasiswa_id)
                  ->where('receiver_type', 'dosen')
                  ->where('receiver_id', $dosen->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Auto mark as read
        Message::where('sender_type', 'mahasiswa')
            ->where('sender_id', $mahasiswa_id)
            ->where('receiver_type', 'dosen')
            ->where('receiver_id', $dosen->id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        $html = view('partials.chat_messages', compact('messages'))->render();

        return response()->json(['html' => $html]);
    }
}
