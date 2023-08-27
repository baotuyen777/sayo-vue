<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Posts;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        $this->authService = $this->authService;
    }

    public function doLogin(Request $request)
    {
        $this->authService->login($request);
        return redirect()->route('home');
//        return view('pages/login');
    }

    public function login()
    {
        return view('pages/login');
    }

    public function register()
    {
        return view('pages/login');
    }

    public function profile()
    {
        return view('pages/login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string',
//            'password' => 'required|string|min:8|confirmed',
//            'password_confirmation' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->phone,
            'password' => Hash::make($request->password),

        ]);

        return redirect()->route('login')->with('success', 'Tạo tài khoản thành công');
    }

    public function logout()
    {
//        $this->authService->logout();
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }


}
