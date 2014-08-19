<?php

use Timezones\Application;
use Timezones\Controller\HomepageController;

$app['homepage.controller'] = $app->share(function(Silex\Application $app) {
    return new HomepageController();
});

$app->get('/', 'homepage.controller:show')
    ->bind('homepage');
