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

    public $data = [];

    public function __construct($game)
    {
        $this->data = [
            'gameId' => $game->id,
            'gameName' => $game->name,
            'gameDescription' => $game->description,
            'totalUser' => 0,
            'dUser' => 'aaa@gmail.com'
        ];
    }
    
    public function broadcastOn()
    {
        return new Channel('game');
    }

    public function broadcastAs()
    {
        return 'GameInfo';
    }
}
