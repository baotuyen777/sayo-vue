<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pdws;
use App\Models\Post;


class HomeController extends Controller
{
    public function index()
    {
        $categories = getCategories();// Category::with('avatar')->get() ;

        $posts = Post::getAll();

        return view('pages/home', ['categories' => $categories, 'posts' => $posts]);
    }


    public function page($code)
    {
        $obj = Post::where('code', $code)->first();
        return view('pages/page', ['obj' => $obj]);
    }

}
