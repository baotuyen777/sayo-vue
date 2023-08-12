<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Posts;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('avatar')->get();
        $posts = Posts::with('avatar')->get();

        return view('home', ['categories' => $categories, 'posts' => $posts]);
    }
}
