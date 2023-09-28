<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public array $gender = [0 => 'Nữ', 1 => 'Nam'];

//    protected $guarded =[];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'departments_id',
        'status',
        'phone',
        'bio',
        'cccd','gender','birthday',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class,'author_id');
    }

    public function avatar()
    {
        return $this->belongsTo(Files::class)
            ->select(['files.*'])
            ->selectRaw('CONCAT("' .  asset('storage') . '/", files.url) as url');
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
    public function getAttOptions(): array
    {
//        $categories = Category::with('avatar')->get();
//        $address = [
//            ['id' => 1, 'name' => 'Phường Thanh Xuân Bắc, Quận Thanh Xuân, Hà Nội'],
//            ['id' => 2, 'name' => 'Phường Thanh Xuân Trung, Quận Thanh Xuân, Hà Nội'],
//        ];
//        $provinces = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 1)->get();
//        $districts = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 2)->get();
//        $wards = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 3)->get();
//
//        $postStates = Posts::$states;
//
//        $brands = ['Samsung', 'Apple'];
//        $colors = ['Bạc', 'Đen', 'Đỏ', 'Hồng', 'Trắng', 'Vàng', 'Xám', 'Xanh dương', 'Xanh lá', 'Màu khác'];
//        $storages = ['<8G', '8G', '16G', '32G', '64G', '128G', '256G', '>256G'];
//        $madeIns = ['Việt Nam', 'Trung Quốc', 'Châu Âu', 'Mỹ', 'Nhật', 'Thái Lan', 'Hàn Quốc', 'Khác'];
        $genders = $this->gender;


        return get_defined_vars();
    }

}
