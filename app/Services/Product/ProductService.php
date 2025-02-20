<?php

namespace App\Services\Product;

use App\Models\Category;
use App\Models\Product;

class ProductService
{
    function __construct()
    {
        $this->res = [
            'provinces' => [],
            'province' => null,
            'districts' => [],
            'district' => null,
            'wards' => [],
            'ward' => null,
            'objs' => [],
            'categories' => [],
            'category' => null
        ];
    }
    function getAttrField($product = false, $filterNull = false)
    {
        $config = Product::$attr;

        $attrs = json_decode(str_replace('%22', '', $product->attr));
        $res = [];
        foreach ($config as $k => $item) {
            if (isset($attrs->$k)) {
                $rawValue = $attrs->$k;
                $item['value'] = $rawValue;
                $item['valueLabel'] = $item['options'][$rawValue] ?? $rawValue;
                if (isset($item['type'])) {
                    if ($item['type'] == 'boolean') {
                        $item['valueLabel'] = $rawValue ? 'Có' : 'Không';
                    }
                    if ($item['type'] == 'money') {
                        $item['valueLabel'] = moneyFormat($rawValue);
                    }
                    if ($item['type'] == 's') {
                        $item['valueLabel'] = $rawValue . 'm2';
                    }
                }
            } else if ($filterNull) {
                continue;
            }

            $res[$k] = $item;
        }

        return $res;
    }

    public function getAttrOptions($product = null)
    {
        $categories = Category::with('avatar')->get();

        return get_defined_vars();
    }

    public function getAll($request)
    {
        $currentPage = $request->input('current');
        $pageSize = $request->input('page_size') ?? 24;

        $catCode = $request->input('catCode');
        $category = Category::where('code', $catCode)->first();
        $res = [
            'category' => $category,
            'objs' => [],
            'categories' => Category::with('avatar')->get()
        ];


        $products = Product::select('*')->with('avatar')->with('files')->with('category');
//        ->where('status',STATUS_ACTIVE)

        if($request->input('status')){
            $products->where('status', $request->input('status'));
        }


        if ($request->input('author_id')) {
            $products->where('author_id', $request->input('author_id'));
        }

        if ($catCode && $category) {
            $products->where('category_id', $category->id);
            //            ->whereHas('category', function ($query) use ($catCode) {
//                $query->where('code', $catCode);
//            })
        }

        $price_from = $request->input('price_from');
        if ($price_from) {
            $products->where('price', '>', $price_from);
        }

        $price_to = $request->input('price_to');
        if ($price_to) {
            $products->where('price', '<', $price_to);
        }

        $s = $request->input('s');
        if ($s) {
            $products->where('name', 'like', "%{$s}%");
        }

        $res['objs'] = $products->orderBy('status')->orderBy('created_at', 'desc')->paginate($pageSize, ['*'], 'page', $currentPage);

        return $res;
    }

    function getAllSimple($request, $where = [])
    {
        $s = $request->input('s');
        $currentPage = $request->input('current') ?? $request->input('page');
        $pageSize = $request->input('page_size') ?? 10;

        $products = Product::with('avatar');
        if ($s) {
            $products->where('name', 'like', "%{$s}%");
        }

        foreach ($where as $k => $v) {
            $products->where($k, $v);
        }
//dd($currentPage);
        return $products->orderBy('created_at', 'desc')
            ->paginate($pageSize, ['*'], 'page', $currentPage);
    }

}
