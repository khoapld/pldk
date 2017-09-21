<?php

/**
 * Exception handler class.
 *
 * @package App
 * @subpackage Exception
 */

namespace App\Exception;

use Phalcon\Http\Response;
use App\Logger;

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
                'message' => 'Internal Server Error - ' . $exception->getMessage()
            );
            Logger::error('%d - %s', $res['error_code'], $res['message']);
        }

        $error = array(
            'code' => $res['error_code'],
            'message' => $res['message'],
            'data' => [],
            'error' => [],
        );

        $response = new Response();
        $response->setStatusCode($res['http_status_code'], $res['message']);
        $response->setContentType('application/json');
        $response->setJsonContent($error);
        $response->send();
    }

}
