<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Posts;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    function __construct(private Posts $postModel)
    {
        $this->postModel = $postModel;
    }

    public function show($code)
    {
        $post = Posts::with('gallery')
            ->with('avatar')
            ->with('gallery')
            ->with('category')
            ->with('pdws')
            ->where('code', $code)
            ->first();
//dd($post);
        $attrs = $this->postModel->getAttOptions();
        $attrs['obj'] = $post;
        return view('pages/post/detail', $attrs);
    }

    public function store(PostRequest $request)
    {
        $params = $request->all();
        $userid = Auth::id();

        if (!$userid) {
            return redirect()->route('login');
        }

        $params['code'] = $userid . '-' . time();
        $params['author_id'] = $userid;
        $params['attr'] = str_replace(['\"', '%22'], '', json_encode($params['attr']));

        $obj = Posts::create($params);
        if ($obj) {
            $galleryIds = $request->input('media_ids');
            if ($galleryIds) {
                $obj->gallery()->sync($galleryIds);
            }
        }

        return ['status' => true, 'result' => $obj];
    }

    public function create()
    {
        $postModel = new Posts();
        $attrs = $postModel->getAttOptions();
        return view('pages/post/detail', $attrs);
    }

    public function edit($id)
    {

    }

    public function update(PostRequest $request, $code)
    {
//        $this->baseService->validate($request, $this->module,  ['code' => 'required']);
        $post = Posts::where('code', $code)->first();
        $galleryIds = $request->input('media_ids');

        if ($galleryIds) {
            $post->gallery()->sync($galleryIds);
        }

//        $request->except('gallery');
//        $params = $request->except(['media_ids', 'gallery']);
//        $params =
        $res = $post->update($request->all());

        return response()->json(['status' => true, 'result' => $res]);
    }

    public function destroy($id)
    {

    }

    public function me()
    {
        $posts = Posts::with('avatar')->get();
        return view('pages/post/me', ['posts' => $posts]);
    }

}
