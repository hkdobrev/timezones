<?php

namespace Timezones;

use Harp\Query\DB;

$app['db'] = [
    'dsn' => 'mysql:dbname=timezones;host=127.0.0.1',
    'username' => 'root',
    'password' => '',
];

DB::setConfig($app['db']);
