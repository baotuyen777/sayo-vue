<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('avatar')->get();
        $posts = Posts::with('avatar')->get();

        return view('home', ['categories' => $categories, 'posts' => $posts]);
    }

    public function archive(Request $request, $catSlug)
    {
        $s = $request->input('s');
        $currentPage = $request->input('current') ?? 1;
        $pageSize = $request->input('page_size') ?? 20;

        $category = Category::where('code', $catSlug)->first();

        $posts = Posts::select('*')
            ->where('name', 'like', "%{$s}%")
            ->whereHas('category', function ($query) use ($catSlug) {
                $query->where('code', $catSlug);
            })
            ->with('avatar')
            ->with('gallery')
            ->paginate($pageSize, ['*'], 'page', $currentPage);

        return view('pages/archive', ['posts' => $posts, 'category' => $category]);
    }

    public function postDetail($postId)
    {
        $post = Posts::select('*')
            ->with('avatar')
            ->with('gallery')
            ->with('category')
            ->with('author')
            ->first();
        return view('pages/post', ['obj' => $post]);
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
