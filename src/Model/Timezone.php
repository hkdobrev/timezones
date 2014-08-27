<?php

namespace Timezones\Model;

use Harp\Harp;
use JsonSerializable;
use Harp\Validate\Asserts;
use Harp\Validate\Assert\Present;

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

    public function getValidationAsserts()
    {
        $timezone = $this;
        return new Asserts([
            new Present('name'),
            new Present('userId'),
            new Present('city'),
            new Present('utcOffset'),
        ]);
    }
}
