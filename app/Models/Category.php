<?php

namespace App\Models;

use App\Models\Pdw\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

//    public function products()
//    {
//        return $this->hasMany(Products::class);
//    }

    public function avatar()
    {
        return $this->belongsTo(Files::class)
            ->select(['files.*'])
            ->selectRaw('CONCAT("' . asset('storage') . '/", files.url) as url ');
    }

    public static function getAll()
    {
        return Cache::remember('categories', 60 * 24 * 365, function () {
            return self::with('avatar')->get();
        });
    }
}
