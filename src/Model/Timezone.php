<?php

namespace Timezones\Model;

use Harp\Harp;
use JsonSerializable;

class Timezone extends Harp\AbstractModel implements JsonSerializable
{
    public static function initialize($config)
    {
        $config
            ->setTable('timezone')
            ->addRel(new Harp\Rel\BelongsTo('user', $config, User::getRepo(), array(
                'foreignKey' => 'userId',
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
    public $userId;

    /**
     * @var string
     */
    public $city;

    /**
     * @var integer
     */
    public $utcOffset;

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user' => $this->userId,
            'city' => $this->city,
            'utcOffset' => $this->utcOffset,
        ];
    }
}
