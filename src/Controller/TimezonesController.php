<?php

namespace Timezones\Controller;

use Silex\Application;
use OAuth2\HttpFoundationBridge\Response;
use Timezones\Model\User;
use Timezones\Model\Timezone;

class TimezonesController
{
    use AuthTrait;

    const SCOPE = 'timezones';

    static public function addRoutes($routing)
    {
        $routing->get('/timezones', array(new self(), 'getTimezones'));
    }

    public function getTimezones(Application $app)
    {
        $response = new Response();

        if (!$this->verifyResourceRequest($app, $response)) {
            return $response;
        }

        $user = $this->getCurrentUser($app);

        $response
            ->setData([
                'data' => [
                    'timezones' => array_map(function(Timezone $timezone) {
                        return $timezone->jsonSerialize();
                    }, $user->all('timezones')->toArray()),
                ],
            ]);

        return $response;
    }
}
