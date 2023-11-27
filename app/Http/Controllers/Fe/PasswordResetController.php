<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function forgotPassword()
    {
        return view('pages.auth.forgot_password');
    }

    public function doForgotPassword(Request $request)
    {
        $phoneAdmin = DEFAULT_PHONE_NUMBER;
        $user = User::where('email', $request->to_send_password_change)
            ->orwhere('phone', $request->to_send_password_change)
            ->orWhere('username', $request->to_send_password_change)->first();
        if ($user) {
            if ($user->email) {
                $token = Str::random(60);
                PasswordReset::updateOrCreate([
                    'email' => $user->email,
                ], [
                    'phone' => $user->phone,
                    'token' => $token,
                ]);
                Mail::to($user->email)->send(new ResetPasswordMail($token));
                return view('pages.auth.mail_success', ['email' => $user->email])->with('notify', 'Gửi mail thành công')->with('notify_type', 'success');
            }
            return redirect()->back()->withErrors(['to_send_password_change' => "Tài khoản này chưa có email vui lòng liên hệ với admin: $phoneAdmin"]);
        }

        return redirect()->back()->withErrors(['to_send_password_change' => 'Không có Email, Số điện thoại, Username nào khớp']);
    }

    public function resetPassword($token)
    {
        $isToken = PasswordReset::where('token', $token)->first();
        if (!$isToken) {
            return view('pages.404');
        }
        return view('pages.auth.change_password', ['token' => $token]);
    }

    public function doResetPassword(PasswordResetRequest $request, $token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if ($passwordReset) {
            User::where('phone', $passwordReset->phone)->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('login')->with('notify', 'Đổi mật khẩu thành công')->with('notify_type', 'success');
        }
        return redirect()->back()->with('notify', 'Đổi mật khẩu thất bại')->with('notify_type', 'error');
    }
}
