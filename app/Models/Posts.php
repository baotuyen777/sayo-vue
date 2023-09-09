<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Posts extends Model
{
    use HasFactory;

    public static array $states = [
        1 => 'Mới',
        2 => 'Đã sử dụng(chưa sửa chữa)',
        3 => 'Đã sử dụng(đã sửa chữa)',
    ];
//    protected $table ='posts';
    protected $fillable = [
        'name', 'code', 'content', 'category_id', 'status', 'author_id', 'price',
        'address', 'attr', 'ward_id', 'district_id', 'province_id', 'avatar_id', 'video_id',
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

    public function pdws()
    {
        return $this->belongsTo(Pdws::class, 'pdws_id');
    }

    public function files()
    {
        return $this->belongsToMany(Files::class, 'posts_files')
            ->select(['files.*'])
            ->selectRaw('CONCAT("' . env('MEDIA_URL') . '", files.url) as url');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getAttOptions()
    {
        $categories = Category::with('avatar')->get();
        $address = [
            ['id' => 1, 'name' => 'Phường Thanh Xuân Bắc, Quận Thanh Xuân, Hà Nội'],
            ['id' => 2, 'name' => 'Phường Thanh Xuân Trung, Quận Thanh Xuân, Hà Nội'],
        ];
//        $provinces = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 1)->get();
//        $districts = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 2)->get();
//        $wards = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 3)->get();
        $provinces = \Kjmtrue\VietnamZone\Models\Province::get();
        $districts = \Kjmtrue\VietnamZone\Models\District::whereProvinceId(50)->get();
        $wards = \Kjmtrue\VietnamZone\Models\Ward::whereDistrictId(552)->get();

        $postStates = Posts::$states;

        $brands = ['Samsung', 'Apple'];
        $colors = ['Bạc', 'Đen', 'Đỏ', 'Hồng', 'Trắng', 'Vàng', 'Xám', 'Xanh dương', 'Xanh lá', 'Màu khác'];
        $storages = ['<8G', '8G', '16G', '32G', '64G', '128G', '256G', '>256G'];
        $madeIns = ['Việt Nam', 'Trung Quốc', 'Châu Âu', 'Mỹ', 'Nhật', 'Thái Lan', 'Hàn Quốc', 'Khác'];


        return get_defined_vars();
    }

}
