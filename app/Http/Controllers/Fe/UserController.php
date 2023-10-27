<?php

namespace App\Http\Controllers\Fe;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Post\PostService;
use App\Services\Post\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private User        $userModel,
        private PostService $postService,
        private UserService $userService
    )
    {
    }

    public function index(Request $request)
    {
        $s = $request->input('s');
        $pageSize = $request->input('page_size') ?? 24;
        $rolesLabel = DB::raw('if(role < 3, "Staff", "Khách") as role_label');
        $selectStatus = DB::raw('if(status = 1, "Hoạt động", "Tạm dừng") as status_label');

        $objs = User::join('departments', 'users.departments_id', '=', 'departments.id')
            ->select('users.*', $rolesLabel, $selectStatus)
            ->where('users.name', 'like', "%{$s}%")
            ->paginate($pageSize);

        return view('pages/user/list', ['objs' => $objs]);
    }

    public function show(Request $request, $userName)
    {
        $user = User::where('username', $userName)
            ->with('province')
            ->with('district')
            ->with('ward')
            ->first();

        if ($user) {
            $posts = $this->postService->getAllSimple($request, ['author_id' => $user->id]);


            return view('pages/user/dashboard', ['posts' => $posts, 'user' => $user]);
        }
        return view('pages/404');

    }

    public function edit($id) {
        if (!Auth::user() || Auth::user()->role > 1) {
            return view('pages/404');
        }
        $user = User::with(['avatar', 'district', 'ward', 'province'])->findOrFail($id);
        $attrs = $this->userService->getAttrOptions($user);
        $user->province_name = $attrs['provinces']->get($user->province_id)->name;
        $user->district_name = $attrs['districts']->get($user->district_id)->name ?? "";
        $user->ward_name = $attrs['wards']->get($user->ward_id)->name ?? "";

        $attrs['obj'] = $user;
        return view('pages.user.edit', $attrs);
    }

    public function profile()
    {
        $attrs = $this->userService->getAttrOptions();
        $userId = Auth::id();
        if (!$userId) {
            return view('pages.auth.login');
        }

        $user = User::with('avatar')->with('province')
            ->with('district')
            ->with('ward')->find($userId);
        $attrs['obj'] = $user;
        $attrs['user'] = $user;
        return view('pages/user/profile', $attrs);
    }

    public function updateSimple(Request $request, $useName)
    {
        if (!Auth::user() || Auth::user()->role > 1) {
            return view('pages/404');
        }
        $post = User::where('code', $useName)->first();

        $params = $request->all();
        $res = $post->update($params);
        if ($res) {
            $post = User::where('username', $useName)->first();
        }

        return response()->json(['status' => $res, 'result' => $post]);
    }

    public function update(Request $request, $id)
    {

        if (!Auth::user() || (Auth::user()->role > ROLE_ADMIN && Auth::user()->id != $id)) {
            return view('pages/404');
        }

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

    public function destroy($userName)
    {
        if (!Auth::user() || Auth::user()->role > 1) {
            return view('pages/404');
        }

        $obj = User::where('username', $userName)->delete();
        return response()->json(['status' => true, 'result' => $obj]);
    }
}
