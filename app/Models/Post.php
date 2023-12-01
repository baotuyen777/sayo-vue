<?php

namespace App\Models;

use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory;

    const CACHE_KEY = 'posts';
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
//    protected $table ='posts';
    protected $fillable = [
        'name', 'code', 'content', 'category_id', 'status', 'author_id', 'price',
        'address', 'attr', 'ward_id', 'district_id', 'province_id', 'avatar_id', 'video_id', 'source'
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
        return $this->belongsToMany(Files::class, 'posts_files')
            ->select(['files.*'])
            ->selectRaw('CONCAT("' . asset('storage') . '/", files.url) as url');
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

    public static function getAll($request)
    {
        $cacheKey = convertArr2Code($request->all());

        $objs = Cache::remember(self::CACHE_KEY . $cacheKey, env('APP_ENV') == 'production' ? 60 * 24 : 0, function () use ($request) {
            $query = Post::where('status', '=', STATUS_ACTIVE)
                ->with('avatar')
                ->with('category')
                ->with('province')
                ->with('author')
                ->with('province')
                ->orderBy('status')->orderBy('created_at', 'desc');

            if ($request) {
                $query = self::buildFilterQuery($request, $query);
                $query = self::buildFilterLocation($request, $query);
            }

            $currentPage = $request->input('current');
            $pageSize = $request->input('page_size') ?? 24;
            return $query->paginate($pageSize, ['*'], 'page', $currentPage);
        });

        return $objs;
    }

    public static function getOne($code, $isFull = false)
    {
        $objs = Cache::remember(self::CACHE_KEY . $code, 60 * 24, function () use ($code, $isFull) {
            $query = Post::select('*')->where('code', $code);
            if ($isFull) {
                $query->with('avatar')
                    ->with('files')
                    ->with('category')
                    ->with('author')
                    ->with('comments')
                    ->with('province')
                    ->with('district')
                    ->with('ward');
            }
            return $query->first();


        });

        return $objs;
    }

    private static function buildFilterQuery($request, $query)
    {
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->input('author_id')) {
            $query->where('author_id', $request->input('author_id'));
        }


        if ($request->input('catCode')) {

            $category = Category::getAll()->firstWhere('code', $request->input('catCode'));
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $priceFrom = $request->input('price_from');
        if ($priceFrom) {
            $query->where('price', '>', $priceFrom);
        }

        $priceTo = $request->input('price_to');
        if ($priceTo) {
            $query->where('price', '<', $priceTo);
        }

        $s = $request->input('s');
        if ($s) {
            $query->where('name', 'like', "%{$s}%");
        }
        return $query;
    }

    public static function buildFilterLocation($request, $query)
    {
        if ($request->input('provinceCode')) {
            $province = Province::getAll()->firstWhere('code', $request->input('provinceCode'));
            $query->where('province_id', $province->id);
            $districtCode = $request->input('districtCode');

            $district = District::getAll()->firstWhere('code', $districtCode);

            if ($district) {
                $query->where('district_id', $district->id);
                $wardCode = $request->input('wardCode');

                $ward = Ward::getAll()->firstWhere('code', $wardCode);
                if ($ward) {
                    $query->where('ward_id', $ward->id);
                }
            }
        }

        return $query;
    }

}
