<?php

use Carbon\Carbon;

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
    return env('APP_URL') . "/mua-ban-{$post['category']['code']}/" . $post["code"] . '.htm';
}

function editProductUrl($post): string
{
    return env('APP_URL') . "/post/edit/" . $post["code"] . '.htm';
}

function getPageUrl($code): string
{
    return env('APP_URL') . "/page/{$code}" . '.htm';
}

function showHumanTime($actionTime)
{
    $actionTime = Carbon::parse($actionTime);
    $currentDateTime = Carbon::now();

    $timeDifference = $currentDateTime->diff($actionTime);
    $days = $timeDifference->d;
    $hours = $timeDifference->h;
    $minutes = $timeDifference->i;

    $timeString = '';

    if ($days > 0) {
        $timeString .= $days . ' Ngày ';
    } else if ($hours > 0) {
        $timeString .= $hours . ' Giờ ';
    } else if ($minutes > 0) {
        $timeString .= $minutes . ' Phút ';
    }

    $timeString .= ' trước';

    return $timeString;
}

function getProductAttr()
{

}
