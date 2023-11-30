<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\Files;
use App\Models\Post;
use App\Models\PostComment;
use App\Services\Post\PostCrawlService;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    function __construct(
        private readonly PostService      $postsService,
        private readonly PostCrawlService $postCrawlService
    )
    {
    }

    public function index(Request $request, $catCode = null, $provinceCode = null, $districtCode = null, $wardCode = null)
    {
        if (!Auth::user()) {
            return view('pages/auth/login');
        }

        if (!isAdmin()) {
            $request->merge(['author_id' => Auth::user()->id]);
        }

        $res = $this->postsService->getAll($request);

        return view('pages/post/list', $res);
    }

    public function archive(Request $request, $catCode = null, $provinceCode = null, $districtCode = null, $wardCode = null)
    {
        $extraParam = [
            'catCode' => $catCode,
            'provinceCode' => $provinceCode,
            'districtCode' => $districtCode,
            'wardCode' => $wardCode,
            'status' => STATUS_ACTIVE
        ];

        $request->merge($extraParam);
        $res = $this->postsService->getAll($request);
        $res['pageName'] = 'Mua bán ' . strtolower($res['category']->name ?? 'tất cả danh mục');
        return view('pages/post/archive', $res);
    }

    public function edit($code)
    {
        $obj = Post::with('category')
            ->with('avatar')
            ->with('files')
            ->where('code', $code)
            ->first();

        if (!$obj || (!isAuthor($obj) && !isAdmin())) {
            return view('pages.404');
        }

        $output = $this->postsService->getAttrOptions($obj);

        $obj['province_name'] = $output['provinces']->get($obj->province_id)->name ?? '';
        $obj['district_name'] = $output['districts']->get($obj->district_id)->name ?? '';
        $obj['ward_name'] = $output['wards']->get($obj->ward_id)->name ?? '';

        $obj['file_ids'] = $obj['files']->pluck('id');
        $obj['attr'] = $this->postsService->getAttrField($obj);

        $output['obj'] = $obj;

        return view('pages/post/detail', $output);
    }

    //Show the form for view . $catCode dung tren url
    public function show($catCode, $code)
    {
        $obj = Post::getOne($code, true);

        if (!$obj) {
            return view('pages.404');
        }

        $postKey = 'posts_' . $code;

        // Kiểm tra Session của bài viết có tồn tại hay không.
        // Nếu không tồn tại, sẽ tự động tăng trường viewed_quantity lên 1 đồng thời tạo session lưu trữ key bài viết.
        if (!Session::has($postKey)) {
            Post::where('code', $code)->increment('viewed_quantity');
            Session::put($postKey, 1);
        }

        $obj['attr'] = $this->postsService->getAttrField($obj, true);
//        $post['cat_code'] = $catCode;
//        dd($post['attr']);
        return view('pages.post.view', ['obj' => $obj]);
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

        $obj = Post::create($params);
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

        return view('pages/post/detail', array_merge(Post::$attr, $options));
    }

    public function updateSimple(Request $request, $code)
    {
        $post = Post::where('code', $code)->first();

        $params = $request->all();
        $res = $post->update($params);
        if ($res) {
            $post = Post::where('code', $code)->first();
        }

        return response()->json(['status' => $res, 'result' => $post]);
    }

    public function update(PostRequest $request, $code)
    {
//        $this->baseService->validate($request, $this->module,  ['code' => 'required']);
        $post = Post::where('code', $code)->first();
        $files = $request->input('file_ids');

        if ($files) {
            $post->files()->sync($files);
        }

        $params = $request->all();

        if (isset($params['attr'])) {
            $params['attr'] = str_replace(['\"', '%22'], '', json_encode($params['attr']));
        }

        $res = $post->update($params);
        Cache::forget(Post::CACHE_KEY . $code);
        return response()->json(['status' => true, 'result' => $res]);
    }

    public function destroy($code): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->postsService->destroy($code));
    }

    public function crawl(Request $request)
    {
        $url = $request->input('url');
        $isSingle = $request->input('is_single') ?? false;
        $this->postCrawlService->crawl($url, $isSingle);
    }
}
