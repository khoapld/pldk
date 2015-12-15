<?php

/**
 * Exception handler class.
 *
 * @package Api
 * @subpackage Exceptions
 */

namespace Api\Exceptions;

use Phalcon\Http\Response;
use Api\Logger;

class ExceptionHandler
{

    /**
     * Send error response.
     *
     * @param Exception $exception Exception
     * @return void
     */
    public function send($exception)
    {
        if (method_exists($exception, 'getResponse')) {
            $res = $exception->getResponse();
        } else {
            $res = array(
                'error_code' => 99999,
                'http_status_code' => 500,
                'message' => 'Internal Server Error',
                'detail' => $exception->getMessage(),
            );
            Logger::error('%d - %s', $res['error_code'], $res['detail']);
        }

        $error = array(
            'Error' => array(
                'Code' => $res['error_code'],
                'Message' => $res['message'],
                'Detail' => $res['detail'],
            ),
        );

        $response = new Response();
        $response->setStatusCode($res['http_status_code'], $res['message']);
        $response->setContentType('application/json');
        $response->setJsonContent($error);
        $response->send();
    }

}
