<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Http\Requests\UserRequest;
use App\Models\Settings;
use App\Models\User;
use App\Services\BaseServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends CommonController
{
    protected string $module = 'settings';
//    public function __construct(BaseServices $baseServices)
//    {
//        parent::__construct($baseServices);
//        $this->module = 'settings';
//    }
    /**
     * Display a listing of the resource.
     */
//    public function index(Request $request)
//    {
//       return parent::index($request);
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->baseServices->validate($request, $this->module, ['code' => 'required|unique:settings', 'value' => 'required']);
        $obj = Settings::create($request->all());
        return $obj;
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $obj = Settings::findOrFail($id);

        return response()->json([
            'result' => $obj,
            'status' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->baseServices->validate($request, $this->module);
        Settings::find($id)->update($request->all());
        $res = Settings::find($id);
        return response()->json(['status' => true, 'result' => $res]);
    }


}
