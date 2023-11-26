<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{

    public function store(ReviewRequest $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập để có thể bình luận', 'error' => 'Unauthorized'],
                401);
        }

        $reviewData = $request->validated();
        $reviewData['user_id'] = Auth::user()->id;
        $review = Review::whereProductId($reviewData['product_id'])->whereUserId($reviewData['user_id'])->first();
        if ($review) {
            return response()->json(
                ['message' => 'Bạn chỉ được đánh giá sản phẩm này 1 lần', 'warning' => 'Unauthorized'],
                401
            );
        }

        try {
            $newReview = Review::create($reviewData);
            $avgRate = round($newReview->product->reviews()->avg('rating'), 1);
            $newReview->product->update(['avg_rate' => $avgRate]);
        } catch (\Exception $e) {
            return response()->json(
                ['message' => 'Đã có lỗi xảy ra vui lòng thử lại', 'error' => 'Internal Server Error'.$e->getMessage()],
                500
            );
        }

        return response()->json(['status' => true, 'result' => $newReview]);
    }
}
