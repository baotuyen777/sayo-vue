<?php

namespace App\Services\Post;

use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\User;

class UserService
{
    public function getAttrOptions($post = null)
    {
        $provinces = Province::get()->keyBy('id');
        $districts = $post ? District::whereProvinceId($post->province_id)->get()->keyBy('id') : [];
        $wards = $post ? Ward::whereDistrictId($post->district_id)->get()->keyBy('id') : [];
        $genders = User::$gender;
        return get_defined_vars();
    }



}
