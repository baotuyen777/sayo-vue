<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'product_review';

    protected $fillable = ['rating', 'content', 'author_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function files()
    {
        return $this->belongsToMany(Files::class, 'review_file')
            ->select(['files.*'])
            ->selectRaw('CONCAT("' . asset('storage') . '/", files.url) as url');
    }
}
