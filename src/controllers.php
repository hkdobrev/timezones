<?php

namespace Timezones;

$app->mount('/', new ControllerProvider());
$app->mount('/auth', new OAuth2\Client\OAuth2ClientControllerProvider());
$app->mount('/oauthserver', new OAuth2\Server\OAuth2ServerControllerProvider());
