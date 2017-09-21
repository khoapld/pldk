<?php

/**
 * Controller for user.
 *
 * @package App
 * @subpackage Controller
 */

namespace App\Controller;

use App\Controller\Base\Core AS ControllerBaseCore;
use App\Model\Base\Core AS ModelBaseCore;
use App\Logger;
use App\Exception\ExceptionBase;
use App\Exception\ExceptionHandler;
use App\Exception\ExceptionCode;
use App\Exception\CommonException;
use Exception;

//use App\Validation\UserValidation;

class UserController extends ControllerBaseCore
{

    public function initialize()
    {

    }

    public function onConstruct()
    {
        $this->modelBaseCore = new ModelBaseCore();
    }

    /**
     * Get /v1/user/
     *
     * @return array Response data.
     */
    public function read()
    {
        ini_set('memory_limit', -1);
        try {
            $users = $this->modelBaseCore->getUsers();

            $this->resp(null, null, $users);
        } catch (Exception $e) {
//            Log::write('ERROR', $e->getMessage(), __CLASS__ . ':' . __FUNCTION__ . ':' . $e->getLine());
            $code = empty($e->getCode()) ? ExceptionCode::E_SYSTEM_ERROR : $e->getCode();
            throw new CommonException($code);
        }

        return $this->response;
    }

    /**
     * Post /v1/user/edit
     *
     * @return array Response data.
     */
    public function update()
    {
        try {
            $this->db->begin();
            $users = $this->modelBaseCore->updateUsers();

            $this->resp(null, null, $users);
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollback();
//            Log::write('ERROR', $e->getMessage(), __CLASS__ . ':' . __FUNCTION__ . ':' . $e->getLine());
            $code = empty($e->getCode()) ? ExceptionCode::E_SYSTEM_ERROR : $e->getCode();
            throw new CommonException($code);
        }

        return $this->response;
    }

}
