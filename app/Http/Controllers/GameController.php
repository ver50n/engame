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
        $id = $request->id;
        $game = \App\Models\Game::where([
            'id' => $id,
            'is_active' => 1
        ])->firstOrFail();

        event(new \App\Events\GameInfo($game));

        return view('games.board', [
            'game' => $game
        ]);
    }

    public function info(Request $request)
    {
        $id = $request->id;
        $game = \App\Models\Game::where([
            'id' => $id,
            'is_active' => 1
        ])->firstOrFail();

        event(new \App\Events\GameInfo($game));
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
