<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\Product;
use App\Models\User;
use App\Models\UserLike;
use App\Models\Category;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Services\Post\PostService;
use App\Services\Post\UserService;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $isLike = false;
    public $shop = [];
    public $bio = '';
    public $successMessage = '';
    public $shopCategories = [];
    public $selectedCategoryId = null;
    public $cat = null;
    public $shopCode;
    public $province = null;
    public $provinceId = null;
    public $ward = null;
    public $wardId = null;
    public $provinces = [];
    public $wards = [];
    public $priceFrom = null;
    public $priceTo = null;
    public $keyword = null;
    public $sortBy = 'popular';
    public $sortDirection = 'desc';

    // Add queryString property to preserve state in URL
    protected $queryString = [
        'cat' => ['except' => null],
        'province' => ['except' => null],
        'ward' => ['except' => null],
        'priceFrom' => ['except' => null],
        'priceTo' => ['except' => null],
        'keyword' => ['except' => null]
    ];

    protected $rules = [
        'bio' => 'required|string|max:500',
    ];

    public function mount(
        PostService    $postService,
        UserService    $userService,
        ProductService $productService
    )
    {
        $this->shopCode = request()->route('code');
        
        // Initialize cat from query string if present
        $this->cat = request()->query('cat', null);
        
        // If cat is set in the URL, find the corresponding category ID
        if ($this->cat) {
            $category = Category::where('code', $this->cat)->first();
            if ($category) {
                $this->selectedCategoryId = $category->id;
            }
        }
        
        // Initialize province from query string if present
        $this->province = request()->query('province', null);
        
        // If province is set in the URL, find the corresponding province ID
        if ($this->province) {
            $province = Province::where('code', $this->province)->first();
            if ($province) {
                $this->provinceId = $province->id;
                // Load wards for this province
                $this->loadWards();
            }
        }
        
        // Initialize ward from query string if present
        $this->ward = request()->query('ward', null);
        
        // If ward is set in the URL, find the corresponding ward ID
        if ($this->ward) {
            $ward = Ward::where('code', $this->ward)->first();
            if ($ward) {
                $this->wardId = $ward->id;
            }
        }
        
        // Initialize price range and keyword from query string
        $this->priceFrom = request()->query('priceFrom', null);
        $this->priceTo = request()->query('priceTo', null);
        $this->keyword = request()->query('keyword', null);
        
        // Get list of provinces
        $this->loadProvinces();
    }

    protected function loadProvinces()
    {
        // Get all provinces
        $this->provinces = Province::all()->toArray();
    }

    protected function loadWards()
    {
        if ($this->provinceId) {
            // Get wards for selected province through district relationship
            $this->wards = Ward::whereHas('district', function($query) {
                $query->where('province_id', $this->provinceId);
            })->get()->toArray();
        } else {
            $this->wards = [];
        }
    }

    protected function getPostService()
    {
        return App::make(PostService::class);
    }

    protected function getUserService()
    {
        return App::make(UserService::class);
    }

    protected function getProductService()
    {
        return App::make(ProductService::class);
    }

    public function filterByCategory($categoryId, $categoryCode)
    {
        $this->selectedCategoryId = $categoryId;
        $this->cat = $categoryCode;
        $this->resetPage();
    }

    public function clearCategoryFilter()
    {
        $this->selectedCategoryId = null;
        $this->cat = null;
        $this->resetPage();
    }

    public function filterByProvince($provinceId, $provinceCode)
    {
        $this->provinceId = $provinceId;
        $this->province = $provinceCode;
        // Reset ward when province changes
        $this->ward = null;
        $this->wardId = null;
        // Load wards for the selected province
        $this->loadWards();
        $this->resetPage();
    }

    public function clearProvinceFilter()
    {
        $this->provinceId = null;
        $this->province = null;
        $this->ward = null;
        $this->wardId = null;
        $this->wards = [];
        $this->resetPage();
    }

    public function filterByWard($wardId, $wardCode)
    {
        $this->wardId = $wardId;
        $this->ward = $wardCode;
        $this->resetPage();
    }

    public function clearWardFilter()
    {
        $this->wardId = null;
        $this->ward = null;
        $this->resetPage();
    }

    public function updatePriceFilter()
    {
        $this->resetPage();
    }
    
    public function clearPriceFilter()
    {
        $this->priceFrom = null;
        $this->priceTo = null;
        $this->resetPage();
    }
    
    public function updateKeywordSearch()
    {
        $this->resetPage();
    }
    
    public function clearKeywordSearch()
    {
        $this->keyword = null;
        $this->resetPage();
    }

    public function formatMoney($amount)
    {
        if (!$amount) {
            return '';
        }
        return number_format($amount, 0, ',', '.') . ' ₫';
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

    public function setSort($sortBy, $direction = null)
    {
        $this->sortBy = $sortBy;
        if ($direction) {
            $this->sortDirection = $direction;
        } else {
            // Default direction for each sort type
            $this->sortDirection = $sortBy === 'name' ? 'asc' : 'desc';
        }
        $this->resetPage();
    }

    public function render()
    {
        // Use the stored shop code instead of getting it from the route
        $code = $this->shopCode;

        $queryParams = request()->query();

        $shop = User::getOne($code);
        if (!$shop) {
            return view('pages.404');
        }

        $where = [...$queryParams, 'author_id' => $shop->id];
        
        // Add category filter if selected
        if ($this->selectedCategoryId) {
            $where['category_id'] = $this->selectedCategoryId;
        }
        
        // Get fresh service instances
        $postService = $this->getPostService();
        
        $relationOptions = $postService->getRelationOptions($where);
        
        // Custom query for products to avoid using the model's problematic method
        $productsQuery = Product::query()
            ->with('avatar', 'category', 'province', 'author')
            ->where('author_id', $shop->id)
            ->orderBy('status')
            ->orderBy('created_at', 'desc');
            
        // Apply category filter directly
        if ($this->selectedCategoryId) {
            $productsQuery->where('category_id', $this->selectedCategoryId);
        }
        
        // Apply province filter directly
        if ($this->provinceId) {
            $productsQuery->where('province_id', $this->provinceId);
        }
        
        // Apply ward filter directly
        if ($this->wardId) {
            $productsQuery->where('ward_id', $this->wardId);
        }
        
        // Apply price range filter
        if ($this->priceFrom) {
            $productsQuery->where('price', '>=', $this->priceFrom);
        }
        
        if ($this->priceTo) {
            $productsQuery->where('price', '<=', $this->priceTo);
        }
        
        // Apply keyword search
        if ($this->keyword) {
            $productsQuery->where(function($query) {
                $query->where('name', 'like', '%' . $this->keyword . '%')
                      ->orWhere('content', 'like', '%' . $this->keyword . '%');
            });
        }
        
        // Apply sorting
        switch ($this->sortBy) {
            case 'price':
                $productsQuery->orderBy('price', $this->sortDirection);
                break;
            case 'name':
                $productsQuery->orderBy('name', $this->sortDirection);
                break;
            case 'newest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'bestseller':
                $productsQuery->orderBy('sold', 'desc'); // Ensure 'sold' column exists
                break;
            default: // 'popular'
                $productsQuery->orderBy('created_at', 'desc'); // Ensure 'views' column exists
                break;
        }
        
        $products = $productsQuery->paginate(12);
        
        $posts = Post::getAll($where); // Post model uses getAll() which already has pagination
        $ratings = PostComment::getAll();
        $likePage = Auth::check() ? UserLike::where('author_id', Auth::user()->id)->where('seller_id', $shop->id)->first() : false;
        
        $this->shop = $shop;
        // Get categories this shop is selling in
        $this->shopCategories = $this->getShopCategories($shop['id']);
        
        // Initialize bio value from shop data if not already set
        if (empty($this->bio) && !empty($shop->bio)) {
            $this->bio = $shop->bio;
        }
        
        // Get the currently selected province for display
        $selectedProvince = null;
        if ($this->provinceId) {
            foreach ($this->provinces as $province) {
                if ($province['id'] == $this->provinceId) {
                    $selectedProvince = $province;
                    break;
                }
            }
        }
        
        // Get the currently selected ward for display
        $selectedWard = null;
        if ($this->wardId) {
            foreach ($this->wards as $ward) {
                if ($ward['id'] == $this->wardId) {
                    $selectedWard = $ward;
                    break;
                }
            }
        }
        
        return view('livewire.shop', [
            ...$relationOptions,
            'posts' => $posts,
            'shop' => $shop,
            'products' => $products,
            'ratings' => $ratings,
            'isLike' => !!$likePage,
            'shopCategories' => $this->shopCategories,
            'provinces' => $this->provinces,
            'selectedProvince' => $selectedProvince,
            'wards' => $this->wards,
            'selectedWard' => $selectedWard,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ]);
    }
}
