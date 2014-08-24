<?php

use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Harp\Query\DB;

// include the default configuration
require __DIR__.'/default.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// enable the debug mode
$app['debug'] = true;

$app->register(new TwigServiceProvider());

$app['twig.options'] = ['debug' => true, 'cache' => false];

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/log/silex_dev.log',
    'monolog.name' => 'timezones',
));

$app->register(new WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../var/cache/profiler',
));

DB::setConfig([
    'dsn' => 'mysql:dbname=timezones;host=127.0.0.1',
    'username' => 'root',
    'password' => '',
]);
