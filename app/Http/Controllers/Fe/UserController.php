<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Post\PostService;
use App\Services\Post\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        private PostService $postService,
        private UserService $userService
    )
    {
    }

    public function index(Request $request)
    {
        if (!Auth::user()) {
            return view('pages.auth.login');
        }

        if (Auth::user()->role != ROLE_ADMIN) {
            return view('pages.404');
        }

        $objs = User::getAll($request);
        return view('pages.user.list', ['objs' => $objs]);
    }

    public function show(Request $request, $userName)
    {
        $user = User::getOne($userName);
        if (!$user) {
            return view('pages.404');
        }

        $posts = $this->postService->getAllSimple($request, ['author_id' => $user->id]);

        return view('pages.user.dashboard', ['posts' => $posts, 'user' => $user]);
    }

    public function edit($username)
    {
        $res = $this->userService->getOneWithAttrs($username);
        if ($res) {
            return view('pages.user.edit', $res);
        }

        return view('pages.404');
    }

    public function profile()
    {
        if (!Auth::user()) {
            return view('pages.auth.login');
        }

        $userName = Auth::user()->username;
        $res = $this->userService->getOneWithAttrs($userName);

        return view('pages.user.profile', $res);
    }

    public function update(Request $request, $username)
    {
        $data = $this->userService->update($request, $username);
        return response()->json($data);
    }

    public function destroy($userName)
    {
        $res = $this->userService->destroy($userName);
        return response()->json($res);
    }
}
