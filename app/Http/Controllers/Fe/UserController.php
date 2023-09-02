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

class UserController extends Controller
{
//    public function __construct(private AuthService $authService)
//    {
//        $this->authService = $this->authService;
//    }
//

    public function profile()
    {
        $posts = Posts::with('avatar')->get();
        return view('pages/user/profile', ['posts' => $posts]);
    }

}
