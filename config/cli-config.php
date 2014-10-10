<?php

$app = require __DIR__.'/../src/app.php';

$loader = require __DIR__ . '/../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app['orm.em']);
