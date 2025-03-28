<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

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
            if (session()->get('url_redirect')) {
//                return redirect()->away(session()->get('url_redirect'));
                $res['redirectUrl'] = session()->get('url_redirect');
            }
            $res['redirectUrl'] = route('home');

//            return redirect()->route('home')->with('notify', 'Đăng nhập thành công')->with('notify_type', 'success');
        }
        return $res;
//        return redirect()->route('login')->with('notify', 'Sai tài khoản hoặc mật khẩu')->with('notify_type', 'error');


//        return view('pages/login');
    }

    public function login()
    {
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
        return redirect()->route('login')->with('notify', 'Tạo tài khoản thành công');
    }

    public function logout()
    {
        session()->forget('url_redirect');
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
                $param = [
                    'username' => vn2code($user->getName()) . '_' . time(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->getId(),
                    'password' => encrypt(DEFAULT_PASSWORD),
                    'phone' => DEFAULT_PHONE_NUMBER,
                    'status' => STATUS_ACTIVE,
                    'role' => ROLE_CUSTOMER,
                    'department_id' => DEPARTMENT_CUSTOMER
                ];

                $newUser = User::create($param);
                Auth::login($newUser);
                return redirect()->route('home')->with('notify', 'Đăng nhập thành công')->with('notify_type', 'success');
            }
        } catch (Exception $e) {
            return redirect()->route('home')->with('notify', 'Đăng nhập thất bại')->with('notify_type', 'error');
        }
    }
}
