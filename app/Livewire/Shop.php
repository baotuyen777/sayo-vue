<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\Product;
use App\Models\User;
use App\Models\UserLike;
use App\Models\Category;
use App\Services\Post\PostService;
use App\Services\Post\UserService;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Shop extends Component
{
    public $isLike = false;
    public $shop = [];
    public $bio = '';
    public $successMessage = '';
    public $shopCategories = [];
    
    protected $postService;
    protected $userService;
    protected $productService;
    
    protected $rules = [
        'bio' => 'required|string|max:500',
    ];
    
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
    
    protected function getShopCategories($shopId)
    {
        // Get all categories that the shop is selling products in
        return DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.author_id', $shopId)
            ->where('products.status', '>=', 1) // Only include active products
            ->select('categories.id', 'categories.name', 'categories.code')
            ->distinct()
            ->get();
    }
    
    public function updateBio()
    {
        $this->validate();
        
        // Check if user is authorized
        if (!Auth::check() || Auth::id() != $this->shop['id']) {
            session()->flash('error', 'Bạn không có quyền cập nhật.');
            return;
        }
        
        try {
            // Update the bio
            $user = User::find($this->shop['id']);
            $user->bio = $this->bio;
            $user->save();
            
            $this->successMessage = 'Cập nhật thành công!';
            
            // Refresh the shop data
            $this->shop = User::getOne($this->shop['username'] ?? $user->username);
        } catch (\Exception $e) {
            session()->flash('error', 'Không thể cập nhật: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Get route parameters
        $code = request()->route('code');

        $queryParams = request()->query();

        $shop = User::getOne($code);
        if (!$shop) {
            return view('pages.404');
        }

        $where = [...$queryParams, 'author_id' => $shop->id,
//            'status' => STATUS_ACTIVE
        ];
        $relationOptions = $this->postService->getRelationOptions($where);
        $products = Product::getPaginate($where, 12); // Use paginated products with 12 items per page
        $posts = Post::getAll($where);
        $ratings = PostComment::getAll();
        $likePage = Auth::check() ? UserLike::where('author_id', Auth::user()->id)->where('seller_id', $shop->id)->first() : false;
        
        $this->shop = $shop;
        // Get categories this shop is selling in
        $this->shopCategories = $this->getShopCategories($shop['id']);
        
        // Initialize bio value from shop data if not already set
        if (empty($this->bio) && !empty($shop->bio)) {
            $this->bio = $shop->bio;
        }
        
        return view('livewire.shop', [
            ...$relationOptions,
           'posts' => $posts,
           'shop' => $shop,
            'products' => $products,
           'ratings' => $ratings,
           'isLike' => !!$likePage,
           'shopCategories' => $this->shopCategories
        ]);
    }
}
