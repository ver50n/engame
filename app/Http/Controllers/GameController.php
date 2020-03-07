<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GameController extends Controller
{
    public function selection()
    {
        $games = \App\Models\Game::where('is_active', 1)->get();

        return view('games.selection', [
            'games' => $games
        ]);
    }

    public function board(Request $request)
    {
        $gameInstanceId = $request->gameInstanceId;
        $game = \App\Models\Game::where([
            'id' => 1,
            'is_active' => 1
        ])->firstOrFail();

        return view('games.board', [
            'game' => $game
        ]);
    }

    public function join(Request $request)
    {
        $gameInstanceId = $request->gameInstanceId;

        $game = \App\Models\Game::where([
            'id' => 1,
            'is_active' => 1
        ])->firstOrFail();
        $gameInstance = \App\Models\GameInstance::joinGame($game, $gameInstanceId);

        event(new \App\Events\GameInfo($gameInstance));
    }

    public function ready(Request $request)
    {
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInstance = $gameInstance->readyGame();

        event(new \App\Events\GameInfo($gameInstance));
    }
    
    public function ask(Request $request)
    {
        $data = $request->all();
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInstance = $gameInstance->ask($data);

        event(new \App\Events\GameInfo($gameInstance));
    }

    public function answer(Request $request)
    {
        $data = $request->all();
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $result = $gameInstance->answer($data);
        echo $result;

        event(new \App\Events\GameInfo($gameInstance));
    }

    public function dHint(Request $request)
    {
        $data = $request->all();
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInfo = json_decode($gameInstance->game_info, true);
        $gameInstance = $gameInstance->dHint($data);

        event(new \App\Events\GameInfo($gameInstance));
    }

    public function disconnect(Request $request)
    {
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInstance = $gameInstance->leaveGame();

        event(new \App\Events\GameInfo($gameInstance));
    }

    public function getQuestion(Request $request)
    {
        $id = $request->id;
        $question = \App\Models\Question::where([
            'game_id' => $id,
            'is_active' => 1
        ])->inRandomOrder()->first();

        event(new \App\Events\GetQuestion($question));
    }

    public function welcome(Request $request)
    {
        event(new \App\Events\Test(1));
        return view('welcome');
    }
}
