<?php

namespace App\Services;

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

}
