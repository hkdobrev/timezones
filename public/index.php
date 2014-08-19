<?php

// Use Composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Initialize the application
$app = require __DIR__.'/../src/app.php';

// Load environment and relevant configuration
$environment = getenv('TIMEZONES_ENV') ?: 'prod';
require __DIR__.'/../config/'.$environment.'.php';
unset($environment);

// http://silex.sensiolabs.org/doc/cookbook/error_handler.html
ErrorHandler::register();
ExceptionHandler::register($app['debug']);

// Include the controllers
require __DIR__.'/../src/controllers.php';

// Run the app
$app->run();
