<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pdws;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Kjmtrue\VietnamZone\Models\Province;
use \Kjmtrue\VietnamZone\Models\District;
use \Kjmtrue\VietnamZone\Models\Ward;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('avatar')->get();
        $posts = Posts::with('avatar')->get();

        return view('pages/home', ['categories' => $categories, 'posts' => $posts]);
    }

    public function archive(Request $request, $catSlug = null, $provinceCode = null)
    {
        $s = $request->input('s');
        $currentPage = $request->input('current') ?? 1;
        $pageSize = $request->input('page_size') ?? 20;

        $category = Category::where('code', $catSlug)->first();

        $province = Province::where('code', $provinceCode)->first();
        $posts = Posts::select('*')
            ->where('name', 'like', "%{$s}%")
            ->whereHas('category', function ($query) use ($catSlug) {
                $query->where('code', $catSlug);
            })
            ->with('avatar')->with('files');

        if ($provinceCode) {
            $posts->where('province_id', $province->id);
        }

        $posts = $posts->paginate($pageSize, ['*'], 'page', $currentPage);

        $provinces = Province::get();
        $districts = District::whereProvinceId(50)->get();
        $wards = Ward::whereDistrictId(552)->get();

        return view('pages/archive', ['posts' => $posts, 'category' => $category,
            'provinces' => $provinces, 'districts' => $districts, 'wards' => $wards
        ]);
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
