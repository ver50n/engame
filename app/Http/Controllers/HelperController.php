<?php

namespace App\Http\Controllers;

use App;
use Session;
use Lang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HelperController extends Controller
{
    public function changeRowPerPage(Request $request)
    {
        $rowPerPage = $request->input('rpp');
        Session::put('rowPerPage', $rowPerPage);

        return Response()->json([
            'success' => true
        ]);
    }

    function changeLocale(Request $request)
    {
        $locale = $request->input('locale');
        \App::setLocale($locale);
        \Session::put('locale', $locale);
        \Session::save();

        return Response()->json([
            'success' => true
        ]);
    }

    function export(Request $request)
    {
        $request = $request->all();
        $export = new \App\Helpers\ExportUtil('csv');
        $model = '\\App\\Models\\'.$request['model'];
        $objClass = new $model();
        $options = [
            'file_name' => $objClass->table,
        ];

        $filters = (isset($request['filters'])) ? $request['filters'] : [];
        $data = $objClass->filter($filters, []);
        $data = $objClass->csvFormatter($data->toArray());

        $export->exportCsv($data, $options);
    }

    function activate(Request $request)
    {
        $id = $request->id;
        $request = $request->all();
        $model = '\\App\\Models\\'.$request['model'];

        $obj = $model::find($id);
        $obj->is_active = ($obj->is_active == 0) ? 1 : 0;
        $obj->save();

        return redirect()->back()
            ->with('success', 'data-process-complete');
    }
}
