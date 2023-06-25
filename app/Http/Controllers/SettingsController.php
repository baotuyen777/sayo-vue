<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Http\Requests\UserRequest;
use App\Models\Settings;
use App\Models\Users;
use App\Services\BaseServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{

    public function __construct(BaseServices $baseServices)
    {
        $this->baseServices = $baseServices;
        $this->module = 'settings';
    }
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

    public function show(string $id)
    {
        return Settings::findOrFail($id);
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
