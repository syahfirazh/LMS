<?php

namespace App\Events;

use App\Models\Discussion;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Gunakan 'Now' agar instan
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiscussionCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $discussion;

    /**
     * Create a new event instance.
     */
    public function __construct(Discussion $discussion)
    {
        // Load relasi sender agar nama/foto pengirim terbawa ke Frontend (JavaScript)
        $this->discussion = $discussion->load('sender');
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        // Menggunakan PrivateChannel agar hanya yang di kelas itu yang bisa melihat
        return new PrivateChannel('session.' . $this->discussion->session_id);
    }

    /**
     * Alias event yang akan ditangkap oleh Laravel Echo di frontend
     */
    public function broadcastAs()
    {
        return 'discussion.created';
    }
}