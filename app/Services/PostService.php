<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\Posts;
class PostService
{
    function getAttrField($post)
    {
        $config = Posts::$attr;

        $attrs = json_decode($post->attr);
        foreach ($attrs as $k => $v) {
            $item = $config[$k];

            $item['value'] = $item['options'][$v] ?? $v;
            if (isset($item['type']) ) {
                if( $item['type'] == 'boolean'){
                    $item['value'] = $v ? 'Có' : 'Không';
                }
                if( $item['type'] == 'money'){
                    $item['value'] = moneyFormat($v);
                }
                if( $item['type'] == 's'){
                    $item['value'] = $v.' m2';
                }
            }

            $attrs->$k = $item;
        }

        return $attrs;
    }

    public function getAttrOptions()
    {
        $categories = Category::with('avatar')->get();
        $address = [
            ['id' => 1, 'name' => 'Phường Thanh Xuân Bắc, Quận Thanh Xuân, Hà Nội'],
            ['id' => 2, 'name' => 'Phường Thanh Xuân Trung, Quận Thanh Xuân, Hà Nội'],
        ];
//        $provinces = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 1)->get();
//        $districts = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 2)->get();
//        $wards = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 3)->get();
        $provinces = Province::get();
        $districts = District::whereProvinceId(50)->get();
        $wards = Ward::whereDistrictId(552)->get();

        $postStates = Posts::$states;

        $brands = ['Samsung', 'Apple'];
        $colors = ['Bạc', 'Đen', 'Đỏ', 'Hồng', 'Trắng', 'Vàng', 'Xám', 'Xanh dương', 'Xanh lá', 'Màu khác'];
        $storages = ['<8G', '8G', '16G', '32G', '64G', '128G', '256G', '>256G'];
        $madeIns = ['Việt Nam', 'Trung Quốc', 'Châu Âu', 'Mỹ', 'Nhật', 'Thái Lan', 'Hàn Quốc', 'Khác'];


        return get_defined_vars();
    }

}
