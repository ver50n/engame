<?php
namespace App\Http\Controllers\Admin\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Game;

class GameController extends Controller
{
    public $routePrefix = 'admin.game.game';
    public $viewPrefix = 'admin.pages.game.game';

    public function list(Request $request)
    {
        $obj = new Game();
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
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function create()
    {
        $obj = new Game();

        return view($this->viewPrefix.'.create', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $obj = new Game();
        $result = $obj->add($data);

        if($result === true)
            return redirect()->route($this->routePrefix.'.list')
                ->with('success', 'data-process-complete');

        return redirect()
            ->back()
            ->withInput($data)
            ->withErrors($result);
    }

    public function update(Request $request)
    {
        $obj = Game::findOrFail($request->id);

        return view($this->viewPrefix.'.update', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $obj = Game::findOrFail($request->id);
        $result = $obj->edit($data);

        if($result === true)
            return redirect()->back()
                ->with('success', 'data-process-complete');

        return redirect()
            ->back()
            ->withInput($data)
            ->withErrors($result);
    }

    public function view(Request $request)
    {
        $obj = Game::find($request->id);

        return view($this->viewPrefix.'.view', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function delete(Request $request)
    {
        $obj = Game::find($request->id);
        $obj->remove();

        return redirect()->route($this->routePrefix.'.list')
            ->with('success', 'data-process-complete');
    }
}
