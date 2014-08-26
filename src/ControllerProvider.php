<?php

namespace Timezones;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\Provider\SessionServiceProvider;
use GuzzleHttp\Client as GuzzleClient;

class ControllerProvider implements ControllerProviderInterface
{
    /**
     * Connect the controller classes to the routes
     */
    public function connect(Application $app)
    {
        // create session object and start it
        $app->register(new SessionServiceProvider());

        if (!$app['session']->isStarted()) {
            $app['session']->start();
        }

        // create http client
        $app['http_client'] = new GuzzleClient();

        // Load routes from the controller classes
        $routing = $app['controllers_factory'];

        Controller\TimezonesController::addRoutes($routing);
        Controller\SignupController::addRoutes($routing);

        return $routing;
    }

}
