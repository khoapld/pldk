<?php

namespace App\Middleware;

use Phalcon\Mvc\Micro as App,
    Phalcon\Mvc\Micro\MiddlewareInterface,
    Phalcon\Http\ResponseInterface,
    App\Exceptions\ExceptionCode,
    App\Exceptions\CommonException;

class ResponseMiddleware implements MiddlewareInterface
{

    /**
     * Call middleware
     *
     * @param \Phalcon\Mvc\Micro $application
     * @return bool
     */
    public function call(App $application)
    {
        $method = $application->request->getMethod();
        if ($method === 'OPTIONS') {
            $application->response->setStatusCode(200, 'OK');
            $application->response->send();
            return;
        }

        $data = $application->getReturnedValue();
        if (!is_array($data)) {
            if ($data instanceof ResponseInterface) {
                $data->send();
                return;
            }
            throw new CommonException(ExceptionCode::E_COMMON_OPERATION_FAILED);
        }

        if (empty($data)) {
            $application->response->setStatusCode(204, 'No Content');
        } else {
            if ($method !== 'HEAD') {
                $application->response->setContentType('application/json');
                $application->response->setJsonContent($data);
            }
        }

        $application->response->send();
        return true;
    }

}
