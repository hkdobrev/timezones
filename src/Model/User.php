<?php

namespace Timezones\Model;

use JsonSerializable;
use Harp\Harp;
use Harp\Validate\Asserts;
use Harp\Validate\Assert\Callback;
use Harp\Validate\Assert\Present;

class User extends Harp\AbstractModel implements JsonSerializable
{
    public static function initialize($config)
    {
        $config
            ->setTable('oauth_users')
            ->setNameKey('username')
            ->addRel(new Harp\Rel\HasMany('timezones', $config, Timezone::getRepo(), array(
                'foreignKey' => 'userId',
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
                return 0 === User::findAll()
                    ->where('username', $username)
                    ->whereNot('id', $user->id)
                    ->limit(1)
                    ->load()
                    ->count();
            }),
            new Present('username'),
            new Present('password'),
        ]);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
    }
}
