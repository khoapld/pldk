<?php

namespace App\Model;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class User extends Model
{
    /**
     * Mapping User class with users table
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_employee';
    }

    /**
     * Init User Model
     *
     * @return void
     */
    public function initialize()
    {
        $this->setSource('m_employee');
        $this->addBehavior(new Timestampable(array(
            'beforeValidationOnCreate' => array(
                'field' => array(
                    'create_time',
                    'update_time'
                ),
                'format' => 'Y-m-d H:i:s'
            ),
            'beforeValidationOnUpdate' => array(
                'field' => 'update_time',
                'format' => 'Y-m-d H:i:s'
            )
            // beforeCreate | beforeUpdate
        )));
        $this->addBehavior(
            new SoftDelete(array(
            'field' => 'del_flg',
            'value' => 1,
        )));
    }

    /**
     * Initialize object
     *
     */
    public function onConstruct()
    {

    }

    public function beforeCreate()
    {
        // Set the creation date
        // $this->created_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        // Set the modification date
        // $this->update_time = date('Y-m-d H:i:s');
    }

    public function getId()
    {
        return $this->id;
    }

}
