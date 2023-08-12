<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->hasMany(Posts::class);
    }

//    public function products()
//    {
//        return $this->hasMany(Products::class);
//    }

    public function avatar()
    {
        return $this->belongsTo(Medias::class)
            ->select(['medias.*'])
            ->selectRaw('CONCAT("' . env('MEDIA_URL') . '", medias.url) as url ');
    }
}
