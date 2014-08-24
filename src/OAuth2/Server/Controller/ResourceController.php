<?php

namespace Timezones\OAuth2\Server\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class ResourceController
{
    // Connects the routes in Silex
    static public function addRoutes($routing)
    {
        $routing->get('/timezones', array(new self(), 'timezones'))->bind('timezones');
    }

    /**
     * This is called by the client app once the client has obtained an access
     * token for the current user.  If the token is valid, the resource (in this
     * case, the "friends" of the current user) will be returned to the client
     */
    public function timezones(Application $app)
    {
        // get the oauth server (configured in src/OAuth2Demo/Server/Server.php)
        $server = $app['oauth_server'];

        // get the oauth response (configured in src/OAuth2Demo/Server/Server.php)
        $response = $app['oauth_response'];

        if (!$server->verifyResourceRequest($app['request'], $response, 'timezones')) {
            return $server->getResponse();
        } else {
            // return a fake API response - not that exciting
            // @TODO return something more valuable, like the name of the logged in user
            $api_response = array(
                'timezones' => array(
                    'GMT',
                    'UTC',
                    'EEST'
                )
            );
            return new Response(json_encode($api_response));
        }
    }
}
