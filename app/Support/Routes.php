<?php

namespace App\Support;

use Slim\App;

class Routes
{
    private string $routes_path = __DIR__ . '/../../routes/';
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function init()
    {
        $files = scandir($this->routes_path);

        foreach ($files as $file)
        {
            $fileInfo = new \SplFileInfo($file);
            $extension = $fileInfo->getExtension();
            if ($extension === 'php')
            {
                $name = $fileInfo->getFilename();
                $routes = require $this->routes_path . $name;
                $routes($this->app);
            }
        }
    }

    public function generateUrl(string $routeName, array $data = [], array $queryParams = []): string
    {
        $routeParser = $this->app->getRouteCollector()->getRouteParser();
        return $routeParser->urlFor($routeName, $data, $queryParams);
    }
}