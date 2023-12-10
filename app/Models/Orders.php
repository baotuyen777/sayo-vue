<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    public static array $statusOrder = [
        1 => 'Đã đặt hàng',
        2 => 'Đang xử lý',
        3 => 'Đã Hoàn thành',
    ];
    protected $fillable = ['code', 'status', 'author_id', 'product_id', 'seller_id'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function author(){
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
}
