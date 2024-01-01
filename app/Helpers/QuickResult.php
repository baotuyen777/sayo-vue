<?php

const RETURN404 = [
    'status' => false,
    'err_code' => ERR_404,
    'message' => ERR_404 . ' Dữ liệu không tồn tại'
];
const RETURN412 = [
    'status' => false,
    'err_code' => ERR_412,
    'message' => ERR_412 . ' Lỗi logic'
];

const RETURN_SOMETHING_WENT_WRONG = [
    'status' => false,
    'err_code' => ERR_500,
    'message' => 'Có lỗi xảy ra! vui lòng liên hệ với admin'
];

const RETURN_REQUIRED_ADMIN = [
    'status' => false,
    'err_code' => ERR_REQUIRED_ADMIN,
    'message' => ERR_REQUIRED_ADMIN . ' Bạn cần có quyền admin'
];

const RETURN_REQUIRED_AUTHOR = [
    'status' => false,
    'err_code' => ERR_REQUIRED_AUTHOR,
    'message' => ERR_REQUIRED_AUTHOR . ' Yêu cầu quyền tác giả '
];

function returnSuccess($result = '', $redirectUrl = '', $notify = ' '): array
{
    $res = ['status' => true, 'result' => $result];

    if ($redirectUrl) {
        $res['redirectUrl'] = $redirectUrl;
    }
    return $res;
}

function returnErr($message = '', $redirectUrl = '',): array
{
    $res = ['status' => false, 'message' => ERR_412 . ' ' . $message, 'err_code' => ERR_412,];

    if ($redirectUrl) {
        $res['redirectUrl'] = $redirectUrl;
    }
    return $res;
}
