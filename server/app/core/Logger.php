<?php

/**
 * Logger for API.
 *
 * @package Api
 */

namespace Api;

class Logger
{

    /**
     * Emergency
     */
    public static function emergency()
    {
        $args = func_get_args();
        self::log($args, 'emergency');
    }

    /**
     * Alert
     */
    public static function alert()
    {
        $args = func_get_args();
        self::log($args, 'alert');
    }

    /**
     * Error
     */
    public static function error()
    {
        $args = func_get_args();
        self::log($args, 'error');
    }

    /**
     * Warning
     */
    public static function warning()
    {
        $args = func_get_args();
        self::log($args, 'warning');
    }

    /**
     * Notice
     */
    public static function notice()
    {
        $args = func_get_args();
        self::log($args, 'notice');
    }

    /**
     * Info
     */
    public static function info()
    {
        $args = func_get_args();
        self::log($args, 'info');
    }

    /**
     * Debug
     */
    public static function debug()
    {
        $args = func_get_args();
        self::log($args, 'debug');
    }

    /**
     * Output log
     *
     * @param array   $args      Arguments
     * @param integer $log_level Log level
     */
    protected static function log($args, $log_level)
    {
        if (count($args) == 1) {
            $arg = array_shift($args);
            $message = self::convertPlainText($arg);
        } else {
            $message = array_shift($args);
            foreach ($args as &$arg) {
                $arg = self::convertPlainText($arg);
            }
            $message = vsprintf($message, $args);
        }

        $caller_info = self::getCallerInfo();
        $message = sprintf(
            '(%d) : %s @ %s : %s:%d', getmypid(), $message, $caller_info['function'], $caller_info['file'], $caller_info['line']
        );

        $di = \Phalcon\DI::getDefault();
        $di->getShared('logger')->$log_level($message);
    }

    /**
     * Get caller information.
     *
     * @param integer $depth Depth for trace
     * @return array Caller information
     */
    protected static function getCallerInfo($depth = 2)
    {
        $caller_info = array_slice(debug_backtrace(), $depth, 2);
        return array(
            'file' => $caller_info[0]['file'],
            'line' => $caller_info[0]['line'],
            'class' => isset($caller_info[1]['class']) ? $caller_info[1]['class'] : '',
            'function' => isset($caller_info[1]['class']) ? $caller_info[1]['class'] . '::' . $caller_info[1]['function'] :
                isset($caller_info[1]['function']) ? $caller_info[1]['function'] : '',
        );
    }

    /**
     * ログ出力に渡された引数をプレーンテキストに変換する
     *
     * @param mixed $arg Arguments
     * @return string Plain text
     */
    protected static function convertPlainText($arg)
    {
        if (is_array($arg) || is_object($arg)) {
            $arg = print_r($arg, true);
        }
        return $arg;
    }

}
