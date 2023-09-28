<?php

namespace App\Models;

use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    use HasFactory;

    public static array $status = [
        1 => 'Chờ duyệt',
        2 => 'Đã duyệt',
        3 => 'Không hợp lệ',
        4 => 'Đã bán',
        5 => 'Đã ẩn ',
    ];
//    protected $table ='posts';
    protected $fillable = [
        'name', 'code', 'content', 'category_id', 'avatar_link', 'author_id', 'status', 'avatar_id',
    ];
    protected $primaryKey = 'id';

    public function avatar()
    {

        return $this->belongsTo(Files::class)
            ->select(['files.*'])
            ->selectRaw('CONCAT("' . asset('storage') . '/", files.url) as url');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
