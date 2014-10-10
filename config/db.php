<?php

namespace Timezones;

use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$app->register(new DoctrineServiceProvider(), [
    'db.options' => [
        'mysql' => [
            'driver' => 'pdo_mysql',
            'dbname' => 'timezones',
            'host' => 'localhost',
            'user' => 'vagrant',
            'password' => null,
            'charset' => 'utf8',
        ]
    ],
]);

$app->register(new DoctrineOrmServiceProvider, array(
    "orm.proxies_dir" => "var/cache/doctrine/proxies",
    "orm.em.options" => array(
        "mappings" => array(
            array(
                "type" => "annotation",
                "namespace" => "Timezones\Model",
                "path" => __DIR__."/../src/Model",
            ),
        ),
    ),
));
