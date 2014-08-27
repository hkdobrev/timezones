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
            ->before('Timezones\Controller\TimezonesController::before');

        $routing
            ->post('/timezones', array(new self(), 'createTimezone'))
            ->before('Timezones\Controller\TimezonesController::before');
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

        $query = $app['request']->query('q');

        $timezones = $user->all('timezones');

        if ($query) {
            $timezones = $timezones->filter(function($timezone) use ($query) {
                return mb_strpos($timezone->name, $query) !== false;
            });
        }

        return new Response(
            array_map(function(Timezone $timezone) {
                return $timezone->jsonSerialize();
            }, $timezones->toArray())
        );
    }

    public function createTimezone(Application $app)
    {
        $user = $this->getCurrentUser($app);

        $payload = json_decode($app['request']->getContent(), true);

        $timezone = new Timezone(array_merge($payload, [
            'userId' => $user->id,
        ]));

        if (!$timezone->validate()) {
            return new Response([
                'error' => 'Timezone could not be validated',
                'message' => $timezone->getErrors()->humanize(),
            ], 400);
        }

        Timezone::save($timezone);

        return new Response($timezone, 201);
    }
}
