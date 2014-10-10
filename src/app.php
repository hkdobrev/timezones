<?php

namespace Timezones;

use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\Debug;

// Use Composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ServiceControllerServiceProvider());

// Load environment and relevant configuration
$app['env'] = getenv('TIMEZONES_ENV') ?: 'prod';

require __DIR__.'/../config/'.$app['env'].'.php';

// http://silex.sensiolabs.org/doc/cookbook/error_handler.html
Debug\ErrorHandler::register();
Debug\ExceptionHandler::register(
    'prod' === $app['env'] ? false : $app['debug']
);

return $app;
