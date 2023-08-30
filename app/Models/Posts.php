<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Medias::class)
            ->select(['medias.*'])
            ->selectRaw('CONCAT("' . env('MEDIA_URL') . '", medias.url) as url');
    }

    public function pdws()
    {
        return $this->belongsTo(Pdws::class, 'pdws_id');
    }

    public function gallery()
    {
        return $this->belongsToMany(Medias::class, 'posts_gallery')
            ->select(['medias.*'])
            ->selectRaw('CONCAT("' . env('MEDIA_URL') . '", medias.url) as url');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getProductAtt()
    {
        $categories = Category::with('avatar')->get();
        $address = [
            ['id' => 1, 'name' => 'Phường Thanh Xuân Bắc, Quận Thanh Xuân, Hà Nội'],
            ['id' => 2, 'name' => 'Phường Thanh Xuân Trung, Quận Thanh Xuân, Hà Nội'],
        ];
        $postStates = Posts::$states;

        $brands = ['Samsung', 'Apple'];
        $colors = ['Bạc', 'Đen', 'Đỏ', 'Hồng', 'Trắng', 'Vàng', 'Xám', 'Xanh dương', 'Xanh lá', 'Màu khác'];
        $storages = ['<8G', '8G', '16G', '32G', '64G', '128G', '256G', '>256G'];
        $madeIns = ['Việt Nam', 'Trung Quốc', 'Châu Âu', 'Mỹ', 'Nhật', 'Thái Lan', 'Hàn Quốc', 'Khác'];

        return get_defined_vars();
    }

}
