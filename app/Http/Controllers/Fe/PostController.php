<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;

use App\Models\Posts;
use App\Services\PostService;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    function __construct(private readonly PostService $postsService)
    {
    }

    public function index(Request $request, $catCode = null, $provinceCode = null, $districtCode = null, $wardCode = null)
    {
        $res = $this->postsService->getAll($request, $catCode, $provinceCode, $districtCode, $wardCode);

        return view('pages/post/list', $res);
    }

    public function edit($code)
    {
        $post = Posts::with('category')
            ->with('avatar')
            ->with('files')
//            ->with('pdws')
            ->where('code', $code)
            ->first();
        $output = $this->postsService->getAttrOptions($post);
//$relations =[];
        $post['province_name'] = $output['provinces']->get($post->province_id)->name ?? '';
        $post['district_name'] = $output['districts']->get($post->district_id)->name ?? '';
        $post['ward_name'] = $output['wards']->get($post->ward_id)->name ?? '';

        $post['file_ids'] = $post['files']->pluck('id');
        $post['attr'] = $this->postsService->getAttrField($post);
//dd($post['attr']);
        $output['obj'] = $post;
//        $post['attr'] = json_decode(str_replace('%22', '', $post['attr']));

        return view('pages/post/detail', $output);
    }

    //Show the form for editing .
    public function show($catCode, $code)
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

        $post['attr'] = $this->postsService->getAttrField($post, true);
//        dd($post['attr']);
        return view('pages/post/view', ['obj' => $post]);
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

        $options = $this->postsService->getAttrOptions();

        return view('pages/post/detail', array_merge(Posts::$attr, $options));
    }

    public function updateSimple(Request $request, $code)
    {
        $post = Posts::where('code', $code)->first();

        $params = $request->all();
        $res = $post->update($params);
        if ($res) {
            $post = Posts::where('code', $code)->first();
        }

        return response()->json(['status' => $res  , 'result' => $post]);
    }

    public function update(PostRequest $request, $code)
    {
//        $this->baseService->validate($request, $this->module,  ['code' => 'required']);
        $post = Posts::where('code', $code)->first();
        $files = $request->input('file_ids');

        if ($files) {
            $post->files()->sync($files);
        }

        $params = $request->all();

        if (isset($params['attr'])) {
            $params['attr'] = str_replace(['\"', '%22'], '', json_encode($params['attr']));
        }

        $res = $post->update($params);

        return response()->json(['status' => true, 'result' => $res]);
    }

//    public function me(Request $request)
//    {
//        $userid = Auth::id();
//        if (!$userid) {
//            return redirect()->route('login');
//        }
//        $posts = $this->postService->getAllSimple($request, ['author_id' => $userid]);
//
//
//        return view('pages/post/me', ['objs' => $posts]);
//    }

    public function archive(Request $request, $catCode = null, $provinceCode = null, $districtCode = null, $wardCode = null)
    {
        $res = $this->postsService->getAll($request, $catCode, $provinceCode, $districtCode, $wardCode);

        return view('pages/post/archive', $res);
    }

    public function destroy($id)
    {

    }

}
