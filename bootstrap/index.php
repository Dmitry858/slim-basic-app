<?php
use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = SlimAppFactory::create(new Container);

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();