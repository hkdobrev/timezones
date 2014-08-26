<?php

namespace Timezones;

// Use Composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Debug;

// Initialize the application
$app = require __DIR__.'/../src/app.php';

// Load environment and relevant configuration
$environment = getenv('TIMEZONES_ENV') ?: 'prod';
require __DIR__.'/../config/'.$environment.'.php';

// http://silex.sensiolabs.org/doc/cookbook/error_handler.html
Debug\ErrorHandler::register();
Debug\ExceptionHandler::register(
    'prod' === $environment ? false : $app['debug']
);

unset($environment);

// Include the controllers
require __DIR__.'/../src/controllers.php';

// Run the app
// create an http foundation request implementing OAuth2\RequestInterface
$request = \OAuth2\HttpFoundationBridge\Request::createFromGlobals();
$app->run($request);
