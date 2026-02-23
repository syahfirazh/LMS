<?php

namespace App\Events;

use App\Models\Discussion;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class DiscussionCreated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $discussion;

    public function __construct(Discussion $discussion)
    {
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
}