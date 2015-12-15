<?php

/**
 * Base class for exceptions.
 *
 * @package Api
 * @subpackage Exceptions
 */

namespace Api\Exceptions;

class ExceptionBase extends \Exception
{

    /**
     * @var integer Error code
     */
    protected $error_code;

    /**
     * @var integer HTTP status code
     */
    protected $http_status_code = 500;

    /**
     * @var string Error message
     */
    protected $message = 'Internal Server Error';

    /**
     * @var string Error detail
     */
    protected $detail = 'Internal Server Error';

    /**
     * @var array List of errors
     */
    protected static $error_list = array();

    /**
     * @var array List of descriptions
     */
    protected static $descriptions = array(
        // 1xx Informational
        100 => 'Continue',
        101 => 'Switching Protocols',
        // 2xx Success
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        // 3xx Redirection
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found', // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        // 4xx Client Error
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        // 5xx Server Error
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded',
    );

    /**
     * Constructor
     *
     * @param integer   $error_code Error code
     * @param array     $options    Options
     * @param Exception $previous   Previous exception
     */
    public function __construct($error_code, $options = null, $previous = null)
    {
        if (empty($options) && array_key_exists($error_code, static::$error_list)) {

            $options = static::$error_list[$error_code];
            if (!isset($options['message']) && isset(self::$descriptions[$options['http_status_code']])) {
                $options['message'] = self::$descriptions[$options['http_status_code']];
            }
        }

        $this->error_code = $error_code;
        if (is_array($options)) {
            if (isset($options['http_status_code'])) {
                $this->http_status_code = $options['http_status_code'];
            }

            if (isset($options['message'])) {
                $this->message = $options['message'];
            }

            if (isset($options['detail'])) {
                $this->detail = $options['detail'];
            }
        }

        parent::__construct($this->message, $this->http_status_code, $previous);
    }

    /**
     * Get response data.
     *
     * @return array Response data
     */
    public function getResponse()
    {
        return array(
            'error_code' => $this->error_code,
            'http_status_code' => $this->http_status_code,
            'message' => $this->message,
            'detail' => $this->detail,
        );
    }

}
