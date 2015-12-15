<?php

return array(
    'handler' => 'Api\Controllers\UserController',
    'lazy' => true,
    'prefix' => '/v1/user',
    'route' => array(
        array('/', 'GET', 'read'),
        array('/', 'POST', 'create'),
        array('/edit', 'POST', 'update'),
        array('/delete', 'DELETE', 'delete'),
    ),
);
