<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Admin\Controller;
use App\Models\UserLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $userLike = UserLike::where('author_id', Auth::user()->id)
            ->where('seller_id', $request->seller_id)
            ->first();
        if ($userLike) {
            $userLike = $userLike->delete();
        } else {
            $userLike = UserLike::query()->create([
                'author_id' => Auth::user()->id,
                'seller_id' => $request->seller_id
            ]);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
