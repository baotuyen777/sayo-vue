<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\Post\PostCrawlService;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    function __construct(
        private readonly PostService      $postsService,
        private readonly PostCrawlService $postCrawlService
    )
    {
    }

    /**
     * Manage post
     * @param Request $request
     */
    public function index(Request $request)
    {
        if (!Auth::user()) {
            return view('pages/auth/login');
        }

        if (!isAdmin()) {
            $request->merge(['author_id' => Auth::user()->id]);
        }

        $request->merge(['status' => 'all']);
        $res = $this->postsService->getAll($request);

        return view('pages/post/list', $res);
    }

    /**
     * Show all active posts
     * @param Request $request
     */
    public function archive(Request $request)
    {
        $res = $this->postsService->getAll($request);
        $res['pageName'] = 'Mua bán ' . strtolower($res['category']->name ?? 'tất cả danh mục');
        return view('pages/post/archive', $res);
    }

    public function edit($code)
    {
        if (!isLoged()) {
            return view('pages/auth/login');
        }
//        $obj =Post::getInstance()->abc();
        $obj = Post::getOne($code, true, true);
        if (!$obj || (!isAuthor($obj) && !isAdmin())) {
            return view('pages/404');
        }

        $output = $this->postsService->getAttrOptions($obj);
        $output['obj'] = $obj;

        return view('pages/post/detail', $output);
    }

    //View post has slider .
    public function show()
    {
        $code = request()->route()->parameter('code');
        $obj = Post::getOne($code, true, true);

        if (!$obj) {
            return view('pages/404');
        }

        $this->postsService->incrementViewNumber($code);
        return view('pages/post/view', ['obj' => $obj]);
    }

    public function store(PostRequest $request)
    {
        return response()->json($this->postsService->store($request));
    }

    public function create()
    {
        if (!isLoged()) {
            return view('pages/auth/login');
        }

        $user = Auth::user();
        $options = $this->postsService->getAttrOptions($user);
        $obj = $this->postsService->populateSellerAddress($user);
        $options['obj'] = $obj;

        return view('pages/post/detail', array_merge(Post::$attr, $options));
    }

    /**
     * Update some field, not apply post validate
     * @param Request $request
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSimple(Request $request, $code)
    {
        $post = Post::query()->where('code', $code)->first();

        $params = $request->all();
        $res = $post->update($params);
        if ($res) {
            $post = Post::where('code', $code)->first();
        }

        return response()->json(['status' => $res, 'result' => $post]);
    }

    public function update(PostRequest $request, $code)
    {
        return response()->json($this->postsService->update($request, $code));
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

    public function getAttrs($catId)
    {
        $categoryFields = Post::$categoryFields;
        $catCode = getCategoryCode($catId);

        $fields = $categoryFields[$catCode] ?? [];

        if ($fields) {
            $output = ['fields' => $fields, 'attrs' => Post::$attr];
            return view('pages/post/attrs', $output);
        }

        return "";
    }
}
