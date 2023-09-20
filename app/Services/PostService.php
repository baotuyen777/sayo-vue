<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\Posts;

class PostService
{
    function getAttrField($post=false, $filterNull= false)
    {
        $config = Posts::$attr;

        $attrs = json_decode(str_replace('%22', '', $post->attr));
        $res = [];
        foreach ($config as $k => $item) {
            if (isset($attrs->$k)) {
                $rawValue = $attrs->$k;
                $item['value'] = $rawValue;
                $item['valueLabel'] = $item['options'][$rawValue] ?? $rawValue;
                if (isset($item['type'])) {
                    if ($item['type'] == 'boolean') {
                        $item['valueLabel'] = $rawValue ? 'Có' : 'Không';
                    }
                    if ($item['type'] == 'money') {
                        $item['valueLabel'] = moneyFormat($rawValue);
                    }
                    if ($item['type'] == 's') {
                        $item['valueLabel'] = $rawValue . 'm2';
                    }
                }
            }else if ($filterNull) {
                continue;
            }

            $res[$k] = $item;
        }

        return $res;
    }

    public function getAttrOptions($post = null)
    {
        $categories = Category::with('avatar')->get();
//        $address = [
//            ['id' => 1, 'name' => 'Phường Thanh Xuân Bắc, Quận Thanh Xuân, Hà Nội'],
//            ['id' => 2, 'name' => 'Phường Thanh Xuân Trung, Quận Thanh Xuân, Hà Nội'],
//        ];
//        $provinces = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 1)->get();
//        $districts = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 2)->get();
//        $wards = DB::table('pdws')->select('id as value', 'name as label')->where('level', '=', 3)->get();
        $provinces = Province::get()->keyBy('id');
        $districts = $post ? District::whereProvinceId($post->province_id)->get()->keyBy('id') : [];
        $wards = $post ? Ward::whereDistrictId($post->district_id)->get()->keyBy('id') : [];

//        $postStates = Posts::$states;
//
//        $brands = ['Samsung', 'Apple'];
//        $colors = ['Bạc', 'Đen', 'Đỏ', 'Hồng', 'Trắng', 'Vàng', 'Xám', 'Xanh dương', 'Xanh lá', 'Màu khác'];
//        $storages = ['<8G', '8G', '16G', '32G', '64G', '128G', '256G', '>256G'];
//        $madeIns = ['Việt Nam', 'Trung Quốc', 'Châu Âu', 'Mỹ', 'Nhật', 'Thái Lan', 'Hàn Quốc', 'Khác'];


        return get_defined_vars();
    }

}
