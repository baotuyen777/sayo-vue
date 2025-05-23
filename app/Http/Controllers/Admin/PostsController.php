<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    protected string $module = 'posts';
    private BaseService $baseService;

    public function __construct(BaseService $baseService)
    {
        $this->baseService = $baseService;
//        parent::__construct();
    }

    public function index(Request $request)
    {
        $s = $request->input('s');
        $currentPage = $request->input('current');
        $pageSize = $request->input('page_size') ?? 5;
        $selectStatus = DB::raw('if(status = 1, "Hoạt động", "Tạm dừng") as status_label');
        $objs = Post::select('*', $selectStatus)
            ->where('name', 'like', "%{$s}%")
            ->where('code', 'like', "%{$s}%")
            ->with('avatar')
            ->with('files')
            ->paginate($pageSize, ['*'], 'page', $currentPage);
        return response()->json($objs);
//       return parent::index($request); // TODO: Change the autogenerated stub
    }

    public function show($id)
    {
        $categories = DB::table('categories')->select('id as value', 'name as label')->get();
        $provinces = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 1)->get();
        $districts = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 2)->get();
        $wards = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 3)->get();

        $obj = Post::with('files')
            ->with('avatar')
            ->with('category')
            ->with('pdws')
            ->find($id);

        return response()->json([
            'result' => $obj,
            'expand' => [
                'categories' => $categories,
                'provinces' => $provinces,
                'districts' => $districts,
                'wards' => $wards,
            ],
            'status' => true
        ]);
    }

    public function store(PostRequest $request)
    {
//        $this->baseService->validate($request, $this->module);
        $obj = DB::table($this->module)->insert($request->all());
        return $obj;
    }

    public function update(PostRequest $request, $id)
    {
//        $this->baseService->validate($request, $this->module,  ['code' => 'required']);
        $posts = Post::find($id);

        $files = $request->input('file_ids');

        if ($files) {
            $posts->files()->sync($files);
        }

//        $request->except('files');
        $params = $request->except(['file_ids', 'files']);
        $res = Post::where('id', $id)->update($params);

        return response()->json(['status' => true, 'result' => $res]);
    }


}
