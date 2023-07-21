<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
//    public function __construct() {
//        $this->middleware('auth:api', ['except' => ['login', 'register']]);
//    }
    public function login(Request $request)
    {
        try {
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }

    function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status_code' => 200,
            'message' => 'Đăng xuất thành công',
        ], 200);
    }
//    // Revoke all tokens...
//$user->tokens()->delete();
//
//// Revoke the user's current token...
//$request->user()->currentAccessToken()->delete();
//
//// Revoke a specific token...
//$user->tokens()->where('id', $id)->delete();
}
