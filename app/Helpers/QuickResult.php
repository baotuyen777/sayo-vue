<?php

const RETURN404 = [
    'status' => false,
    'err_code' => ERR_404,
    'message' => ERR_404 . ' Dữ liệu không tồn tại'
];

const RETURN_SOMETHING_WENT_WRONG = [
    'status' => false,
    'message' => 'Có lỗi xảy ra'
];

const RETURN_REQUIRED_ADMIN = [
    'status' => false,
    'err_code' => ERR_REQUIRED_ADMIN,
    'message' => ERR_REQUIRED_ADMIN . ' Bạn cần có quyền admin'
];

function returnSuccess($res)
{
    return ['status' => true, 'result' => $res];
}
