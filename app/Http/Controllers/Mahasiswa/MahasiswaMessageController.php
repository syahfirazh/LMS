<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Dosen;
use App\Models\DosenNotification;

class MahasiswaMessageController extends Controller
{
    private function getConversations($mahasiswaId)
    {
        $allMessages = Message::where(function($q) use ($mahasiswaId) {
            $q->where('sender_type', 'mahasiswa')->where('sender_id', $mahasiswaId);
        })->orWhere(function($q) use ($mahasiswaId) {
            $q->where('receiver_type', 'mahasiswa')->where('receiver_id', $mahasiswaId);
        })->orderBy('created_at', 'desc')->get();

        $conversations = [];
        foreach ($allMessages as $msg) {
            $dosenId = ($msg->sender_type === 'dosen') ? $msg->sender_id : $msg->receiver_id;
            
            if (!isset($conversations[$dosenId])) {
                $conversations[$dosenId] = collect([$msg]);
            }
        }
        
        return $conversations;
    }

    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $conversations = $this->getConversations($mahasiswa->id);
        
        return view('messages', compact('conversations'));
    }

    public function show($dosenId)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $conversations = $this->getConversations($mahasiswa->id);

        $chatMessages = Message::where(function ($q) use ($mahasiswa, $dosenId) {
                $q->where('sender_type', 'mahasiswa')
                  ->where('sender_id', $mahasiswa->id)
                  ->where('receiver_type', 'dosen')
                  ->where('receiver_id', $dosenId);
            })
            ->orWhere(function ($q) use ($mahasiswa, $dosenId) {
                $q->where('sender_type', 'dosen')
                  ->where('sender_id', $dosenId)
                  ->where('receiver_type', 'mahasiswa')
                  ->where('receiver_id', $mahasiswa->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        Message::where('sender_type', 'dosen')
           ->where('sender_id', $dosenId)
           ->where('receiver_type', 'mahasiswa')
           ->where('receiver_id', $mahasiswa->id)
           ->where('is_read', 0)
           ->update(['is_read' => 1]);

        $dosen = $dosenId; 

        return view('messages', compact('conversations', 'chatMessages', 'dosen'));
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required',
                'body'        => 'nullable|string',
                // [PERBAIKAN] Mendukung semua format gambar dan ukuran hingga 5MB
                'image'       => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,svg,bmp,heic,heif|max:5120',
                'voice'       => 'nullable|mimes:webm,mp3,wav,ogg|max:5120'
            ]);

            $mahasiswa = Auth::guard('mahasiswa')->user();
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
                'sender_type'   => 'mahasiswa',
                'sender_id'     => $mahasiswa->id,
                'receiver_type' => 'dosen',
                'receiver_id'   => $request->receiver_id,
                'body'          => $request->body ?? '',
                'image_path'    => $imagePath,
                'voice_path'    => $voicePath,
                'is_read'       => 0
            ]);

            try {
                DosenNotification::create([
                    'dosen_id' => $request->receiver_id,
                    'type'     => 'info',
                    'title'    => 'Pesan',
                    'message'  => 'Ada 1 pesan masuk.',
                    'url'      => route('dosen.messages.show', ['mahasiswa' => $mahasiswa->id]),
                    'is_read'  => false,
                ]);
            } catch (\Exception $notifErr) {
                \Illuminate\Support\Facades\Log::error("Gagal kirim notif chat mahasiswa: " . $notifErr->getMessage());
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

    public function search(Request $request)
    {
        $keyword = $request->get('q');
        
        if (!$keyword) {
            return response()->json([]);
        }

        $dosens = Dosen::where('nama', 'LIKE', "%{$keyword}%")
                       ->select('id', 'nama')
                       ->limit(10) 
                       ->get();

        return response()->json($dosens);
    }
}