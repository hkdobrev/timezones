<?php

namespace Timezones\Controller;

use Timezones\Model\Timezone;

class HomepageController
{
    public function show(\Silex\Application $app)
    {
        $timezone = Timezone::find(1);

        return sprintf('Hello, %s!', $timezone->name);
    }
}
