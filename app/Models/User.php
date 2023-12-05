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

    public static array $gender = [0 => 'Nữ', 1 => 'Nam'];

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
        'address',
        'cccd', 'gender', 'birthday',
        'google_id',
        'province_id', 'district_id', 'ward_id',
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
        return $this->hasMany(Post::class, 'author_id');
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

    public static function getAll($request, $withRelated = false)
    {
        $s = $request->input('s');
        $pageSize = $request->input('page_size') ?? 5;

        $obj = User::where('name', 'like', "%{$s}%");
        if ($withRelated) {
            $obj->with('avatar');
        }

        return $obj->paginate($pageSize);
    }

    public static function getOne($userName, $withRelated = false)
    {
        $obj = User::where('username', $userName);
        if ($withRelated) {
            $obj->with('province')
                ->with('district')
                ->with('ward');
        }

        return $obj->first();
    }

    public function orders()
    {
        return $this->hasMany(Orders::class, 'author_id', 'id');
    }

}
