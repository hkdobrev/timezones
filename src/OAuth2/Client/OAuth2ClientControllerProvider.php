<?php

namespace Timezones\OAuth2\Client;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\Provider\SessionServiceProvider;
use GuzzleHttp\Client as GuzzleClient;

class OAuth2ClientControllerProvider implements ControllerProviderInterface
{
    /**
     * function to set up the container for the Client app
     */
    public function setup(Application $app)
    {
        // create session object and start it
        $app->register(new SessionServiceProvider());

        if (!$app['session']->isStarted()) {
            $app['session']->start();
        }

        // create http client
        $app['http_client'] = new GuzzleClient();
    }

    /**
     * Connect the controller classes to the routes
     */
    public function connect(Application $app)
    {
        // set up the service container
        $this->setup($app);

        // Load routes from the controller classes
        $routing = $app['controllers_factory'];

        Controller\RequestTokenController::addRoutes($routing);
        Controller\RequestResourceController::addRoutes($routing);

        return $routing;
    }
}
