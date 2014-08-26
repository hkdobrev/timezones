<?php

namespace Timezones\Controller;

use Silex\Application;
use OAuth2\HttpFoundationBridge\Response;

class TimezonesController
{
    static public function addRoutes($routing)
    {
        $routing
            ->get('/timezones', array(new self(), 'getTimezones'))
            ->bind('get_timezones');
    }

    public function getTimezones(Application $app)
    {
        $config = $app['oauth'];    // the configuration for the current oauth implementation
        $http   = $app['http_client'];   // service to make HTTP requests to the oauth server

        // pull the token from the request
        $token = $app['request']->get('token');

        // make the resource request with the token in the request body
        $config['resource_params']['access_token'] = $token;

        // determine the resource endpoint to call based on our config (do this somewhere else?)
        $apiRoute = $config['timezones_route'];
        $endpoint = 0 === strpos($apiRoute, 'http')
            ? $apiRoute
            : $app->url($apiRoute, $config['resource_params']);

        // make the resource request and decode the json response
        $internalResponse = $http->get($endpoint, array_merge([
            'query' => [
                'access_token' => $token,
            ],
        ], $config['http_options']));

        $json = json_decode((string) $internalResponse->getBody(), true);

        return new Response($json, $internalResponse->getStatusCode());
    }
}
