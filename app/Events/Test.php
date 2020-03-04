<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Redis\GameInstance;

class Test implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data = [];

    public function __construct($id)
    {
        $this->data = [
            'current_user' => $id
        ];
    }
    
    public function broadcastOn()
    {
        return new Channel('testing');
    }

    public function broadcastAs()
    {
        return 'testing';
    }
}
