<?php

namespace Api\Models;

use Phalcon\Mvc\Model;

class User extends Model
{

    /**
     * Mapping User class with users table
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Init User Model
     *
     * @return void
     */
    public function initialize()
    {

    }

    /**
     *  Initialize object
     *
     */
    public function onConstruct()
    {

    }

    public function beforeCreate()
    {
        // Set the creation date
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        // Set the modification date
        $this->updated_at = date('Y-m-d H:i:s');
    }

    public function getUsers()
    {
        try {
            $phql = "SELECT * FROM Api\Models\User WHERE 1";
            return $this->getModelsManager()->executeQuery($phql)->toArray();
        } catch (Exception $e) {
            return false;
        }
    }

}
