<?php

namespace Timezones\OAuth2\Client\Controller;

use Silex\Application;
use OAuth2\HttpFoundationBridge\Response;

class RequestTokenController
{
    static public function addRoutes($routing)
    {
        $routing
            ->post('/login', array(new self(), 'requestTokenWithUserCredentials'))
            ->bind('request_token_with_usercredentials');

        $routing
            ->get('/refresh_token', array(new self(), 'requestTokenWithRefreshToken'))
            ->bind('request_token_with_refresh_token');
    }

    public function requestTokenWithUserCredentials(Application $app)
    {
        $config = $app['oauth'];    // the configuration for the current oauth implementation
        $http   = $app['http_client'];   // simple class used to make http requests

        $payload = json_decode($app['request']->getContent());

        $username = isset($payload->username) ? $payload->username : '';
        $password = isset($payload->password) ? $payload->password : '';
        $scope = isset($payload->scope) ? $payload->scope : '';

        // exchange user credentials for access token
        $query = array(
            'grant_type'    => 'password',
            'client_id'     => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'username'      => $username,
            'password'      => $password,
            'scope'         => $scope,
        );

        // determine the token endpoint to call based on our config (do this somewhere else?)
        $grantRoute = $config['token_route'];
        $endpoint = 0 === strpos($grantRoute, 'http')
            ? $grantRoute
            : $app->url($grantRoute);

        // make the token request via http and decode the json response
        $internalResponse = $http->post($endpoint, array_merge([
            'body' => $query,
        ], $config['http_options']));
        
        $json = json_decode((string) $internalResponse->getBody(), true);

        return new Response($json, $internalResponse->getStatusCode());
    }

    public function requestTokenWithRefreshToken(Application $app)
    {
        $config = $app['oauth'];    // the configuration for the current oauth implementation
        $http   = $app['http_client'];   // simple class used to make http requests

        $username = $app['request']->get('refresh_token');

        // exchange user credentials for access token
        $query = array(
            'grant_type'    => 'refresh_token',
            'client_id'     => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'refresh_token' => $username,
        );

        // determine the token endpoint to call based on our config (do this somewhere else?)
        $grantRoute = $config['token_route'];
        $endpoint = 0 === strpos($grantRoute, 'http')
            ? $grantRoute
            : $app->url($grantRoute);

        // make the token request via http and decode the json response
        $internalResponse = $http->post($endpoint, array_merge([
            'body' => $query,
        ], $config['http_options']));
        
        $json = json_decode((string) $internalResponse->getBody(), true);

        return new Response($json, $internalResponse->getStatusCode());

    }
}
