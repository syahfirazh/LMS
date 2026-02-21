<?php

namespace App\Events;

use App\Models\Materi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class MateriCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $materi;
    public $sessionId;

    public function __construct($materi, $sessionId)
    {
        $this->materi = $materi;
        $this->sessionId = $sessionId;
    }

    public function broadcastOn()
    {
        return new Channel('session.' . $this->sessionId);
    }

    public function broadcastAs()
    {
        return 'materi.created';
    }
}