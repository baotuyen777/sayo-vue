<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    public function index()
    {
        $postComments = PostComment::with('user:id,name', 'children')
            ->where('item_id', 1)
            ->whereNull('parent_id')
            ->get();

        return view('component.comment.index', compact('postComments'));
    }

    public function store(PostCommentRequest $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $params = $request->validated();
        $userId = Auth::id();

        if (!$userId) {
            return back()->with('notify', 'Bạn cần đăng nhập để có thể bình luận')->with('notify_type', 'error');
        }

        $params['user_id'] = $userId;
        $postComment = PostComment::create($params);

        return response()->json(['status' => true, 'result' => $postComment]);
    }
}
