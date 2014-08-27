<?php

namespace Timezones\Controller;

use Timezones\Model\User;
use OAuth2\HttpFoundationBridge\Response;

class SignupController
{
    public static function addRoutes($routing)
    {
        $routing->post('/auth/signup', array(new self(), 'createUser'));
    }

    public function createUser(\Silex\Application $app)
    {
        $payload = json_decode($app['request']->getContent());

        $user = new User([
            'username' => isset($payload->username) ? $payload->username : '',
            'password' => isset($payload->password) ? $payload->password : '',
        ]);

        if (!$user->validate()) {
            return new Response([
                'error' => 'User could not be validated',
                'message' => $user->getErrors()->humanize(),
            ], 400);
        }

        User::save($user);

        return new Response($user, 201);
    }
}
