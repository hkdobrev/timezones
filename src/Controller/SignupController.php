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

        $user = new User();
        $user->username = isset($payload->username) ? $payload->username : '';
        $user->password = isset($payload->password) ? $payload->password : '';

        if ($user->validate()) {
            User::save($user);

            $response = [
                'status' => 'OK',
                'message' => sprintf(
                    'User %s created successfully',
                    $user->username
                ),
            ];
        } else {
            $response = [
                'error' => 'User could not be validated',
                'message' => $user->getErrors()->humanize(),
            ];
        }

        return new Response($response, $user->isEmptyErrors() ? 200 : 400);
    }
}
