<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['name', 'url'];
//    public function posts()
//    {
//        return $this->hasMany(Posts::class);
//    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

}
