<?php

namespace Timezones\Controller;

use Silex\Application;
use OAuth2\HttpFoundationBridge\Response;
use Timezones\Model\User;
use Timezones\Model\Timezone;

class TimezonesController
{
    const SCOPE = 'timezones';

    static public function addRoutes($routing)
    {
        $routing->get('/timezones', array(new self(), 'getTimezones'));
    }

    public function getTimezones(Application $app)
    {
        $request = $app['request'];
        $response = new Response();
        $oauthServer = $app['oauth_server'];

        if (!$oauthServer->verifyResourceRequest($request, $response, static::SCOPE)) {
            return $response;
        }

        $token = $oauthServer->getAccessTokenData($request);
        $user = User::find($token['user_id']);

        $response
            ->setData([
                'data' => [
                    'timezones' => array_map(function(Timezone $timezone) {
                        return $timezone->name;
                    }, $user->all('timezones')->toArray()),
                ],
            ]);

        return $response;
    }
}
