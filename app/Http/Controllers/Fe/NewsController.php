<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;

use App\Models\News;
use App\Models\Post;
use App\Services\NewsService;
use App\Services\PostService;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Exports\NewsExport;
use Maatwebsite\Excel\Facades\Excel;


class NewsController extends Controller
{
    function __construct(private readonly PostService $postsService, private readonly NewsService $crawlNewsService)
    {
    }

    public function index(Request $request, $catCode = null, $provinceCode = null, $districtCode = null, $wardCode = null)
    {

        if (!Auth::user()) {
            return view('pages/auth/login');
        }
        $extraParam = ['catCode' => $catCode, 'provinceCode' => $provinceCode, 'districtCode' => $districtCode, 'wardCode' => $wardCode];

        if (Auth::user()->role > 1) {
            $extraParam['author_id'] = Auth::user()->id;
        }

        $request->merge($extraParam);

        $res = $this->postsService->getAll($request);

        return view('pages/post/list', $res);
    }

    public function archive(Request $request)
    {
        $currentPage = $request->input('current');
        $pageSize = $request->input('page_size') ?? 24;
//        $res = $this->postsService->getAll($request);
        $objs = News::with('avatar')->orderBy('created_at', 'desc')->paginate($pageSize, ['*'], 'page', $currentPage);
//        $res['pageName'] = 'Hot girl';
        return view('pages/news/archive', ['objs' => $objs]);
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
    public function show($code)
    {
        $obj = News::select('*')
            ->with('avatar')
            ->with('author')
            ->where('code', $code)
            ->first();
        if (!$obj) {
            return view('pages/404');
        }

        $objs = News::with('avatar')->inRandomOrder()->limit(9)->get();
        return view('pages/news/view', ['obj' => $obj, 'objs' => $objs]);
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
        if (!checkAuthor($obj->author_id)) {
            return view('pages/404');
        }

        $obj->delete();
        return response()->json(['status' => true, 'result' => $obj]);
    }

    public function crawl(Request $request)
    {
        $url = $request->input('url') ?? 'https://badova.net/hotgirl/';
        $isSingle = $request->input('is_single') ?? false;
        $this->crawlNewsService->crawl($url, $isSingle);
    }

    public function export()
    {
//        return Excel::download(new NewsExport, 'news.xlsx'); //download file export
        return Excel::store(new NewsExport, 'exel/news.xlsx', 'public'); //lưu file export trên ổ cứng
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
}
