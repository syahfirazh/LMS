<?php

namespace App\Events;

use App\Models\Message; // Sesuaikan jika kamu menggunakan model SessionMessage
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        // Menyimpan data pesan ke variabel public agar bisa dikirim ke frontend
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Pastikan nama channel sesuai dengan tempat Dosen/Mahasiswa mengobrol.
        // Asumsi saya, obrolan ini per kelas. Sesuaikan field 'kelas_id' dengan tabelmu.
        return [
            new PrivateChannel('chat.kelas.' . $this->message->kelas_id),
        ];
    }

    /**
     * Nama event yang akan didengarkan oleh frontend (opsional tapi disarankan biar rapi)
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}