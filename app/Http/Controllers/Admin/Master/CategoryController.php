<?php
namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Models\CategoryLanguage;

class CategoryController extends Controller
{
    public $routePrefix = 'admin.master.category';
    public $viewPrefix = 'admin.pages.master.category';

    public function list(Request $request)
    {
        $obj = new Category();
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
        $obj = new Category();

        return view($this->viewPrefix.'.create', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $obj = new Category();
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
        $obj = Category::findOrFail($request->id);
        $objLanguages = $obj->categoryLanguages;

        return view($this->viewPrefix.'.update', [
            'obj' => $obj,
            'objLanguages' => $objLanguages,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $obj = Category::findOrFail($request->id);
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
        $obj = Category::find($request->id);

        return view($this->viewPrefix.'.view', [
            'obj' => $obj,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function delete(Request $request)
    {
        $obj = Category::find($request->id);
        $obj->remove();

        return redirect()->route($this->routePrefix.'.list')
            ->with('success', 'data-process-complete');
    }

    public function saveLanguage(Request $request)
    {
        $id = $request->id;
        $languageCode = $request->language_code;
        $data = $request->all();

        $obj = CategoryLanguage::where([
            ['category_id', $id],
            ['language_code', $languageCode]
        ])->first();
        if(!$obj)
            $obj = new CategoryLanguage();

        $obj->fill($data);
        $obj->save();

        return redirect()->back()
            ->with('success', 'data-process-complete');
    }
}
