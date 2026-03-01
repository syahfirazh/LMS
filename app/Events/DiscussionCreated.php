<?php

namespace App\Events;

use App\Models\Discussion;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiscussionCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $discussion;

    public function __construct(Discussion $discussion)
    {
        // Tetap load relasi
        $this->discussion = $discussion->load('sender');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('session.' . $this->discussion->session_id);
    }

    public function broadcastAs()
    {
        return 'discussion.created';
    }

    /**
     * [PERBAIKAN] Tentukan data spesifik yang akan dibroadcast.
     * Ini mencegah error Payload/Serialization pada sistem Realtime.
     */
    public function broadcastWith()
    {
        $fotoPath = $this->discussion->sender->foto_profil ?? $this->discussion->sender->foto ?? null;

        return [
            'discussion' => [
                'id'            => $this->discussion->id,
                'session_id'    => $this->discussion->session_id,
                'message'       => $this->discussion->message,
                'image'         => $this->discussion->image ? asset('storage/' . $this->discussion->image) : null,
                'voice'         => $this->discussion->voice ? asset('storage/' . $this->discussion->voice) : null,
                'time'          => $this->discussion->created_at->format('H:i'),
                'sender_name'   => $this->discussion->sender->nama ?? 'User',
                'sender_type'   => $this->discussion->sender_type,
                'sender_avatar' => $fotoPath ? asset('storage/' . $fotoPath) : null,
            ]
        ];
    }
}