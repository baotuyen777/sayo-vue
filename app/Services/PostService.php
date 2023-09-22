<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\Posts;

class PostService
{
    function getAttrField($post = false, $filterNull = false)
    {
        $config = Posts::$attr;

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

    public function getAll($request, $catCode = null, $provinceCode = null, $districtCode = null, $wardCode = null)
    {
        $currentPage = $request->input('current') ?? 1;
        $pageSize = $request->input('page_size') ?? 20;

        $province = Province::where('code', $provinceCode)->first();

        $category = Category::where('code', $catCode)->first();
        $res = [
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

        $posts = Posts::select('*')->with('avatar')->with('files');
        if ($catCode && $category) {
            $posts->where('category_id', $category->id);
            //            ->whereHas('category', function ($query) use ($catSlug) {
//                $query->where('code', $catSlug);
//            })
        }

        $price_from = $request->input('price_from');
        if ($price_from) {
            $posts->where('price', '>', $price_from);
        }

        $price_to = $request->input('price_to');
        if ($price_to) {
            $posts->where('price', '<', $price_to);
        }

        $s = $request->input('s');
        if ($s) {
            $posts->where('name', 'like', "%{$s}%");
        }

        if ($provinceCode && $province) {
            $posts->where('province_id', $province->id);

            $res['districts'] = District::whereProvinceId($province->id ?? 1)->get();
            $district = District::where('code', $districtCode)->first();
            $res['district'] = $district;
            if ($districtCode && $district) {
                $posts->where('district_id', $district->id);
                $res['wards'] = Ward::whereDistrictId($district->id)->get();

                $ward = Ward::where('code', $wardCode)->first();
                if ($ward) {
                    $res['ward'] = $ward;
                    $posts->where('ward_id', $ward->id);
                }

            }

        }

        $res['objs'] = $posts->paginate($pageSize, ['*'], 'page', $currentPage);

        return $res;
    }

}
