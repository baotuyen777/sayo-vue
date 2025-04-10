<?php

namespace App\Livewire\user;

use App\Models\PostComment;
use App\Models\User;
use App\Models\UserLike;
use App\Services\Post\PostService;
use App\Services\Post\UserService;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserShowComponent extends Component
{
    public $user;
    
    public function mount(
        PostService $postService,
        UserService $userService,
        ProductService $productService,
        $userName
    ) {
        $this->postService = $postService;
        $this->userService = $userService;
        $this->productService = $productService;
        
        $this->user = User::getOne($userName);
        if (!$this->user) {
            abort(404);
        }
    }

    public function render()
    {
        $routeParams = request()->route()->parameters() ?? [];
        $where = [...request()->all(), ...$routeParams, 'author_id' => $this->user->id];

        $relationOptions = $this->postService->getRelationOptions($where);
        $posts = $this->postService->getAll($where);
        $products = $this->productService->getAllSimple(request(), ['author_id' => $this->user->id, 'status' => STATUS_ACTIVE]);
        $ratings = PostComment::getAll();
        $likePage = Auth::check() ? UserLike::where('author_id', Auth::user()->id)->where('seller_id', $this->user->id)->first() : false;

        return view('livewire.user.show', [
            ...$relationOptions,
            'posts' => $posts,
            'products' => $products,
            'ratings' => $ratings,
            'isLike' => !!$likePage,
        ]);
    }
} 