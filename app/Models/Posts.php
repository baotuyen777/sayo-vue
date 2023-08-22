<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

//    protected $table ='posts';
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
            ->selectRaw('CONCAT("' .  env('MEDIA_URL') . '", medias.url) as url');
    }

    public function pdws()
    {
        return $this->belongsTo(Pdws::class, 'pdws_id');
    }

    public function gallery()
    {
        return $this->belongsToMany(Medias::class, 'posts_gallery')
            ->select(['medias.*'])
            ->selectRaw('CONCAT("' .  env('MEDIA_URL') . '", medias.url) as url');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


}
