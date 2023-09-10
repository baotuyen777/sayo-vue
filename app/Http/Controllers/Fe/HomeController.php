<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pdws;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pdw\Province;
use App\Models\Pdw\District;
use App\Models\Pdw\Ward;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('avatar')->get();
        $posts = Posts::with('avatar')->get();

        return view('pages/home', ['categories' => $categories, 'posts' => $posts]);
    }

    public function archive(Request $request, $catSlug = null, $provinceCode = null, $districtCode = null, $wardCode = null)
    {
//        dd(url());
//        dd($catSlug, $provinceCode , $districtCode);

        $currentPage = $request->input('current') ?? 1;
        $pageSize = $request->input('page_size') ?? 20;

        $province = Province::where('code', $provinceCode)->first();

        $category = Category::where('code', $catSlug)->first();
        $attr = [
            'category' => $category,
            'provinces' => Province::get(),
            'province' => $province,
            'district' => [],
            'districts' => [],
            'wards' => [],
            'ward' => [],
            'objs' => [],
        ];

        $posts = Posts::select('*')
            ->where('category_id', $category->id)
//            ->whereHas('category', function ($query) use ($catSlug) {
//                $query->where('code', $catSlug);
//            })
            ->with('avatar')->with('files');


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

            $attr['districts'] = District::whereProvinceId($province->id ?? 1)->get();
            $district = District::where('code', $districtCode)->first();
            $attr['district'] = $district;
            if ($districtCode && $district) {
                $posts->where('district_id', $district->id);
                $attr['wards'] = Ward::whereDistrictId($district->id)->get();

                $ward = Ward::where('code', $wardCode)->first();
                if ($ward) {
                    $attr['ward'] = $ward;
                    $posts->where('ward_id', $ward->id);
                }

            }

        }

        $attr['objs'] = $posts->paginate($pageSize, ['*'], 'page', $currentPage);

        return view('pages/archive', $attr);
    }


    public function page($code)
    {
        $obj = Posts::where('code', $code)->first();
        return view('pages/page', ['obj' => $obj]);
    }

//    public function publicPost()
//    {
//        $categories = Category::with('avatar')->get();
//        $address = [
//            ['id' => 1, 'name' => 'Phường Thanh Xuân Bắc, Quận Thanh Xuân, Hà Nội'],
//            ['id' => 2, 'name' => 'Phường Thanh Xuân Trung, Quận Thanh Xuân, Hà Nội'],
//        ];
//
//        return view('pages/public-post', ['categories' => $categories, 'postStates' => Posts::$states, 'address' => $address]);
//    }
}
