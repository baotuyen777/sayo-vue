<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Models\PostComment;
use App\Models\User;
use App\Models\UserLike;
use App\Services\Post\PostService;
use App\Services\Post\UserService;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        private PostService    $postService,
        private UserService    $userService,
        private ProductService $productService
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

        $objs = User::getAll($request, true);
        return view('pages.user.list', ['objs' => $objs]);
    }

    public function show(Request $request, $userName)
    {
        $user = User::getOne($userName);
        if (!$user) {
            return view('pages.404');
        }
        $routeParams = request()->route()->parameters() ?? [];
        $where = [...$request->all(), ...$routeParams, 'author_id' => $user->id,
//            'status' => STATUS_ACTIVE
        ];

        $relationOptions = $this->postService->getRelationOptions($where);
        $posts = $this->postService->getAll($where);
//        dd($relationOptions);
        $products = $this->productService->getAllSimple($request, ['author_id' => $user->id, 'status' => STATUS_ACTIVE]);
        $ratings = PostComment::getAll();
        $likePage = Auth::check() ? UserLike::where('author_id', Auth::user()->id)->where('seller_id', $user->id)->first() : false;

        return view('pages.user.portfolio', [
            ...$relationOptions,
            'posts' => $posts,
            'user' => $user,
            'products' => $products,
            'ratings' => $ratings,
            'isLike' => !!$likePage,
//            'categories' => []
        ]);
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
        // If only bio is being updated
        if ($request->has('bio') && count($request->all()) === 1) {
            try {
                $user = User::where('username', $username)->first();
                
                // Check authorization
                if (!Auth::check() || Auth::id() != $user->id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized'
                    ], 403);
                }
                
                $user->bio = $request->bio;
                $user->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Bio updated successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update bio: ' . $e->getMessage()
                ], 500);
            }
        }
        
        // Otherwise, use the service for full user update
        $data = $this->userService->update($request, $username);
        return response()->json($data);
    }

    public function destroy($userName)
    {
        $res = $this->userService->destroy($userName);
        return response()->json($res);
    }
}
