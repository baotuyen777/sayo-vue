<?php

namespace App\Http\Controllers\Admin;

use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    protected BaseService $baseService;
    protected string $module = 'settings';

    public function __construct(BaseService $baseService)
    {
        $this->baseService = $baseService;
    }

    public function index(Request $request)
    {
        $s = $request->input('s');
        $currentPage = $request->input('current');
        $pageSize = $request->input('pageSize') ?? 5;
        $selectStatus = DB::raw('if(status = 1, "Hoạt động", "Tạm dừng") as status_label');
        $objs = DB::table($this->module)
            ->select('*', $selectStatus)
            ->where('name', 'like', "%{$s}%")
//            ->where('code', 'like', "%{$s}%")
            ->paginate($pageSize, ['*'], 'page', $currentPage);

        return response()->json($objs);
    }

    /**
     * show detail
     */
    public function show(string $id)
    {
        $obj = DB::table($this->module)->find($id);
        return response()->json([
            'result' => $obj,
            'status' => true
        ]);
    }

    /**
     * add new
     */
    public function store(Request $request)
    {
        $this->baseService->validate($request, $this->module);
        $obj = DB::table($this->module)->insert($request->all());
        return $obj;
    }

//    public function edit($id)
//    {
//        $state = DB::table($this->module)->find($id);
//
//        return response()->json([
//            'result' => $state,
//            'status' => true
//        ]);
//    }
    /**
     * update 1
     */
    public function update(Request $request, $id)
    {
        $this->baseService->validate($request, $this->module);
        DB::table($this->module)->where('id', $id)->update($request->all());

        $res = DB::table($this->module)->find($id);
        return response()->json(['status' => true, 'result' => $res]);
    }

    public function destroy($id)
    {
        $res = DB::table($this->module)->where('id', $id)->delete();
        return response()->json(['status' => true, 'result' => $res]);
    }
}
