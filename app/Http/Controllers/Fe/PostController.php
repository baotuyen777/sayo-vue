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
        $post['attr'] = json_decode(str_replace('%22', '', $post['attr']));
        return view('pages/post/detail', $attrs);
    }

    public function postDetail($catCode, $code)
    {
        $post = Posts::select('*')
            ->with('avatar')
            ->with('files')
            ->with('category')
            ->with('author')
            ->where('code', $code)
            ->first();
        if (!$post) {
            return view('pages/404');
        }
        return view('pages/post', ['obj' => $post]);
    }

    public function store(PostRequest $request)
    {
        $params = $request->all();
        $userid = Auth::id();

        if (!$userid) {
            return redirect()->route('login');
        }
        $files = $request->input('file_ids');
        if ($files) {
            $params['avatar_id'] = $files[0];
        }

        $params['code'] = time() . '-' . $userid;
        $params['author_id'] = $userid;
        $params['attr'] = str_replace(['\"', '%22'], '', json_encode($params['attr']));

        $obj = Posts::create($params);
        if ($obj && $files) {
            $obj->files()->sync($files);
        }

        return ['status' => true, 'result' => $obj];
    }

    public function create()
    {
        if (!Auth::check()) {
            return view('pages/auth/login');
        }

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

    public function me(Request $request)
    {
        $userid = Auth::id();
        if (!$userid) {
            return redirect()->route('login');
        }

        $s = $request->input('s');
        $currentPage = $request->input('current');
        $pageSize = $request->input('page_size') ?? 10;

        $posts = Posts::with('avatar')
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize, ['*'], 'page', $currentPage);;
        return view('pages/post/me', ['objs' => $posts]);
    }

}
