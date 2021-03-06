<?php

/**
 * Exception class for common errors.
 *
 * @package App
 * @subpackage Exception
 */

namespace App\Exception;

class CommonException extends ExceptionBase
{

    /**
     * @var array List of errors.
     */
    protected static $error_list = array(
        ExceptionCode::E_SYSTEM_ERROR => array(
            'http_status_code' => 500,
            'detail' => 'E_SYSTEM_ERROR',
        ),
        ExceptionCode::E_COMMON_NOT_FOUND => array(
            'http_status_code' => 404,
            'detail' => 'Sorry, the resource you requested is not found',
        ),
        ExceptionCode::E_COMMON_METHOD_NOT_ALLOWED => array(
            'http_status_code' => 405,
            'detail' => 'The request method is not allowed',
        ),
    );

}
