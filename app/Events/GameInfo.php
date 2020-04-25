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

class GameInfo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameInstanceId;

    public function __construct($gameInstanceId)
    {
        $this->gameInstanceId = $gameInstanceId;
    }
    
    public function broadcastOn()
    {
        return new Channel('game');
    }

    public function broadcastWith()
    {
        $gameInstance = \App\Models\GameInstance::where('id', $this->gameInstanceId)->first();
        return ['gameInfo' => $gameInstance->game_info];
    }

    public function broadcastAs()
    {
        return 'GameInfo';
    }
}
