<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use App\Services\Review\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập để có thể đánh giá sản phẩm', 'error' => 'Unauthorized'], 401);
        }

        $reviewData = $request->validated();
        $reviewData['author_id'] = Auth::user()->id;
        $files = $request->input('file_ids');
        $review = Review::whereProductId($reviewData['product_id'])->whereAuthorId($reviewData['author_id'])->first();
        if ($review) {
            return RETURN412;
            return response()->json(['message' => 'Bạn chỉ được đánh giá sản phẩm này 1 lần', 'error' => 'Unauthorized'], 401);
        }

        try {
            $obj = Review::create($reviewData);
            if ($obj && $files) {
                $obj->files()->sync($files);
            }
            $avgRate = round($obj->product->reviews()->avg('rating'), 1);
            $obj->product->update(['avg_rate' => $avgRate]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra! vui lòng liên hệ với admin',
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json(['status' => true, 'result' => $obj]);
    }

    public function update(ReviewRequest $request, $review)
    {
        $author_id = Auth::user()->id;
        $reviewData = $request->validated();
        $files = $request->input('file_ids');
        $review = Review::query()->whereId($review)->whereAuthorId($author_id)->first();

        if(!isAuthor($review) || !isAdmin()) {
            return response()->json(['message' => 'Không có quyền đánh giá sản phẩm', 'error' => 'Unauthorized'], 401);
        }

        if(!$review) {
            return response()->json(['message' => 'Không tìm thấy đánh giá nào như vậy', 'error' => 'Not Found'], 404);
        }

        try {
            if ($files) {
                $review->files()->sync($files);
            }
            $avgRate = round($review->product->reviews()->avg('rating'), 1);
            $review->product->update(['avg_rate' => $avgRate]);
            $review->update($reviewData);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra! vui lòng liên hệ với admin',
                'error' => $e->getMessage(),
            ]);
        }

        return back();
    }
}
