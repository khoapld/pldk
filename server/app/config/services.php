<?php

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\Events\Manager as ManagerEvents;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Logger\Formatter\Line as LineFormatter;
use Phalcon\Mvc\Collection\Manager as ManagerCollection;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use App\Http\Request;
use App\Filter;

$settings = require 'config.php';

// Load config files.
$config = new Config($settings);

// Environment
$env = get_cfg_var('API_ENV');
if (empty($env)) {
    $env = 'dev';
}

// Dependency Injection.
$di = new FactoryDefault();

// Set up the database service
$di->set('db', function () use ($config, $env) {
    $eventsManager = new ManagerEvents();
    $logger = new FileAdapter(APP_PATH . '/../log/debug.log');

    // Listen all the database events
    $eventsManager->attach('db', function ($event, $connection) use ($logger) {
        if ($event->getType() == 'beforeQuery') {
            $logger->log($connection->getSQLStatement(), Logger::INFO);
        }
    });

    $connection = new PdoMysql((array) $config->$env);
    // Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

    return $connection;
});

// Request Body
$di['requestBody'] = function() {
    $body = file_get_contents('php://input');
    $body = json_decode($body, true);
    return $body;
};

// Request
$di['request'] = function() {
    return new Request();
};

// Filter
$di['filter'] = function() {
    return new Filter();
};

// Logger
$di['logger'] = function() {
    $log_path = get_cfg_var('API_LOG_DIR');
    if (empty($log_path)) {
        $log_path = APP_PATH . '/../log';
    }

    $log_file = get_cfg_var('API_LOG_FILE');
    if (empty($log_file)) {
        $log_file = 'api.log';
    }

    $log_level = get_cfg_var('API_LOG_LEVEL');
    if (empty($log_level)) {
        $log_level = 'ERROR';
    }
    $log_level = constant('\Phalcon\Logger::' . $log_level);

    $logger = new FileAdapter($log_path . '/' . $log_file);
    $logger->setLogLevel($log_level);
    $logger->setFormatter(new LineFormatter());
    return $logger;
};

// collectionManager
$di['collectionManager'] = function() {
    return new ManagerCollection();
};
