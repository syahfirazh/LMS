<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SessionUpdated
{
    public $description;
    public $sessionId;

    public function broadcastOn()
    {
        return new Channel('session.' . $this->sessionId);
    }

    public function broadcastAs()
    {
        return 'session.updated';
    }
}
