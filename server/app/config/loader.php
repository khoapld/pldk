<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(array(
    'App' => APP_PATH . '/core/',
    'App\Controller' => APP_PATH . '/controllers/',
    'App\Model' => APP_PATH . '/models/',
    'App\Validation' => APP_PATH . '/validations/',
    'App\Validator' => APP_PATH . '/validators/',
    'App\Middleware' => APP_PATH . '/middleware/',
    'App\Http' => APP_PATH . '/http/',
    'App\Library' => APP_PATH . '/library/',
    'App\Exception' => APP_PATH . '/exceptions/',
));

$loader->register();
