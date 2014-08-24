<?php

namespace Timezones;

use Silex\Provider\UrlGeneratorServiceProvider;
// use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
// $app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());

return $app;
