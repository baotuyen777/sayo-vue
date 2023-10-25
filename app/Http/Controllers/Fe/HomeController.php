<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pdws;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pdw\Province;
use App\Models\Pdw\District;
use App\Models\Pdw\Ward;

class HomeController extends Controller
{
    public function index()
    {
        $categories = getCategories();// Category::with('avatar')->get() ;

        $posts = Post::where('status', '=', 2)->with('avatar')->with('category')->orderBy('created_at', 'desc')->paginate(24);

        return view('pages/home', ['categories' => $categories, 'posts' => $posts]);
    }


    public function page($code)
    {
        $obj = Post::where('code', $code)->first();
        return view('pages/page', ['obj' => $obj]);
    }

}
