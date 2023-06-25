<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
//    protected $table ='posts';
    protected $appends = array('category_name');
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

}
