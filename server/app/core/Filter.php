<?php

/**
 * Filter class for API.
 *
 * @package Api
 */

namespace Api;

class Filter extends \Phalcon\Filter
{

    /**
     * Sanitize value with filter.
     *
     * @param string $value  Filter value
     * @param string $filter Filter name
     * @return mixed Filtered value
     */
    protected function _sanitize($value, $filter)
    {
        if (isset($this->_filters[$filter])) {
            $filter_object = $this->_filters[$filter];
            if ($filter_object instanceof Closure) {
                return call_user_func($filter_object, $value);
            }

            return $filter_object->filter($value);
        }

        if ($filter === 'int') {
            return intval($value);
        } else if ($filter === 'string') {
            return strval($value);
        } else if ($filter === 'float') {
            return floatval($value);
        } else if ($filter === 'alphanum') {
            return preg_replace('/[^a-zA-Z0-9]/', '', $value);
        } else if ($filter === 'trim') {
            return trim($value);
        } else if ($filter === 'lower') {
            return strtolower($value);
        } else if ($filter === 'upper') {
            return strtoupper($value);
        }

        throw new \Phalcon\Filter\Exception('Sanitize filter ' . $filter . ' is not supported');
    }

}
