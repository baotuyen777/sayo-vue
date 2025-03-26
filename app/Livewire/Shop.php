<?php

namespace App\Livewire;

use App\Models\PostComment;
use App\Models\Product;
use App\Models\User;
use App\Models\UserLike;
use App\Services\Post\PostService;
use App\Services\Post\UserService;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Shop extends Component
{
    public $isLike= false;
    public $shop =[];
    public function mount(
        PostService    $postService,
        UserService    $userService,
        ProductService $productService
    )
    {
        $this->postService = $postService; // Assign service instance
        $this->userService = $userService;
        $this->productService = $productService;
    }

    public function render()
    {
        $routeParams = request()->route()->parameters() ?? [];
        $shop = User::getOne($routeParams['code']);
        if (!$shop) {
            return view('pages.404');
        }

        $where = [...$routeParams, 'author_id' => $shop->id,
//            'status' => STATUS_ACTIVE
        ];

        $relationOptions = $this->postService->getRelationOptions($where);
        $posts = $this->postService->getAll($where);
//        dd($relationOptions);
//        $products = $this->productService->getAllSimple($where, ['author_id' => $user->id, 'status' => STATUS_ACTIVE]);
        $products = Product::getAll($where);
        $ratings = PostComment::getAll();
        $likePage = Auth::check() ? UserLike::where('author_id', Auth::user()->id)->where('seller_id', $shop->id)->first() : false;
//$this->isLike =$likePage;
$this->shop = $shop;
//        return view('pages.user.portfolio', [
//            ...$relationOptions,
//            'posts' => $posts,
//            'user' => $user,
//            'products' => $products,
//            'ratings' => $ratings,
//            'isLike' => !!$likePage,
////            'categories' => []
//        ]);
        return view('livewire.shop', [
            ...$relationOptions,
            'posts' => $posts,
//            'shop' => $shop,
            'products' => $products,
            'ratings' => $ratings,
            'isLike' => !!$likePage,
//            'categories' => []
        ]);
    }
}
