<?php

error_reporting(E_ALL);

use Phalcon\Mvc\Micro as App,
    Api\Middleware\ResponseMiddleware,
    Api\Exceptions\ExceptionHandler,
    Api\Exceptions\ExceptionCode,
    Api\Exceptions\CommonException;

define('APP_PATH', realpath('../app'));

require APP_PATH . '/config/loader.php';
require APP_PATH . '/config/services.php';

try {
    $app = new App();
    $app->setDI($di);

    require APP_PATH . '/handler.php';

    $app->before(function () use ($app) {

    });
    $app->after(new ResponseMiddleware());
    $app->notFound(function () use ($app) {
        throw new CommonException(ExceptionCode::E_COMMON_NOT_FOUND);
    });
    $app->handle();
} catch (Exception $e) {
    $handler = new ExceptionHandler();
    $handler->send($e);
}
