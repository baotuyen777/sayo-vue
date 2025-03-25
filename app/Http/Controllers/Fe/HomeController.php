<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Models\Pdws;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = getCategories();// Category::with('avatar')->get() ;

        $posts = Post::getAll($request->all());

        return view('pages/home', ['categories' => $categories, 'posts' => $posts]);
    }

    public function page($code)
    {
        $obj = Post::where('code', $code)->first();
        return view('pages/page', ['obj' => $obj]);
    }

    public function testEmail()
    {
        $name = 'abcd';
        Mail::send('pages.auth.mail_success', compact('name'), function ($email) {
            $email->subject('sayo test');
            $email->to('baotuyen111@gmail.com', 'abcde');
        });
    }
}
