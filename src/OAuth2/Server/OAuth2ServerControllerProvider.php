<?php

namespace Timezones\OAuth2\Server;

use Silex\Application;
use Silex\ControllerProviderInterface;
use OAuth2\HttpFoundationBridge\Response as BridgeResponse;
use OAuth2\Server as OAuth2Server;
use Timezones\OAuth2\Storage\Pdo;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\UserCredentials;
use OAuth2\GrantType\RefreshToken;

class OAuth2ServerControllerProvider implements ControllerProviderInterface
{
    /**
     * function to create the OAuth2 Server Object
     */
    public function setup(Application $app)
    {
        // create PDO-based sqlite storage
        $storage = new Pdo($app['db']);

        // create array of supported grant types
        $grantTypes = array(
            'authorization_code' => new AuthorizationCode($storage),
            'user_credentials'   => new UserCredentials($storage),
            'refresh_token'   => new RefreshToken($storage, array(
                'always_issue_new_refresh_token' => true,
            )),
        );

        // instantiate the oauth server
        $server = new OAuth2Server($storage, array('enforce_state' => true, 'allow_implicit' => true), $grantTypes);

        // add the server to the silex "container" so we can use it in our controllers (see src/OAuth/Controller/.*)
        $app['oauth_server'] = $server;

        /**
         * add HttpFoundataionBridge Response to the container, which returns a silex-compatible response object
         * @link https://github.com/bshaffer/oauth2-server-httpfoundation-bridge
         */
        $app['oauth_response'] = new BridgeResponse();
    }

    /**
     * Connect the controller classes to the routes
     */
    public function connect(Application $app)
    {
        // create the oauth2 server object
        $this->setup($app);

        // creates a new controller based on the default route
        $routing = $app['controllers_factory'];

        /* Set corresponding endpoints on the controller classes */
        Controller\TokenController::addRoutes($routing);
        Controller\ResourceController::addRoutes($routing);

        return $routing;
    }
}
