<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    protected string $module = 'categories';
    private BaseService $baseService;
    public function __construct(BaseService $baseService)
    {
        $this->baseService = $baseService;
    }
    public function index(Request $request)
    {
        $s = $request->input('s');
        $currentPage = $request->input('current');
        $pageSize = $request->input('page_size') ?? 5;
        $selectStatus = DB::raw('if(status = 1, "Hoạt động", "Tạm dừng") as status_label');
        $objs = Category::select('*', $selectStatus)
            ->where('name', 'like', "%{$s}%")
            ->where('code', 'like', "%{$s}%")
            ->with('avatar')
            ->paginate($pageSize, ['*'], 'page', $currentPage);
        return response()->json($objs);
    }

    public function show($id)
    {
        $obj = Category::with('avatar')->find($id);

        return response()->json([
            'result' => $obj,
            'status' => true
        ]);
    }
    public function store(Request $request)
    {
        $this->baseService->validate($request, $this->module, ['code' => 'required|unique:categories']);
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

//    public function update(Request $request, $id)
//    {
//        $this->baseService->validate($request, $this->module);
//        DB::table($this->module)->where('id', $id)->update($request->all());
//
//        $res = DB::table($this->module)->find($id);
//        return response()->json(['status' => true, 'result' => $res]);
//    }

    public function update(Request $request, $id)
    {
//        $this->baseService->validate($request, $this->module,  ['code' => 'required']);
//        $state = Category::find($id);

        $params = $request->except(['media_ids']);

        $res = Category::where('id', $id)->update($params);

        return response()->json(['status' => true, 'result' => $res]);
    }


}
