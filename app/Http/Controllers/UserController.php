<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function index()
    {
//        return User::get();
        $user = User::join('departments', 'users.departments_id', '=', 'departments.id')
            ->join('users_status', 'users.status_id', '=', 'users_status.id')
            ->select('users.*', 'departments.name as departments_name', 'users_status.name as users_status_name ')
            ->paginate();
        return response()->json($user);
    }

    public function store(Request $request)
    {
//        $validate = $request->validate([
//            'status_id' => 'required',
//            'username' => 'required|unique:users,username',
//            'name' => 'required',
//            'email' => 'required|email',
//            'department_id' => 'required',
//            'password' => 'required|confirmed',
//        ], [
//            'status.required' => 'Vui lòng nhập tình trạng',
//            'username.required' => 'Nhập tên đăng nhập',
//            'username.unique' => 'Tên đăng nhập đã tồn tại',
//            'name.required' => 'Vui lòng nhập họ tên',
//            'email.required' => 'Vui lòng nhập email',
//            'email.email' => 'Email không đúng định dạng',
//            'department_id.required' => 'Vui lòng nhập phòng ban',
//            'password.required' => 'Vui lòng nhập mật khẩu',
//            'password.confirmed' => 'Mật khẩu nhập lại không khớp',
//        ]);

        $request->merge([
            'password' => Hash::make($request['password'])
        ]);
        $user = User::create($request->all());
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
        $user = User::findOrFail($id);
        $userStatus = \DB::table('users_status')->select('id as value', 'name as label')->get();
        $department = \DB::table('departments')->select('id as value', 'name as label')->get();

        return response()->json([
            'users_status' => $userStatus,
            'departments' => $department,
            'result' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        User::find($id)->update($request->all());
    }

}
