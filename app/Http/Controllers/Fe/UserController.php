<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Post\PostService;
use App\Services\Post\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private User        $userModel,
        private PostService $postService,
        private UserService $userService
    )
    {

    }

    public function index(Request $request)
    {
        $objs = $this->userService->getPagination($request);
        return view('pages/user/list', ['objs' => $objs]);
    }

    public function show(Request $request, $userName)
    {
        $user = $this->userService->getOne($userName);
        if ($user) {
            $posts = $this->postService->getAllSimple($request, ['author_id' => $user->id]);


            return view('pages/user/dashboard', ['posts' => $posts, 'user' => $user]);
        }
        return view('pages/404');

    }

    public function edit($username)
    {
        $attrs = $this->userService->editUser($username);
        if ($attrs) {
            return view('pages.user.edit', $attrs);
        }
        return view('pages/404');
    }

    public function profile()
    {
        $attrs = $this->userService->getAttrOptions();
        $userName = Auth::user()->username;
        if (!$userName) {
            return view('pages.auth.login');
        }
        $user = $this->userService->getOne($userName);
        $attrs['obj'] = $user;
        $attrs['user'] = $user;
        return view('pages/user/profile', $attrs);
    }

    public function updateSimple(Request $request, $useName)
    {
        $data = $this->userService->updateSimple($request, $useName);
        if (!$data) {
            return view('pages/404');
        }
        return $data;
    }

    public function update(Request $request, $username)
    {
        $data = $this->userService->updateUser($request, $username);
        if (!$data['status']) {
            return view('pages/404');
        }
        return $data;
    }

    public function destroy($userName)
    {
        return $this->userService->destroy($userName);
    }
}
