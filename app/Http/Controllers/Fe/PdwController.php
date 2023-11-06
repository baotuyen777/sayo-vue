<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Models\Pdw\District;
use App\Models\Pdw\Ward;

class PdwController extends Controller
{
    public function getDistricts($provinceId)
    {
        $objs =  District::whereProvinceId($provinceId ?? 1)->get();
        return response()->json([
            'result' => $objs,
            'status' => true
        ]);
    }
    public function getWards($districtId)
    {
        $objs =  Ward::whereDistrictId($districtId ?? 50)->get();
        return response()->json([
            'result' => $objs,
            'status' => true
        ]);
    }


}
