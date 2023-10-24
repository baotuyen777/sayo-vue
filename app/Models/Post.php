<?php

namespace App\Models;

use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

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
        'acreage' => ['label' => 'Diện tích', 'type' => 's'],
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

}
