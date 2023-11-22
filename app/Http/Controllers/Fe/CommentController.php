<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()) {
            return view('pages.auth.login');
        }

        if (Auth::user()->role != ROLE_ADMIN) {
            return view('pages.404');
        }

        $objs = PostComment::getAll();
        return view('pages.comment.index', ['objs' => $objs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCommentRequest $request)
    {
        $params = $request->validated();
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['message' => 'Bạn cần đăng nhập để có thể bình luận', 'error' => 'Unauthorized'], 401);
        }

        try {
            $params['user_id'] = $userId;
            $postComment = PostComment::create($params);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã có lỗi xảy ra vui lòng thử lại', 'error' => 'Internal Server Error'], 500);
        }


        return response()->json(['status' => true, 'result' => $postComment]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        PostComment::find($id)->update($request->all());
        $res = PostComment::find($id);
        return response()->json(['status' => true, 'result' => $res]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obj = PostComment::find($id);
        if (!isAuthor($obj)) {
            return view('pages.404');
        }

        $obj->delete();

        return response()->json(['status' => true, 'result' => $obj]);
    }
}
