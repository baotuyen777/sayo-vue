<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Posts;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        $this->authService = $this->authService;
    }

    public function login()
    {
        return view('pages/login');
    }
    public function doLogin(Request $request)
    {
        $this->authService->login($request);
        return redirect()->route('home');
//        return view('pages/login');
    }

    public function register()
    {
        return view('pages/login');
    }

    public function logout()
    {
//        $this->authService->logout();
        Auth::guard('web')->logout();
        return redirect()->route('home');
//        return view('pages/login');
    }


}
