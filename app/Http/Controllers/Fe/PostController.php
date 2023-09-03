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
        $post = Posts::with('category')
            ->with('avatar')
            ->with('files')
            ->with('pdws')
            ->where('code', $code)
            ->first();
        $attrs = $this->postModel->getAttOptions();

        $post['file_ids'] = $post['files']->pluck('id');
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
            $files = $request->input('file_ids');
            if ($files) {
                $obj->files()->sync($files);
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
        $files = $request->input('file_ids');

        if ($files) {
            $post->files()->sync($files);
        }

//        $request->except('files');
//        $params = $request->except(['file_ids', 'files']);
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
