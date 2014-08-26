<?php

namespace Timezones\Controller;

use Silex\Application;
use Timezones\Model\User;
use OAuth2\HttpFoundationBridge\Response;

trait AuthTrait
{

    protected $currentUser;

    public function verifyResourceRequest(Application $app, Response $response)
    {
        $request = $app['request'];

        return $app['oauth_server']
            ->verifyResourceRequest($app['request'], $response, static::SCOPE);
    }

    public function getCurrentUser(Application $app)
    {
        if (!$this->currentUser) {
            $token = $app['oauth_server']->getAccessTokenData($app['request']);

            $this->currentUser =  User::find($token['user_id']);
        }

        return $this->currentUser;
    }
}
