<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($request)
    {
        try {
            $credentials = request(['phone', 'password']);
            if (!Auth::attempt($credentials)) {
                return [
                    'status_code' => 500,
                    'message' => 'Sai tài khoản hoặc mật khẩu'
                ];
//                return response()->json([
//                    'status_code' => 500,
//                    'message' => 'Unauthorized'
//                ]);
            }

            $user = User::where('phone', $request->phone)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return [
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user->toArray(),
                'status'=> true
            ];
//            return response()->json([
//                'status_code' => 200,
//                'access_token' => $tokenResult,
//                'token_type' => 'Bearer',
//                'user' => $user
//            ]);
        } catch (\Exception $error) {

            return [
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ];
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }

    function logout()
    {
        Auth::guard('web')->logout();
        auth()->user()->tokens()->delete();
        return response()->json([
            'status_code' => 200,
            'message' => 'Đăng xuất thành công',
        ], 200);
    }
}
