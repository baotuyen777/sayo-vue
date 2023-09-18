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
