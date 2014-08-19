<?php

namespace Timezones\Model;

use Harp\Harp\AbstractModel;

class Timezone extends AbstractModel
{
    public static function initialize($config)
    {

    }

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;
}
