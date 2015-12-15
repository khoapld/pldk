<?php

/**
 * Controller for user.
 *
 * @package Api
 * @subpackage Controllers
 */

namespace Api\Controllers;

use Api\Logger;
use Api\Exceptions\ExceptionCode;
use Api\Exceptions\ExceptionBase;
use Api\Models\User;

//use Api\Validations\UserValidation;

class UserController extends ControllerBase
{

    /**
     * Get /v1/user/
     *
     * @return array Response data.
     */
    public function read()
    {
        $userModel = new User();
        $users = $userModel->getUsers();

        // Send response.
        return array(
            'ResultSet' => array(
                '@totalResultsAvailable' => 1,
                '@totalResultsReturned' => 1,
                '@firstResultPosition' => 1,
                'Result' => 1
            )
        );
    }

    /**
     * Post /v1/user
     *
     * @return array Response data.
     */
    public function create()
    {
        $data = array();

        return $data;
    }

}
