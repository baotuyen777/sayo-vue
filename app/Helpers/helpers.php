<?php

function moneyFormat($number)
{

    if ($number < 1000000) {
        return number_format($number, 0, ',', '.').' đ';
    }

    $millions = (($number / 1000000));
    $billions = intval($number / 1000000000);

    $result = '';

    if ($billions > 0.5) {
        if ($millions > 0) {
            $result .= $billions + $millions / 1000 . ' tỷ';
        } else {
            $result .= $billions . ' tỷ';
        }

    }else{
        if ($millions > 0) {
            $result .= $millions . ' triệu';
        }
    }

    return $result;

}
