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
            )))

            // Hash passwords before inserting into the database
            ->addEventBefore(Harp\Repo\Event::INSERT, function($user) {
                $user->password = password_hash(
                    $user->password,
                    PASSWORD_DEFAULT
                );
            });
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
