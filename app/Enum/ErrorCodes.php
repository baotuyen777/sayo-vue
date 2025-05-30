<?php

namespace App\Enum;

use Spatie\FlareClient\Http\Exceptions\BadResponseCode;
use Symfony\Component\HttpFoundation\Response;

enum ErrorCodes
{
    // Inspired by https://www.easypost.com/errors-guide

    /*
     * INTERNAL_SERVER_ERROR
     * NOT_ACCEPTABLE
     * NOT_FOUND
     * FORBIDDEN
     * PAYMENT_REQUIRED
     * UNAUTHORIZED
     * BAD_REQUEST
     * PAYMENT_GATEWAY.ERROR
     *
     * MODE.UNAUTHORIZED
     * DATE.PARSE.FAILURE
     *
     * BANK_ACCOUNT.CHARGE.FAILURE
     * BANK_ACCOUNT.VERIFY.FAILURE
     *
     * USER.INVALID
     * USER.PARENT.INVALID
     * USER.CHARGE.NOT_ALLOWED
     */

    public const USER_NO_METER = ['ERROR:BAD_REQUEST', Response::HTTP_BAD_REQUEST];
    public const USER_UNAUTHORIZED = ['USER:UNAUTHORIZED', 401];
    public const USER_FORBIDDEN = ['USER:FORBIDDEN', 403];

    public const ITEM_WEIGHT_TOO_HEAVY = ['ITEM:WEIGHT:TOO_HEAVY', 400];
    public const ITEM_TYPE_PROHIBITED = ['ITEM:TYPE:PROHIBITED', 400];

    public const SHIPMENT_RATE_UNAVAILABLE = ['SHIPMENT:RATE_UNAVAILABLE', 400];
    public const SHIPMENT_ADDRESS_VERIFICATION_FAIL = ['SHIPMENT:ADDRESS_VERIFICATION_FAIL', 400];

    public const METER_INSUFFICIENT_BALANCE = ['METER:INSUFFICIENT_BALANCE', 400];

    public const SYSTEM_NOT_SUPPORTED = ['SYSTEM:NOT_SUPPORTED', 400];

    public const REQUEST_BAD_REQUEST = ['REQUEST:BAD_REQUEST', 400];

    public const REQUEST_VALIDATION_ERROR = ['REQUEST:VALIDATION_ERROR', 422];

    public const SYSTEM_SERVICE_PROVIDER_ERROR = ['SYSTEM:SERVICE_PROVIDER_ERROR', 500];

    public const SYSTEM_ERROR = ['SYSTEM:ERROR', 500];
    public const SYSTEM_UNAVAILABLE = ['SYSTEM:UNAVAILABLE', 503];

    public const USPS_UNAVAILABLE = ['USPS:UNAVAILABLE', 503];

    public const PDX_ERROR = ['PDX:ERROR', 500];
    public const METHOD_NOT_ALLOWED = ['Method Not Allowed', 405];
    public const NOT_FOUND = ['Not Found', 404, 0, true];
    public const BAD_REQUEST = ['Bad Request', 400, 0, true];

    /*

        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested range unsatisfiable',
        417 => 'Expectation failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable entity',
        423 => 'Locked',
        424 => 'Method failure',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        451 => 'Unavailable For Legal Reasons',

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway or Proxy Error',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        507 => 'Insufficient storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

     */
}
