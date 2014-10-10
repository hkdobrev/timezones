<?php

namespace Timezones;

// Initialize the application
$app = require __DIR__.'/../src/app.php';

// Include the controllers
require __DIR__.'/../src/controllers.php';

// Run the app with an HTTP foundation request implementing OAuth2\RequestInterface
$app->run(\OAuth2\HttpFoundationBridge\Request::createFromGlobals());
