<?php
namespace App\Http\Controllers\Admin\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Question;

class QuestionController extends Controller
{
    public $routePrefix = 'admin.game.question';
    public $viewPrefix = 'admin.pages.game.question';

    public function list(Request $request)
    {
        $obj = new Question();
        $gameId = $request->gameId;
        $filters = $request->query('filters');
        $page = $request->query('page');
        if($filters)
          $obj->fill($filters);
        $data = $obj->filter($filters, [
            'pagination' => true,
            'page' => $page
        ]);

        return view($this->viewPrefix.'.list', [
            'obj' => $obj,
            'data' => $data,
            'routePrefix' => $this->routePrefix,
            'gameId' => $gameId,
        ]);
    }

    public function create(Request $request)
    {
        $obj = new Question();
        $gameId = $request->gameId;

        return view($this->viewPrefix.'.create', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix,
            'gameId' => $gameId,
        ]);
    }

    public function add(Request $request)
    {
        $gameId = $request->gameId;
        $data = $request->all();
        $data['game_id'] = $gameId;

        $obj = new Question();
        $result = $obj->add($data);

        if($result === true)
            return redirect()->route($this->routePrefix.'.list', [
                'gameId' => $gameId,
            ])->with('success', 'data-process-complete');

        return redirect()
            ->back()
            ->withInput($data)
            ->withErrors($result);
    }

    public function update(Request $request)
    {
        $gameId = $request->gameId;
        $obj = Question::findOrFail($request->id);

        return view($this->viewPrefix.'.update', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix,
            'gameId' => $gameId,
        ]);
    }

    public function edit(Request $request)
    {
        $gameId = $request->gameId;
        $data = $request->all();
        $data['game_id'] = $gameId;

        $obj = Question::findOrFail($request->id);
        $result = $obj->edit($data);

        if($result === true)
            return redirect()->back()
                ->with('success', 'data-process-complete');

        return redirect()
            ->back()
            ->withInput($data)
            ->withErrors($result);
    }

    public function addOption(Request $request)
    {
      $gameId = $request->gameId;
      $id = $request->id;
      $data = $request->all();

      $obj = Question::findOrFail($request->id);
      $result = $obj->addOptions($data);

      if($result === true)
          return redirect()->back()
              ->with('success', 'data-process-complete');

      return redirect()
          ->back()
          ->withInput($data)
          ->withErrors($result);
    }
}
