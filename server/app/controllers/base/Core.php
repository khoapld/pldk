<?php

/**
 * Base class for controllers.
 *
 * @package App
 * @subpackage Controller
 */

namespace App\Controller\Base;

abstract class Core extends \Phalcon\Mvc\Controller
{

    protected $response = [
        'code' => 200,
        'message' => '',
        'data' => [],
        'error' => []
    ];

    public function resp($msg = null, $code = null, $data = [])
    {
        if (!empty($code)) {
            $this->response['code'] = $code;
        }
        if (!empty($msg)) {
            $this->response['message'] = $msg;
        }
        if ($this->response['code'] == 200) {
            $this->response['data'] = $data;
        } else {
            $this->response['error'] = $data;
        }
    }

}
