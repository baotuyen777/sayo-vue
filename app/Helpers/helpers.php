<?php

function moneyFormat($number): string
{
    if ($number < 1000000) {
        return number_format($number, 0, ',', '.') . ' đ';
    }

    $millions = round($number / 1000000, 2);
    $billions = round($number / 1000000000, 2);

    $result = '';

    if ($billions > 0.5) {

        if ($millions > 0) {
            $result .= $billions . ' tỷ';
        }

    } else {
        if ($millions > 0) {
            $result .= $millions . ' triệu';
        }
    }

    return $result;
}

function getCatUrl($code): string
{
    return env('APP_URL') . '/cat/' . $code;
}

function getProductUrl($post): string
{
    return env('APP_URL') . "/mua-ban-{$post['category']['code']}/" . $post["code"].'.htm';
}
