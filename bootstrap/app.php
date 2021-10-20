<?php
use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;

$app = SlimAppFactory::create(new Container);

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

/**
 * Initialize Illuminate Database Connection.
 */
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => config('database.driver'),
    'host' => config('database.host'),
    'database' => config('database.database'),
    'username' => config('database.username'),
    'password' => config('database.password'),
    'charset' => config('database.charset')
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $app;