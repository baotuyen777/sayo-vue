<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Posts;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(private User $userModel,private Posts $postModel)
    {
        $this->userModel = $userModel;
        $this->postModel = $postModel;
    }

    public function show(Request $request, $userName)
    {
        $userid = Auth::id();
        if (!$userid) {
            return redirect()->route('login');
        }

        $user = User::where('username',$userName)->first();
        if($user){
            $s = $request->input('s');
            $currentPage = $request->input('current');
            $pageSize = $request->input('page_size') ?? 10;

            $posts = Posts::with('avatar')
                ->where('author_id',$user->id)
                ->orderBy('created_at', 'desc')
                ->paginate($pageSize, ['*'], 'page', $currentPage);;
            return view('pages/user/dashboard', ['posts' => $posts]);
        }
        return view('pages/404');

    }
    public function profile()
    {
        $attrs = $this->userModel->getAttOptions();
        $userId = Auth::user()->id;
        $user = User::with('avatar')->find($userId);
        $attrs['obj'] = $user;
        return view('pages/user/profile', $attrs);
    }

    public function update(Request $request, $id)
    {

        if ($request->input('change_password')) {
            $request->merge([
                'password' => Hash::make($request['password']),
                'change_password_at' => Carbon::now()
            ]);
        }
        User::find($id)->update($request->all());
        $res = User::find($id);
        return response()->json(['status' => true, 'result' => $res]);
    }

}
