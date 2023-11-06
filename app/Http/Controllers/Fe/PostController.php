<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\Files;
use App\Models\Post;
use App\Services\Post\PostCrawlService;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    function __construct(private readonly PostService $postsService, private readonly PostCrawlService $postCrawlService)
    {
    }

    public function index(Request $request, $catCode = null, $provinceCode = null, $districtCode = null, $wardCode = null)
    {

        if (!Auth::user()) {
            return view('pages/auth/login');
        }
        // $extraParam = ['catCode' => $catCode, 'provinceCode' => $provinceCode, 'districtCode' => $districtCode, 'wardCode' => $wardCode];

        if (Auth::user()->role > 1) {
            $extraParam['author_id'] = Auth::user()->id;
        }

        // $request->merge($extraParam);
//        ->where('status',STATUS_ACTIVE)

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
        $post = Post::with('category')
            ->with('avatar')
            ->with('files')
            ->where('code', $code)
            ->first();

        if (!checkAuthor($post->author_id)) {
            return view('pages/404');
        }
        $output = $this->postsService->getAttrOptions($post);

        $post['province_name'] = $output['provinces']->get($post->province_id)->name ?? '';
        $post['district_name'] = $output['districts']->get($post->district_id)->name ?? '';
        $post['ward_name'] = $output['wards']->get($post->ward_id)->name ?? '';

        $post['file_ids'] = $post['files']->pluck('id');
        $post['attr'] = $this->postsService->getAttrField($post);

        $output['obj'] = $post;

        return view('pages/post/detail', $output);
    }

    //Show the form for editing . $catCode dung tren url
    public function show($catCode, $code)
    {
        $post = Post::select('*')
            ->with('avatar')
            ->with('files')
            ->with('category')
            ->with('author')
            ->with('comments')
            ->where('code', $code)
            ->first();
        if (!$post) {
            return view('pages/404');
        }

        $post['attr'] = $this->postsService->getAttrField($post, true);
//        $post['cat_code'] = $catCode;
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

        return response()->json(['status' => true, 'result' => $res]);
    }


    public function destroy($code)
    {
        $obj = Post::where('code', $code)->first();
        if (!$obj) {
            return response()->json(RETURN404);
        }

        if (!checkAuthor($obj->author_id) && Auth::user()->role != ROLE_ADMIN) {
            return response()->json(RETURN_REQUIRED_ADMIN);
        }

        try {
            $urlFiles = $obj->files->pluck('url')->toArray();
            $urlStorages = array_map(function ($val) {
                return str_replace(asset('storage'), 'public', $val);
            }, $urlFiles);

            foreach ($urlStorages as $urlStorage) {
                if (Storage::exists($urlStorage)) {
                    Storage::delete($urlStorage);
                }
            }

            $fileIds = $obj->files->pluck('id')->toArray();
            Post::whereIn('avatar_id', $fileIds)->update(['avatar_id' => null]);
            $obj->files()->detach();
            Files::whereIn('id', $fileIds)->delete();
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra! vui lòng liên hệ với admin',
                'error' => $e->getMessage(),
            ]);
        }

        $obj->delete();
        return response()->json(['status' => true, 'result' => $obj]);
    }

    public function crawl(Request $request)
    {
        $url = $request->input('url');
        $isSingle = $request->input('is_single') ?? false;
        $this->postCrawlService->crawl($url, $isSingle);
    }

    public function comment(PostCommentRequest $request)
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
}
