<?php

namespace Timezones;

$app['homepage.controller'] = $app->share(function(Application $app) {
    return new Controller\HomepageController();
});

$app->get('/', 'homepage.controller:show')
    ->bind('homepage');

$app->mount('/oauth', new OAuth2\Client\OAuth2ClientControllerProvider());
$app->mount('/oauthserver', new OAuth2\Server\OAuth2ServerControllerProvider());
