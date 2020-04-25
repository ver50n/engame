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
            'id' => $gameInstanceId,
            'is_active' => 1
        ])->firstOrFail();
        $viewName = 'yes_no';

        switch($game->id) {
            case 1:
                $viewName = 'yes_no';
                break;
            case 2:
                $viewName = 'open_question';
                break;
            case 3:
                $viewName = 'describe_picture';
                break;
        } 
        return view("games.$viewName.board", [
            'game' => $game
        ]);
    }

    public function join(Request $request)
    {
        $gameInstanceId = $request->gameInstanceId;

        $game = \App\Models\Game::where([
            'id' => $gameInstanceId,
            'is_active' => 1
        ])->firstOrFail();
        $gameInstance = \App\Models\GameInstance::joinGame($game, $gameInstanceId);

        event(new \App\Events\GameInfo($gameInstanceId));
    }

    public function ready(Request $request)
    {
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInstance = $gameInstance->readyGame();

        event(new \App\Events\GameInfo($gameInstanceId));
    }

    public function reset(Request $request)
    {
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInstance = $gameInstance->delete();

        event(new \App\Events\GameReset());
    }

    public function newRound(Request $request)
    {
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInstance = $gameInstance->newRound();
    }

    public function ask(Request $request)
    {
        $data = $request->all();
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInstance = $gameInstance->ask($data);

        event(new \App\Events\GameInfo($gameInstanceId));
    }

    public function chat(Request $request)
    {
        $data = $request->all();
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        
        $gameInstance = $gameInstance->chat($data['chat']);

        event(new \App\Events\GameInfo($gameInstanceId));
    }

    public function answer(Request $request)
    {
        $data = $request->all();
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $result = $gameInstance->answer($data);

        if($result)
            event(new \App\Events\BroadCastWinner($gameInstanceId));
        else
            event(new \App\Events\GameInfo($gameInstanceId));

        return json_encode($result);
    }

    public function dHint(Request $request)
    {
        $data = $request->all();
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInfo = json_decode($gameInstance->game_info, true);
        $gameInstance = $gameInstance->dHintOpenText($data);

        event(new \App\Events\GameInfo($gameInstanceId));
    }

    public function disconnect(Request $request)
    {
        $gameInstanceId = $request->gameInstanceId;
        $gameInstance = \App\Models\GameInstance::find($gameInstanceId);
        $gameInstance = $gameInstance->leaveGame();

        event(new \App\Events\GameInfo($gameInstanceId));
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
