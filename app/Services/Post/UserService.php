<?php

namespace App\Services\Post;

use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\User;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function getOneWithAttrs($userName)
    {
        if (!Auth::user()) {
            return ['status' => false, 'message' => 'Bạn chưa đăng nhập'];
        }
        $user = User::getOne($userName, true);
        $attrs = $this->getAttrOptions($user);

        $user->province_name = $attrs['provinces']->get($user->province_id)->name ?? "";
        $user->district_name = $attrs['districts']->get($user->district_id)->name ?? "";
        $user->ward_name = $attrs['wards']->get($user->ward_id)->name ?? "";

        return array_merge($attrs, ['obj' => $user]);
    }

    public function update($request, $userName)
    {
        if (!Auth::user() || (Auth::user()->role > ROLE_ADMIN && Auth::user()->username != $userName)) {
            return ['status' => false, 'result' => null];
        }

        $obj = User::getOne($userName);

        if (!$obj) {
            RETURN404;
        }

        if ($request->input('change_password')) {
            $request->merge([
                'password' => Hash::make($request['password']),
                'change_password_at' => Carbon::now()
            ]);
        }

        $res = $obj->update($request->all());
        if (!$res) {
            return RETURN_SOMETHING_WENT_WRONG;
        }

        $res = User::getOne($userName, true);
        return returnSuccess($res);
    }

    public function destroy($userName)
    {
        if (!Auth::user() || Auth::user()->role > ROLE_ADMIN) {
            return ['status' => false, 'result' => null];
        }

        $obj = User::getOne($userName, true);
        if ($obj) {
            $obj->delete();
        }

        return ['status' => true, 'message' => 'Xóa thành công'];
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
