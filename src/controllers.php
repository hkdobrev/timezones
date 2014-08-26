<?php

namespace Timezones;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

$app['base_path'] = '/';

$app->mount($app['base_path'], new ControllerProvider());
$app->mount('/auth', new OAuth2\Client\OAuth2ClientControllerProvider());
$app->mount('/oauthserver', new OAuth2\Server\OAuth2ServerControllerProvider());

// Unmatched routes should go to the homepage so AngularJS could load.
// AngularJS front-end routes are not currently matched on the back-end.
$app->error(function(NotFoundHttpException $exception, $code) use ($app) {
    if (!$exception->getPrevious()
     or ! $exception->getPrevious() instanceof ResourceNotFoundException) {
        return;
    }

    return new Response('', 302, [
        // Include the previous path in the fragment so AngularJS could use it
        'location' => $app['base_path'].'#'.$_SERVER['REQUEST_URI'],
    ]);
});
