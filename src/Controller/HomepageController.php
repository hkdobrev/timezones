<?php

namespace Timezones\Controller;

use Timezones\Model\Timezone;

class HomepageController
{
    public function show(\Silex\Application $app)
    {
        $timezone = new Timezone();
        $timezone->name = 'Awesome timezone';

        return sprintf('Hello, %s!', $timezone->name);
    }
}
