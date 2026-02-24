<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Dosen;

class MahasiswaMessageController extends Controller
{
    /**
     * Helper: Mengambil daftar kontak dosen di Sidebar
     */
    private function getConversations($mahasiswaId)
    {
        $allMessages = Message::where(function($q) use ($mahasiswaId) {
            $q->where('sender_type', 'mahasiswa')->where('sender_id', $mahasiswaId);
        })->orWhere(function($q) use ($mahasiswaId) {
            $q->where('receiver_type', 'mahasiswa')->where('receiver_id', $mahasiswaId);
        })->orderBy('created_at', 'desc')->get();

        $conversations = [];
        foreach ($allMessages as $msg) {
            // Tentukan ID lawan bicara (Dosen)
            $dosenId = ($msg->sender_type === 'dosen') ? $msg->sender_id : $msg->receiver_id;
            
            // Simpan pesan terakhir per dosen untuk sidebar preview
            if (!isset($conversations[$dosenId])) {
                $conversations[$dosenId] = collect([$msg]);
            }
        }
        
        return $conversations;
    }

    /**
     * Tampilkan halaman awal Pesan (Daftar Kontak Saja)
     */
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $conversations = $this->getConversations($mahasiswa->id);
        
        return view('messages', compact('conversations'));
    }

    /**
     * Buka obrolan dengan dosen tertentu
     */
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

        // Tandai pesan dari dosen ini sebagai sudah dibaca
        Message::where('sender_type', 'dosen')
           ->where('sender_id', $dosenId)
           ->where('receiver_type', 'mahasiswa')
           ->where('receiver_id', $mahasiswa->id)
           ->where('is_read', 0)
           ->update(['is_read' => 1]);

        $dosen = $dosenId; // Kirim ID dosen yang sedang aktif ke view

        return view('messages', compact('conversations', 'chatMessages', 'dosen'));
    }

    /**
     * Kirim pesan ke dosen
     */
    public function send(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required',
                'body'        => 'nullable|string',
                'image'       => 'nullable|image|max:2048',
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

            // TRIGGER EVENT PUSHER (Jika Pusher sudah aktif)
            // broadcast(new \App\Events\MessageSent($message))->toOthers();

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
}