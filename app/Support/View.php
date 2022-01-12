<?php

namespace App\Support;

use Slim\App;
use eftec\bladeone\BladeOne;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Menu;

class View
{
    private $cache;

    public function __construct(App $app)
    {
        $this->cache = $app->getContainer()->get('cache');
    }

    public function get(Response $response, $template, $with = []): Response
    {
        if (strpos($_SERVER['REQUEST_URI'], config('admin.path')) === false)
        {
            $with['menu'] = $this->getMenuItems();
        }

        $blade = new BladeOne(
            config('blade.views'),
            config('blade.cache'),
            config('blade.mode')
        );
        $response->getBody()->write(
            $blade->run($template, $with)
        );
        return $response;
    }

    private function getMenuItems(): array
    {
        if (config('app.cache.enable'))
        {
            if ($this->cache->get('menu'))
            {
                $menu = $this->cache->get('menu');
            }
            else
            {
                $menu = Menu::all()->toArray();
                $this->cache->set('menu', $menu);
            }
        }
        else
        {
            $menu = Menu::all()->toArray();
        }

        return $menu;
    }
}