<?php

namespace App\Models;

use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;

    const CACHE_KEY = 'product';
    public static array $status = [
        1 => 'Chờ duyệt',
        2 => 'Đã duyệt',
        3 => 'Không hợp lệ',
        4 => 'Đã bán',
        5 => 'Đã ẩn ',
    ];
    public static array $statusClass = [
        1 => 'gray',
        2 => 'success',
        3 => 'danger',
        4 => 'warning',
        5 => 'info ',
    ];
    public static array $states = [
        1 => 'Mới',
        2 => 'Đã sử dụng(chưa sửa chữa)',
        3 => 'Đã sử dụng(đã sửa chữa)',
    ];
    public static array $attr = [
        'garret' => ['label' => 'Gác xép', 'type' => 'boolean'],
        'acreage' => ['label' => 'Diện tích', 'type' => 'square'],
        'deposit' => ['label' => 'Đặt cọc', 'type' => 'money'],
        'furniture' => [
            'label' => 'Nội thất ',
            'options' => [
                1 => 'Đầy đủ',
                2 => 'Cơ bản',
                3 => 'Phòng trống'
            ]
        ],
        'material' => ['label' => 'Chất liệu'],
        'color' => ['label' => 'Màu sắc', 'options' => ['Bạc', 'Đen', 'Đỏ', 'Hồng', 'Trắng', 'Vàng', 'Xám', 'Xanh dương', 'Xanh lá', 'Màu khác']],
        'branch' => ['label' => 'Thương hiệu', 'options' => ['Samsung', 'Apple']],
        'made_in' => ['label' => 'Xuất xứ', 'options' => ['Việt Nam', 'Trung Quốc', 'Châu Âu', 'Mỹ', 'Nhật', 'Thái Lan', 'Hàn Quốc', 'Khác']],
        'storage' => ['label' => 'Dung lượng', 'options' => ['<8G', '8G', '16G', '32G', '64G', '128G', '256G', '>256G']],

        'state' => ['label' => 'Tình trạng', 'options' => [
            1 => 'Mới',
            2 => 'Đã sử dụng(chưa sửa chữa)',
            3 => 'Đã sử dụng(đã sửa chữa)',
        ]],
        'guarantee' => ['label' => 'Bảo hành', 'options' => [
            1 => 'Hết bảo hành',
            2 => 'Còn bảo hành',
            3 => 'Còn bảo hành trên 6 tháng',
        ]],

    ];
//    protected $table ='products';
    protected $fillable = [
        'name', 'code', 'content', 'category_id', 'status', 'author_id', 'price',
        'address', 'attr', 'ward_id', 'district_id', 'province_id', 'avatar_id', 'video_id', 'source', 'avg_rate'
    ];
    protected $appends = ['category_name'];
    protected $primaryKey = 'id';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function avatar()
    {
        return $this->belongsTo(Files::class)
            ->select(['files.*'])
            ->selectRaw('CONCAT("' . asset('storage') . '/", files.url) as url');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function files()
    {
        return $this->belongsToMany(Files::class, 'products_files')
            ->select(['files.*']);
//            ->selectRaw('CONCAT("' . asset('storage') . '/", files.url) as url');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'item_id', 'id')
            ->with('user:id,name', 'children')
            ->whereNull('parent_id')->limit(6);
    }

//    public static function getAll()
//    {
//        $products = Product::where('status', '=', 2)
//            ->with('avatar')
//            ->with('category')
//            ->orderBy('created_at', 'desc')
//            ->paginate(24);
//        return $products;
//    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id')->with('user:id,username')->with('files:id,url');
    }

//    public function getAttOptions()
//    {
//        $categories = Category::with('avatar')->get();
//        $address = [
//            ['id' => 1, 'name' => 'Phường Thanh Xuân Bắc, Quận Thanh Xuân, Hà Nội'],
//            ['id' => 2, 'name' => 'Phường Thanh Xuân Trung, Quận Thanh Xuân, Hà Nội'],
//        ];
////        $provinces = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 1)->get();
////        $districts = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 2)->get();
////        $wards = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 3)->get();
//        $provinces = Province::get();
//        $districts = District::whereProvinceId(50)->get();
//        $wards = Ward::whereDistrictId(552)->get();
//
//        $postStates = Posts::$states;
//
//        $brands = ['Samsung', 'Apple'];
//        $colors = ['Bạc', 'Đen', 'Đỏ', 'Hồng', 'Trắng', 'Vàng', 'Xám', 'Xanh dương', 'Xanh lá', 'Màu khác'];
//        $storages = ['<8G', '8G', '16G', '32G', '64G', '128G', '256G', '>256G'];
//        $madeIns = ['Việt Nam', 'Trung Quốc', 'Châu Âu', 'Mỹ', 'Nhật', 'Thái Lan', 'Hàn Quốc', 'Khác'];
//
//
//        return get_defined_vars();
//    }
    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }
        return new static;
    }

//    public static function getAll($request)
//    {
//        $cacheKey = convertArr2Code($request->all());
//
//        $time = config('app.enable_cache') ? 30 * 60 * 24 : 0;
//        $objs = Cache::remember(self::CACHE_KEY . $cacheKey, $time, function () use ($request) {
//            $query = Post::query()
//                ->with('avatar')
//                ->with('category')
//                ->with('province')
//                ->with('author')
//                ->with('province')
//                ->orderBy('status')->orderBy('created_at', 'desc');
//
//            if ($request) {
//                $query = self::buildFilterQuery($request, $query);
//                $query = self::buildFilterLocation($request, $query);
//            }
//
//            $currentPage = $request->input('current');
//            $pageSize = $request->input('page_size') ?? 24;
//            return $query->paginate($pageSize, ['*'], 'page', $currentPage);
//        });
//
//        return $objs;
//    }

    public static function getAll($where)
    {
//        $cacheKey = convertArr2Code($where);
//        $time = config('app.enable_cache') ? 30 * 60 * 24 : 0;
//        $objs = Cache::remember(self::CACHE_KEY . $cacheKey, $time, function () use ($where) {
            $query = Product::query()
                ->with('avatar')
                ->with('category')
                ->with('province')
                ->with('author')
                ->with('province')
                ->orderBy('status')->orderBy('created_at', 'desc');

            if ($where) {
                $query = self::buildFilterQuery($where, $query);
                $query = self::buildFilterLocation($where, $query);
            }
            $currentPage = $where['current'] ?? 1;
            $pageSize = $where['page_size'] ?? 24;
//            return $query->get();
//        $objs= $query->get();
//        });
$objs= $query->get();
//dd($objs);
        return $objs;
    }

    public static function getPaginate($where, $pageSize = 24)
    {
        $query = Product::query()
            ->with('avatar')
            ->with('category')
            ->with('province')
            ->with('author')
            ->with('province')
            ->orderBy('status')->orderBy('created_at', 'desc');

        if ($where) {
            $query = self::buildFilterQuery($where, $query);
            $query = self::buildFilterLocation($where, $query);
        }
        $currentPage = $where['current'] ?? 1;
        $pageSize = $where['page_size'] ?? $pageSize;
        
        return $query->paginate($pageSize);
    }

    public static function getOne($code, $isFull = false, $populateExtendField = false)
    {
        $time = config('app.enable_cache') ? 30 * 60 * 24 : 0;
        $obj = Cache::remember(self::CACHE_KEY . $code, $time, function () use ($code, $isFull, $populateExtendField) {
            $query = self::query()->select('*')->where('code', $code);
            if ($isFull) {
                $query->with('avatar')
                    ->with('files')
                    ->with('category');
//                    ->with('author')
//                    ->with('comments')

            }

            $obj = $query->first();
//            if ($populateExtendField) {
//                $obj = self::populateExtendField($obj);
//            }

            return $obj;
        });

        return $obj;
    }

    private static function buildFilterQuery($where, $query)
    {
        if ($where['status'] ?? '' != 'all') {
            $query->where('status', STATUS_ACTIVE);
        }

        if ($where['author_id'] ?? null) {
            $query->where('author_id', 1);
        }

        $catCode = $where['catCode'] ?? null;
        if ($catCode) {
            $category = Category::getAll()->firstWhere('code', $catCode);
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $priceFrom = $where['price_from'] ?? 0;
        if ($priceFrom) {
            $query->where('price', '>', $priceFrom);
        }

        $priceTo = $where['price_to'] ?? null;
        if ($priceTo) {
            $query->where('price', '<', $priceTo);
        }

        $s = $where['s'] ?? '';
        if ($s) {
            $query->where('name', 'like', "%{$s}%");
        }
        return $query;
    }

    public static function buildFilterLocation($where, $query)
    {
        $provinceCode = $where['provinceCode'] ?? '';
        if ($provinceCode) {
            $province = Province::getAll()->firstWhere('code', $provinceCode);
            $query->where('province_id', $province->id);
            $districtCode = $where['districtCode'] ?? '';

            $district = District::getAll()->firstWhere('code', $districtCode);

            if ($district) {
                $query->where('district_id', $district->id);
                $wardCode = $where['wardCode'] ?? '';

                $ward = Ward::getAll()->firstWhere('code', $wardCode);
                if ($ward) {
                    $query->where('ward_id', $ward->id);
                }
            }
        }

        return $query;
    }
}
