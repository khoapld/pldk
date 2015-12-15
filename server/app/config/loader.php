<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(array(
    'Api' => APP_PATH . '/core/',
    'Api\Controllers' => APP_PATH . '/controllers/',
    'Api\Models' => APP_PATH . '/models/',
    'Api\Validations' => APP_PATH . '/validations/',
    'Api\Validators' => APP_PATH . '/validators/',
    'Api\Middleware' => APP_PATH . '/middleware/',
    'Api\Http' => APP_PATH . '/http/',
    'Api\Library' => APP_PATH . '/library/',
    'Api\Exceptions' => APP_PATH . '/exceptions/',
));

$loader->register();
