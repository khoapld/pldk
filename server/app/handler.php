<?php

use Phalcon\Mvc\Micro\Collection;

$route_files = scandir(APP_PATH . '/routes');

foreach ($route_files as $file) {
    $pathinfo = pathinfo($file);
    if ($pathinfo['extension'] === 'php') {
        $config = include(APP_PATH . '/routes/' . $file);

        $collection = new Collection();
        $collection->setHandler($config['handler']);
        $collection->setLazy($config['lazy']);
        $collection->setPrefix($config['prefix']);

        foreach ($config['route'] as $route) {
            list($uri, $method, $func) = $route;
            $method = strtolower($method);
            $collection->$method($uri, $func);
        }

        $app->mount($collection);
    }
}
