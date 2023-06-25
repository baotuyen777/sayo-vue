<?php

namespace App\Http\Controllers;

use App\Services\BaseServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function __construct(BaseServices $baseServices)
    {
        $this->baseServices = $baseServices;
        $this->module = 'categories';
    }

    public function store(Request $request)
    {
        $this->baseServices->validate($request, $this->module, ['code' => 'required|unique:categories']);
        $obj = DB::table($this->module)->insert($request->all());
        return $obj;
    }

    public function edit($id)
    {
        $obj = DB::table($this->module)->find($id);

        return response()->json([
            'result' => $obj,
            'status' => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->baseServices->validate($request, $this->module);
        DB::table($this->module)->where('id', $id)->update($request->all());

        $res = DB::table($this->module)->find($id);
        return response()->json(['status' => true, 'result' => $res]);
    }


}
