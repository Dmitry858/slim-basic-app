<?php
use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Middleware\Middleware;
use Slim\Csrf\Guard;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Start session.
 */
$session = new Session();
$session->start();

$container = new Container;
$app = SlimAppFactory::create($container);

$responseFactory = $app->getResponseFactory();
$container->set('csrf', function () use ($responseFactory) {
    return new Guard($responseFactory);
});

$middleware = new Middleware;
$middleware->init($app);

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