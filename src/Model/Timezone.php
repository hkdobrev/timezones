<?php

namespace Timezones\Model;

use Harp\Harp;

class Timezone extends Harp\AbstractModel
{
    public static function initialize($config)
    {
        $config
            ->setTable('timezone')
            ->addRel(new Harp\Rel\BelongsTo('user', $config, User::getRepo()));
    }

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var Timezones\Model\User
     */
    public $user;

    /**
     * @var string
     */
    public $city;

    /**
     * @var integer
     */
    public $utc_offset;
}
