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

class BroadCastWinner implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameInfo;

    public function __construct($gameInstance)
    {
        $this->gameInfo = $gameInstance;
    }
    
    public function broadcastOn()
    {
        return new Channel('game');
    }

    public function broadcastWith()
    {
        $gameInstance = \App\Models\GameInstance::where('id', 1)->first();

        $gameInfo = json_decode($gameInstance->game_info, true);
        $winner = $gameInfo['curr_round']['winner']." WIN!!";

        return ['winner' => $winner];
    }

    public function broadcastAs()
    {
        return 'BroadCastWinner';
    }
}
