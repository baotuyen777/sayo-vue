<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends CommonController
{
    protected string $module = 'orders';
    public function index(Request $request)
    {
        $s = $request->input('s');
        $pageSize = $request->input('page_size') ?? 5;
        $selectStatus = DB::raw('if(status = 1, "Hoạt động", "Tạm dừng") as status_label');
        $objs = DB::table($this->module)
            ->select('*', $selectStatus)
//            ->where('code', 'like', "%{$s}%")
            ->paginate($pageSize);

        return response()->json($objs);
    }

}
