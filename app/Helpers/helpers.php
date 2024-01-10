<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

function vn2str($str)
{
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );

    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }

    return $str;
}

function vn2code($str)
{
    $str = vn2str($str);
    $str = str_replace(['-', ',', '.', '/', ':'], '', $str);
    $str = str_replace([' '], '-', $str);
    $str = str_replace(['--'], '-', $str);
    return strtolower($str);
}

function vn2Province($str)
{
    $str = vn2code($str);
    $str = str_replace(['tinh-', 'thanh-pho-'], '', $str);
    return $str;
}


function getCategories()
{
    return
        [
            "bds" => 'Bất động sản',
//            "do-dien-tu"=>'Đồ điện tử',
            "do-gia-dung" => 'Đồ gia dụng',
            "dich-vu" => 'Dịch vụ',
//            "me-va-be"=>'Mẹ và bé',
//            "thu-cung"=>'Thú cưng',
//            "do-an"=>'Đồ ăn',
//            "dien-lanh"=>'Điện lạnh',
//            "thoi-trang"=>'Thời trang',
//            "van-phong"=>'Văn phòng',
//            "cho-tang-mien-phi"=>'Cho tặng miễn phí',
            "khac" => 'Khác'
        ];
}

function getCategoryCode($catId): string
{
    $cats = [
        1 => "bds",
        2 => "do-dien-tu",
        3 => "do-gia-dung",
        4 => "dich-vu",
        5 => "me-va-be",
        6 => "thu-cung",
        7 => "do-an",
        8 => "dien-lanh",
        9 => "thoi-trang",
        10 => "van-phong",
        11 => "cho-tang-mien-phi",
        12 => "khac"
    ];
    return $cats[$catId] ?? 'khac';
}

function curlGetContents($url, $onlygetImage = false)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);

//    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
//    echo $contentType;
    curl_close($ch);
    return $data;
}

function isLoged()
{
    return Auth::check();
}

function isValidEmail($value)
{
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

function isValidPhoneNumber($phoneNumber)
{
    $phoneNumber = trim($phoneNumber, " \t\n\r\0\x0B-");
    $pattern = '/^\d{9,10}$/';
    return preg_match($pattern, $phoneNumber) === 1;
}

function isAdmin()
{
    return Auth::user() && Auth::user()->role === ROLE_ADMIN;
}

function isAuthor($obj): bool
{
    if (!$obj || !isLoged()) {
        return false;
    }

    $authorId = $obj->author_id;

    if (Auth::user()->id == $authorId) {
        return true;
    }
    return false;
}

function convertArr2Code($arr)
{
    $items = [];
    foreach ($arr as $k => $v) {
        if (!$v) {
            continue;
        }
        $items[] = "{$k}_{$v}";
    }
    return implode('_', $items);
}

function getFullAddress($obj): string
{
    if (!$obj) {
        return '';
    }
    $arr = [$obj['address'], $obj['ward']['name'] ?? '', $obj['district']['name'] ?? '', $obj['province']['name'] ?? ''];
    return implode(', ', array_filter($arr));
}
