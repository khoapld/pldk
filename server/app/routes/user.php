<?php

return array(
    'handler' => 'App\Controller\UserController',
    'lazy' => true,
    'prefix' => '/v1/user',
    'route' => array(
        array('/', 'GET', 'read'),
        array('/', 'POST', 'create'),
        array('/edit', 'POST', 'update'),
        array('/delete', 'DELETE', 'delete'),
    ),
);
