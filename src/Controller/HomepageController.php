<?php

namespace Timezones\Controller;

use Timezones\Model\Timezone;

class HomepageController
{
    public function show(\Silex\Application $app)
    {
        $timezone = new Timezone();
        $timezone->name = 'Awesome timezone';

        return $app->render('homepage.html.twig', array(
            'timezone' => $timezone,
        ));
    }
}
