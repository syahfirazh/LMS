<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Mahasiswa;
use App\Models\Notification;
use App\Events\MessageSent; 

class DosenMessageController extends Controller
{
    private function getConversations($dosenId)
    {
        $allMessages = Message::where(function($q) use ($dosenId) {
            $q->where('sender_type', 'dosen')->where('sender_id', $dosenId);
        })->orWhere(function($q) use ($dosenId) {
            $q->where('receiver_type', 'dosen')->where('receiver_id', $dosenId);
        })->orderBy('created_at', 'desc')->get();

        $conversations = [];
        foreach ($allMessages as $msg) {
            $mahasiswaId = ($msg->sender_type === 'mahasiswa') ? $msg->sender_id : $msg->receiver_id;
            
            if (!isset($conversations[$mahasiswaId])) {
                $conversations[$mahasiswaId] = collect([$msg]);
            }
        }
        return $conversations;
    }

    public function index(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();
        $conversations = $this->getConversations($dosen->id);
        
        return view('dosen_messages', compact('conversations')); 
    }

    public function show(Request $request, $mahasiswa)
    {
        $dosen = Auth::guard('dosen')->user();
        $conversations = $this->getConversations($dosen->id); 

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

        return view('dosen_messages', compact('chatMessages', 'mahasiswa', 'conversations'));
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required',
                'body' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'voice' => 'nullable|mimes:webm,mp3,wav,ogg|max:5120'
            ]);

            $dosen = Auth::guard('dosen')->user();
            
            if (!$dosen) {
                return response()->json(['success' => false, 'error' => 'Sesi Dosen tidak ditemukan.']);
            }

            $imagePath = null;
            $voicePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('chat/images', 'public');
            }

            if ($request->hasFile('voice')) {
                $voicePath = $request->file('voice')->store('chat/voices', 'public');
            }

            if (!$request->body && !$imagePath && !$voicePath) {
                return response()->json(['success' => false, 'error' => 'Pesan tidak boleh kosong.']);
            }

            $message = Message::create([
                'sender_type'   => 'dosen',
                'sender_id'     => $dosen->id,
                'receiver_type' => 'mahasiswa',
                'receiver_id'   => $request->receiver_id,
                'body'          => $request->body ?? '', 
                'image_path'    => $imagePath,
                'voice_path'    => $voicePath,
                'is_read'       => 0
            ]);

            broadcast(new MessageSent($message))->toOthers();

            // NOTIF KE MAHASISWA (Teks Sederhana & Penambahan mahasiswa_id)
            try {
                Notification::create([
                    'user_id'      => $request->receiver_id,
                    'user_type'    => 'mahasiswa',
                    'mahasiswa_id' => $request->receiver_id, // <--- Ini kunci agar datanya bisa terbaca oleh mahasiswa
                    'type'         => 'info',
                    'title'        => 'Pesan',
                    'message'      => 'Ada 1 pesan masuk.',
                    'url'          => route('messages.show', ['dosen' => $dosen->id]),
                    'is_read'      => false,
                ]);
            } catch (\Exception $notifErr) {
                \Illuminate\Support\Facades\Log::error("Gagal kirim notif chat dosen: " . $notifErr->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => [
                    'id'          => $message->id,
                    'sender_type' => $message->sender_type,
                    'body'        => $message->body,
                    'image_path'  => $message->image_path,
                    'voice_path'  => $message->voice_path,
                    'time'        => $message->created_at->format('H:i') 
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'System Error: ' . $e->getMessage()]);
        }
    }

    public function fetch(Request $request, $mahasiswa)
    {
        $dosen = Auth::guard('dosen')->user();
        $lastId = $request->query('last_id', 0);

        $newMessages = Message::where(function($query) use ($dosen, $mahasiswa) {
                $query->where(function ($q) use ($dosen, $mahasiswa) {
                    $q->where('sender_type', 'dosen')->where('sender_id', $dosen->id)->where('receiver_type', 'mahasiswa')->where('receiver_id', $mahasiswa);
                })->orWhere(function ($q) use ($dosen, $mahasiswa) {
                    $q->where('sender_type', 'mahasiswa')->where('sender_id', $mahasiswa)->where('receiver_type', 'dosen')->where('receiver_id', $dosen->id);
                });
            })
            ->where('id', '>', $lastId) 
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id'          => $msg->id,
                    'sender_type' => $msg->sender_type,
                    'body'        => $msg->body,
                    'image_path'  => $msg->image_path,
                    'voice_path'  => $msg->voice_path,
                    'time'        => $msg->created_at->format('H:i')
                ];
            });

        if ($newMessages->count() > 0) {
            Message::where('sender_type', 'mahasiswa')
               ->where('sender_id', $mahasiswa)
               ->where('receiver_type', 'dosen')
               ->where('receiver_id', $dosen->id)
               ->where('id', '>', $lastId)
               ->update(['is_read' => 1]);
        }

        return response()->json(['messages' => $newMessages]);
    }

    public function searchStudents(Request $request)
    {
        $keyword = $request->query('q');

        if (empty($keyword)) {
            return response()->json([]);
        }

        $students = Mahasiswa::where('nama', 'like', "%{$keyword}%")
                        ->orWhere('nim', 'like', "%{$keyword}%") 
                        ->limit(10)
                        ->get(['id', 'nama', 'nim']); 

        return response()->json($students);
    }
}