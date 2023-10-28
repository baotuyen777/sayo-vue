<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\Post;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Const\CommonConst;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        $this->authService = $this->authService;
    }

    public function doLogin(Request $request)
    {
        $res = $this->authService->login($request);
        if ($res['status_code'] == 200) {
            return redirect()->route('home')->with('notify', 'Đăng nhập thành công')->with('notify_type', 'success');
        }

        return redirect()->route('login')->with('notify', 'Sai tài khoản hoặc mật khẩu')->with('notify_type', 'error');


//        return view('pages/login');
    }

    public function login()
    {
//        dd(getBreadcrumb());
        return view('pages/auth/login');
    }

    public function register()
    {
        return view('pages/auth/register');
    }


    public function store(UserRequest $request)
    {

//        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'phone' => 'required|string|max:20|unique:users',
//            'password' => 'required|string',
////            'password' => 'required|string|min:8|confirmed',
////            'password_confirmation' => 'required',
//        ]);

        $user = User::create([
            'name' => $request->name,
//            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->phone,
            'password' => Hash::make($request->password),

        ]);
        return ['result' => $user, 'status' => true];
//return $user
        return redirect()->route('login')->with('notify', 'Tạo tài khoản thành công');
    }

    public function logout()
    {
//        $this->authService->logout();
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where(
                [
                    'google_id' => $user->id,
                    'email' => $user->getEmail()
                ]
            )->first();
            if ($findUser) {
                Auth::login($findUser);
                return redirect()->route('home')->with('notify', 'Đăng nhập thành công')->with('notify_type', 'success');
            } else {
                $newUser = User::create([
                    'username' => $user->getName(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->getId(),
                    'password' => encrypt(CommonConst::DEFAULT_PASSWORD),
                    'phone' => CommonConst::DEFAULT_PHONE_NUMBER,
                    'status' => CommonConst::APPROVED_STATUS,
                    'role' => 3
                ]);
                Auth::login($newUser);
                return redirect()->route('home')->with('notify', 'Đăng nhập thành công')->with('notify_type', 'success');
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
}
