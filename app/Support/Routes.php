<?php

namespace App\Support;

use Slim\App;

class Routes
{
    private string $routes_path = __DIR__ . '/../../routes/';

    public function init(App $app)
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
                $routes($app);
            }
        }
    }
}