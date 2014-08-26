<?php

namespace Timezones\Model;

use Harp\Harp;
use Harp\Validate\Asserts;
use Harp\Validate\Assert\Callback;

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

    public function getValidationAsserts()
    {
        $user = $this;
        return new Asserts([
            new Callback('username', function($username) use ($user) {
                return User::findAll()
                    ->where('username', $username)
                    ->whereNot('id', $user->id)
                    ->limit(1)
                    ->load()
                    ->count() === 0;
            }),
        ]);
    }
}
