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
        $routing
            ->get('/timezones', array(new self(), 'getTimezones'))
            ->before('TimezonesController::before');

        $routing
            ->post('/timezones', array(new self(), 'createTimezone'))
            ->before('TimezonesController::before');
    }

    public static function before(Request $request, Application $app)
    {
        $response = new Response();
        if (!(new self())->verifyResourceRequest($app, $response, static::SCOPE)) {
            return $response;
        }
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
