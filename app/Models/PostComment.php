<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $table = 'post_comment';

//    protected $guarded = 'id';

    protected $fillable = ['content', 'item_id', 'user_id', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(PostComment::class, 'parent_id', 'id');
    }

    public function getRemainingDaysAttribute(): string
    {
        $createdAt = Carbon::parse($this->created_at);
        return $createdAt->diffForHumans();
    }
}
