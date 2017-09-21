<?php

/**
 * HTTP Request class.
 *
 * @package App
 * @subpackage Http
 */

namespace App\Http;

use Phalcon\Http\Request\Exception as HttpRequestException;

class Request extends \Phalcon\Http\Request implements \Phalcon\Http\RequestInterface
{

    /**
     * Get query paramter.
     *
     * @param string $name    Parameter name
     * @param mixed  $filters Filter name
     * @param mixed  $default Default value
     * @return mixed parameter
     */
    public function getQuery($name = null, $filters = null, $default = null)
    {
        $value = null;
        if ($name !== null) {
            $value = $_GET[$name];
            if ($value === false) {
                return $default;
            }

            if ($filters !== null) {
                $filter = $this->_filter;
                if (!is_object($filter)) {
                    $di = $this->_dependencyInjector;
                    if (!is_object($di)) {
                        throw new HttpRequestException('A dependency injection object is required');
                    }

                    $filter = $di->getShared('filter');
                    if (!is_object($filter)) {
                        throw new HttpRequestException('A dependency injection object is required to access the \'filter\' service');
                    }

                    $this->_filter = $filter;
                }

                $value = $filter->sanitize($value, $filters);
            }
        }
        return $value;
    }

    /**
     * Get post parameter.
     *
     * @param string $name    Parameter name
     * @param mixed  $filters Filter name
     * @param mixed  $default Default value
     * @return mixed parameter
     */
    public function getPost($name = null, $filters = null, $default = null)
    {
        $value = null;
        if ($name !== null) {
            $value = $_POST[$name];
            if ($value === false) {
                return $default;
            }

            if ($filters !== null) {
                $filter = $this->_filter;
                if (!is_object($filter)) {
                    $di = $this->_dependencyInjector;
                    if (!is_object($di)) {
                        throw new HttpRequestException('A dependency injection object is required');
                    }

                    $filter = $di->getShared('filter');
                    if (!is_object($filter)) {
                        throw new HttpRequestException('A dependency injection object is required to access the \'filter\' service');
                    }

                    $this->_filter = $filter;
                }

                $value = $filter->sanitize($value, $filters);
            }
        }
        return $value;
    }

    /**
     * Get request body(JSON).
     *
     * @param string $name    Parameter name
     * @param mixed  $filters Filter name
     * @param mixed  $default Default value
     * @return mixed parameter
     */
    public function getJson($name = null, $filters = null, $default = null)
    {
        $di = $this->_dependencyInjector;
        if (!is_object($di)) {
            throw new HttpRequestException('A dependency injection object is required');
        }

        $body = $di->getShared('requestBody');
        if ($name !== null) {
            if (!isset($body[$name])) {
                return $default;
            }

            $value = $body[$name];
            if ($filters !== null) {
                $filter = $this->_filter;
                if (!is_object($filter)) {
                    $filter = $di->getShared('filter');
                    if (!is_object($filter)) {
                        throw new HttpRequestException('A dependency injection object is required to access the \'filter\' service');
                    }

                    $this->_filter = $filter;
                }

                $value = $filter->sanitize($value, $filters);
            }
            return $value;
        }
        return $body;
    }

}
