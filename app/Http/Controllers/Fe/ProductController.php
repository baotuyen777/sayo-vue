<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    function __construct(private readonly ProductService $productsService)
    {
    }

    public function index(Request $request)
    {
        if (!Auth::user()) {
            return view('pages/auth/login');
        }

        if (Auth::user()->role > 1) {
            $extraParam['author_id'] = Auth::user()->id;
        }

        $res = $this->productsService->getAll($request);

        return view('pages/product/list', $res);
    }

    public function archive(Request $request, $catCode = null)
    {
        $extraParam = [
            'catCode' => $catCode,
            'status' => STATUS_ACTIVE
        ];
        $request->merge($extraParam);
        $res = $this->productsService->getAll($request);
        $res['pageName'] = 'Mua bán ' . strtolower($res['category']->name ?? 'tất cả danh mục');
        return view('pages/product/archive', $res);
    }

    public function edit($code)
    {
        $product = Product::with('category')
            ->with('avatar')
            ->with('files')
            ->where('code', $code)
            ->first();

        if (!isAuthor($product) && !isAdmin()) {
            return view('pages.404');
        }
        $output = $this->productsService->getAttrOptions($product);

        $product['file_ids'] = $product['files']->pluck('id');
        $product['attr'] = $this->productsService->getAttrField($product);

        $output['obj'] = $product;

        return view('pages/product/detail', $output);
    }

    //view for everyone . $catCode dung tren url
    public function show($catCode, $code)
    {
        $product = Product::select('*')
            ->with('avatar')
            ->with('files')
            ->with('category')
            ->with('author')
            ->with('reviews')
            ->where('code', $code)
            ->first();

        if (!$product) {
            return view('pages/404');
        }

        $product['attr'] = $this->productsService->getAttrField($product, true);
//        dd($product);
//        $product['cat_code'] = $catCode;
//        dd($product['attr']);
        return view('pages/product/view', ['obj' => $product]);
    }

    public function store(ProductRequest $request)
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

        $obj = Product::create($params);
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

        $options = $this->productsService->getAttrOptions();

        return view('pages/product/detail', array_merge(Product::$attr, $options));
    }

    public function updateSimple(Request $request, $code)
    {
        $product = Product::where('code', $code)->first();

        $params = $request->all();
        $res = $product->update($params);
        if ($res) {
            $product = Product::where('code', $code)->first();
        }

        return response()->json(['status' => $res, 'result' => $product]);
    }

    public function update(ProductRequest $request, $code)
    {
//        $this->baseService->validate($request, $this->module,  ['code' => 'required']);
        $product = Product::where('code', $code)->first();
        $files = $request->input('file_ids');

        if ($files) {
            $product->files()->sync($files);
        }

        $params = $request->all();

        if (isset($params['attr'])) {
            $params['attr'] = str_replace(['\"', '%22'], '', json_encode($params['attr']));
        }

        $res = $product->update($params);

        return response()->json(['status' => true, 'result' => $res]);
    }


    public function destroy($code)
    {
        $obj = Product::where('code', $code)->first();
        if (!isAuthor($obj)) {
            return view('pages.404');
        }

        $obj->delete();
        return response()->json(['status' => true, 'result' => $obj]);
    }
}
