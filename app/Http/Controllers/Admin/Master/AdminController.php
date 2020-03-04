<?php
namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Admin;

class AdminController extends Controller
{
    public $routePrefix = 'admin.master.admin';
    public $viewPrefix = 'admin.pages.master.admin';

    public function list(Request $request)
    {
        $obj = new Admin();
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
        $obj = new Admin();

        return view($this->viewPrefix.'.create', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $obj = new Admin();
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
        $obj = Admin::findOrFail($request->id);

        return view($this->viewPrefix.'.update', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $obj = Admin::findOrFail($request->id);
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
        $obj = Admin::find($request->id);

        return view($this->viewPrefix.'.view', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function delete(Request $request)
    {
      $obj = Admin::find($request->id);
      $obj->remove();

      return redirect()->route($this->routePrefix.'.list')
          ->with('success', 'data-process-complete');
    }
}
