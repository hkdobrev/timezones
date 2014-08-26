<?php

namespace Timezones\Model;

use Harp\Harp;

class User extends Harp\AbstractModel
{
    public static function initialize($config)
    {
        $config
            ->setTable('oauth_users')
            ->setNameKey('username')
            ->addRel(new Harp\Rel\HasMany('timezones', $config, Timezone::getRepo(), array(
                'foreignKey' => 'user_id',
            )));
    }

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $scope;
}
