<?php

namespace Timezones\Model;

use Harp\Harp;

class Timezone extends Harp\AbstractModel
{
    public static function initialize($config)
    {
        $config
            ->setTable('timezone')
            ->addRel(new Harp\Rel\BelongsTo('user', $config, User::getRepo(), array(
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
    public $name;

    /**
     * @var integer
     */
    public $user_id;

    /**
     * @var string
     */
    public $city;

    /**
     * @var integer
     */
    public $utc_offset;
}
