<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Posts;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function show($id)
    {
        $categories = DB::table('categories')->select('id as value', 'name as label')->get();
        $provinces = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 1)->get();
        $districts = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 2)->get();
        $wards = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 3)->get();

        $obj = Posts::with('gallery')
            ->with('avatar')
            ->with('category')
            ->with('pdws')
            ->find($id);

        return response()->json([
            'result' => $obj,
            'expand' => [
                'categories' => $categories,
                'provinces' => $provinces,
                'districts' => $districts,
                'wards' => $wards,
            ],
            'status' => true
        ]);
    }

    public function store(PostRequest $request)
    {
        $params = $request->all();
        $userid = Auth::id();

        if (!$userid) {
            return redirect()->route('login');
        }

        $params['code'] = $userid . '-' . time();
        $params['author_id'] = $userid;
        $params['attr'] = str_replace('\"', '', json_encode($params['attr']));

        $obj = Posts::create($params);
//        dd($obj);
//        Posts::
        if ($obj) {
            return redirect()->route('home');
        }
        return $obj;
    }

    public function create()
    {
        $postModel = new Posts();
        $attrs = $postModel->getProductAtt();
//        dd($attrs);
//        return view('pages/public-post', ['categories' => $categories, 'postStates' => Posts::$states, 'address' => $address]);
        return view('pages/public-post', $attrs);
    }

    public function edit($id)
    {

    }

    public function update($id)
    {

    }

    public function destroy($id)
    {

    }
}
