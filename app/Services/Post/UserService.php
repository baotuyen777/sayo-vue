<?php

namespace App\Services\Post;

use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getPagination($request)
    {
        $s = $request->input('s');
        $pageSize = $request->input('page_size') ?? 5;
        $rolesLabel = DB::raw('if(role < 3, "Staff", "Khách") as role_label');
        $selectStatus = DB::raw('if(status = 1, "Hoạt động", "Tạm dừng") as status_label');
        $user = $this->userRepository->getUser($s, $pageSize, $rolesLabel, $selectStatus);
        return $user;
    }

    public function getOne($userName)
    {
        return $this->userRepository->getOne($userName);
    }

    public function editUser($username)
    {
        if
        (
            !Auth::user() || Auth::user()->role > 1) {
            return false;
        }
        $user = $this->getOne($username);
        $attrs = $this->getAttrOptions($user);
        $user->province_name = $attrs['provinces']->get($user->province_id)->name ?? "";
        $user->district_name = $attrs['districts']->get($user->district_id)->name ?? "";
        $user->ward_name = $attrs['wards']->get($user->ward_id)->name ?? "";

        $attrs['obj'] = $user;
        return $attrs;
    }

    public function profile()
    {
        $attrs = $this->getAttrOptions();
        $userName = Auth::user()->username;
        if (!$userName) {
            return false;
        }
        $user = $this->getOne($userName);
        $attrs['obj'] = $user;
        $attrs['user'] = $user;
        return $attrs;
    }

    public function updateSimple($request, $useName)
    {
        if (!Auth::user() || Auth::user()->role > 1) {
            return false;
        }
        $post = $this->userRepository->getDataWithConditions(
            '*',
            ['username' => $useName]
        )->first();

        $params = $request->all();
        $res = $post->update($params);
        if ($res) {
            $post = $this->userRepository->getDataWithConditions(
                '*',
                ['username' => $useName]
            )->first();
        }

        return response()->json(['status' => $res, 'result' => $post]);
    }

    public function updateUser($request, $username)
    {
        if (!Auth::user() || (Auth::user()->role > ROLE_ADMIN && Auth::user()->username != $username)) {
            return view('pages/404');
        }

        if ($request->input('change_password')) {
            $request->merge([
                'password' => Hash::make($request['password']),
                'change_password_at' => Carbon::now()
            ]);
        }
        $this->getOne($username)->update($request->all());
        $res = $this->getOne($username);
        return response()->json(['status' => true, 'result' => $res]);
    }
    public function destroy($userName)
    {
        if (!Auth::user() || Auth::user()->role > 1) {
            return false;
        }

        $obj = $this->userRepository->getDataWithConditions(
            '*',
            ['username' => $userName]
        )->delete();
        return response()->json(['status' => true, 'result' => $obj]);
    }

    public function getAttrOptions($post = null)
    {
        $provinces = Province::get()->keyBy('id');
        $districts = $post ? District::whereProvinceId($post->province_id)->get()->keyBy('id') : [];
        $wards = $post ? Ward::whereDistrictId($post->district_id)->get()->keyBy('id') : [];
        $genders = User::$gender;
        return get_defined_vars();
    }


}
