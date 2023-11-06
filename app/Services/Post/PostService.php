<?php

namespace App\Services\Post;

use App\Models\Category;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\Post;

class PostService
{
    private array $res = [];

    function getAttrField($post = false, $filterNull = false)
    {
        $config = Post::$attr;

        $attrs = json_decode(str_replace('%22', '', $post->attr));
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

    public function getAttrOptions($post = null)
    {
        $categories = Category::with('avatar')->get();
        $provinces = Province::get()->keyBy('id');
        $districts = $post ? District::whereProvinceId($post->province_id)->get()->keyBy('id') : [];
        $wards = $post ? Ward::whereDistrictId($post->district_id)->get()->keyBy('id') : [];

        return get_defined_vars();
    }

    public function getAll($request)
    {
        $currentPage = $request->input('current');
        $pageSize = $request->input('page_size') ?? 24;

        $provinceCode = $request->input('provinceCode');
        $province = Province::where('code', $provinceCode)->first();

        $catCode = $request->input('catCode');
        $category = Category::where('code', $catCode)->first();
        $this->res = [
            'category' => $category,
            'provinces' => Province::get(),
            'province' => $province,
            'district' => [],
            'districts' => [],
            'wards' => [],
            'ward' => [],
            'objs' => [],
            'categories' => Category::with('avatar')->get()
        ];


        $posts = Post::select('*')->with('avatar')->with('files')->with('category');
        $posts = $this->filter($request, $posts, $category, $province);

        $this->res['objs'] = $posts->orderBy('status')->orderBy('created_at', 'desc')->paginate($pageSize, ['*'], 'page', $currentPage);
        return $this->res;
    }

    private function filter($request, $objs, $category = null, $province = null)
    {
        if ($request->input('status')) {
            $objs->where('status', $request->input('status'));
        }

        if ($request->input('author_id')) {
            $objs->where('author_id', $request->input('author_id'));
        }

        if ($category) {
            $objs->where('category_id', $category->id);
            //            ->whereHas('category', function ($query) use ($catSlug) {
//                $query->where('code', $catSlug);
//            })
        }

        $priceFrom = $request->input('price_from');
        if ($priceFrom) {
            $objs->where('price', '>', $priceFrom);
        }

        $priceTo = $request->input('price_to');
        if ($priceTo) {
            $objs->where('price', '<', $priceTo);
        }

        $s = $request->input('s');
        if ($s) {
            $objs->where('name', 'like', "%{$s}%");
        }

        if ($province) {
            $objs->where('province_id', $province->id);

            $this->res['districts'] = District::whereProvinceId($province->id ?? 1)->get();
            $districtCode = $request->input('districtCode');
            $district = District::where('code', $districtCode)->first();
            $this->res['district'] = $district;

            if ($districtCode && $district) {
                $objs->where('district_id', $district->id);
                $this->res['wards'] = Ward::whereDistrictId($district->id)->get();
                $wardCode = $request->input('wardCode');
                $ward = Ward::where('code', $wardCode)->first();

                if ($ward) {
                    $this->res['ward'] = $ward;
                    $objs->where('ward_id', $ward->id);
                }
            }
        }

        return $objs;
    }

    function getAllSimple($request, $where = [])
    {
        $s = $request->input('s');
        $currentPage = $request->input('current') ?? $request->input('page');
        $pageSize = $request->input('page_size') ?? 10;

        $posts = Post::with('avatar');
        if ($s) {
            $posts->where('name', 'like', "%{$s}%");
        }

        foreach ($where as $k => $v) {
            $posts->where($k, $v);
        }

        return $posts->orderBy('created_at', 'desc')
            ->paginate($pageSize, ['*'], 'page', $currentPage);
    }

}
