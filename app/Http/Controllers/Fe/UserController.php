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
    private $userService;
    public function __construct(
        private User        $userModel,
        private PostService $postService,
        UserService         $userService
    )
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $objs = $this->userService->index($request);
        return view('pages/user/list', ['objs' => $objs]);
    }

    public function show(Request $request, $userName)
    {
        $user = $this->userService->showUser($userName);
        if ($user) {
            $posts = $this->postService->getAllSimple($request, ['author_id' => $user->id]);


            return view('pages/user/dashboard', ['posts' => $posts, 'user' => $user]);
        }
        return view('pages/404');

    }

    public function edit($id) {
        $attrs = $this->userService->editUser($id);
        if (!$attrs) {
            return view('pages/404');
        }
        return view('pages.user.edit', $attrs);
    }

    public function profile()
    {
        $attrs = $this->userService->profile();
        if (!$attrs) {
            return view('pages.auth.login');
        }
        return view('pages/user/profile', $attrs);
    }

    public function updateSimple(Request $request, $useName)
    {
        return $this->userService->updateSimple($request, $useName);
    }

    public function update(Request $request, $id)
    {
        return $this->userService->updateUser($request, $id);
    }

    public function destroy($userName)
    {
        $data = $this->userService->destroy($userName);
        if (!$data){
            return view('pages/404');
        }
        return response()->json(['status' => true, 'result' => $data]);
    }
}
