<?php

namespace Timezones\OAuth2\Client\Controller;

use Silex\Application;
use OAuth2\HttpFoundationBridge\Response;

class RequestResourceController
{
    static public function addRoutes($routing)
    {
        $routing->get('/client/request_resource', array(new self(), 'requestResource'))->bind('request_resource');
    }

    public function requestResource(Application $app)
    {
        $config = $app['oauth'];    // the configuration for the current oauth implementation
        $urlgen = $app['url_generator']; // generates URLs based on our routing
        $http   = $app['http_client'];   // service to make HTTP requests to the oauth server

        // pull the token from the request
        $token = $app['request']->get('token');

        // make the resource request with the token in the request body
        $config['resource_params']['access_token'] = $token;

        // determine the resource endpoint to call based on our config (do this somewhere else?)
        $apiRoute = $config['resource_route'];
        $endpoint = 0 === strpos($apiRoute, 'http') ? $apiRoute : $urlgen->generate($apiRoute, $config['resource_params'], true);

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
