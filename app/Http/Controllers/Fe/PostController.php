<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\Posts;
use App\Services\PostService;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    function __construct(private Posts $postModel, private PostService $postsService)
    {
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
//        $post['attr'] = $this->postsService->getAttrField();
//        $attrs = $this->postsService->getAttrOptions();
        $attrs = Posts::$attr;
//dd($attrs);
        return view('pages/post/detail', array_merge($attrs, $options));
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
            ->where('author_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize, ['*'], 'page', $currentPage);;

        return view('pages/post/me', ['objs' => $posts]);
    }

    public function archive(Request $request, $catCode = null, $provinceCode = null, $districtCode = null, $wardCode = null)
    {
        $res = $this->postsService->getAll($request, $catCode, $provinceCode, $districtCode, $wardCode);

        return view('pages/post/archive', $res);
    }

    public function destroy($id)
    {

    }

}
