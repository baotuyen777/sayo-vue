<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
class UserController extends Controller
{
    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function index(Request $request)
    {
        $s = $request->input('s');
        $pageSize = $request->input('page_size') ?? 5;
//        return User::get();
        $rolesLabel = DB::raw('if(role < 3, "Staff", "Khách") as role_label');
        $selectStatus = DB::raw('if(status = 1, "Hoạt động", "Tạm dừng") as status_label');

        $user = User::join('departments', 'users.departments_id', '=', 'departments.id')

            ->select('users.*', 'departments.name as departments_name', 'users_status.name as users_status_name', $rolesLabel,$selectStatus)
            ->where('users.name', 'like', "%{$s}%")
            ->paginate($pageSize);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $request->merge([
            'password' => Hash::make($request['password'])
        ]);

        $user = User::create($request->all());
        return $user;
    }

    public function create()
    {
        $userStatus = DB::table('users_status')->select('id as value', 'name as label')->get();
        $department = DB::table('departments')->select('id as value', 'name as label')->get();

        return response()->json([
            'users_status' => $userStatus,
            'departments' => $department
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $userStatus = DB::table('users_status')->select('id as value', 'name as label')->get();
        $department = DB::table('departments')->select('id as value', 'name as label')->get();

        return response()->json([
            'users_status' => $userStatus,
            'departments' => $department,
            'result' => $user
        ]);
    }

    public function update(Request $request, $id)
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

        User::find($id)->update($request->all());
        $res = User::find($id);
        return response()->json(['status' => true, 'result' => $res]);
    }

}
