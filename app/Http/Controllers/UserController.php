<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
class UserController extends Controller
{
    public function show($id)
    {
        return Users::findOrFail($id);
    }

    public function index(Request $request)
    {
        $s = $request->input('s');
        $pageSize = $request->input('page_size') ?? 5;
//        return User::get();
        $user = Users::join('departments', 'users.departments_id', '=', 'departments.id')
            ->join('users_status', 'users.status_id', '=', 'users_status.id')
            ->select('users.*', 'departments.name as departments_name', 'users_status.name as users_status_name ')
            ->where('users.name', 'like', "%{$s}%")
            ->paginate($pageSize);
        return response()->json($user);
    }

    public function store(UserRequest $request)
    {
        $request->merge([
            'password' => Hash::make($request['password'])
        ]);

        $user = Users::create($request->all());
        return $user;
    }

    public function create()
    {
        $userStatus = \DB::table('users_status')->select('id as value', 'name as label')->get();
        $department = \DB::table('departments')->select('id as value', 'name as label')->get();

        return response()->json([
            'users_status' => $userStatus,
            'departments' => $department
        ]);
    }

    public function edit($id)
    {
        $user = Users::findOrFail($id);
        $userStatus = \DB::table('users_status')->select('id as value', 'name as label')->get();
        $department = \DB::table('departments')->select('id as value', 'name as label')->get();

        return response()->json([
            'users_status' => $userStatus,
            'departments' => $department,
            'result' => $user
        ]);
    }

    public function update(UserRequest $request, $id)
    {
//        $request->merge([
//            'password' => Hash::make($request['password'])
//        ]);
        if ($request->input('change_password')) {
            $request->merge([
                'password' => Hash::make($request['password']),
                'change_password_at' => Carbon::now()
            ]);
        }

        Users::find($id)->update($request->all());
        $res = Users::find($id);
        return response()->json(['status' => true, 'result' => $res]);
    }

}
