<?php

/**
 * Lists for exeception codes.
 *
 * @package Api
 * @subpackage Exceptions
 */

namespace Api\Exceptions;

class ExceptionCode
{
    # 90000: Common error
    const E_COMMON_NOT_FOUND = 90001;
    const E_COMMON_METHOD_NOT_ALLOWED = 90002;

    # 40000: Validation error
    const E_VALIDATION_ERROR_URL = 40001;

}
