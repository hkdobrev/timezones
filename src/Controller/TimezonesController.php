<?php

namespace Timezones\Controller;

use Silex\Application;
use Timezones\Model\Timezone;
use OAuth2\HttpFoundationBridge\Response;
use OAuth2\HttpFoundationBridge\Request;

class TimezonesController
{
    use AuthTrait;

    const SCOPE = 'timezones';

    public static function addRoutes($routing, Application $app)
    {
        $routing->before(function(Request $request) use ($app) {
            $response = new Response();
            if (!(new self())->verifyResourceRequest($app, $response, static::SCOPE)) {
                return $response;
            }
        });

        $routing->get('/timezones', array(new self(), 'getTimezones'));
    }

    public function getTimezones(Application $app)
    {
        $user = $this->getCurrentUser($app);

        return new Response([
            'data' => [
                'timezones' => array_map(function(Timezone $timezone) {
                    return $timezone->jsonSerialize();
                }, $user->all('timezones')->toArray()),
            ],
        ]);
    }
}
