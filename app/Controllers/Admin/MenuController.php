<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index($response)
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

        $title = 'Список пунктов меню';
        $success = $this->session->getFlashBag()->get('success');
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'admin.menu', compact('title', 'menu', 'success', 'errors'));
    }

    public function show($response, $id)
    {
        $item = Menu::find($id)->toArray();
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'admin.edit-menu-item', compact('item', 'errors'));
    }

    public function update($request, $response, $id)
    {
        $url = $request->getUri()->getPath();
        $input = $request->getParsedBody();
        $title = htmlspecialchars(trim($input['title']));
        $link = htmlspecialchars(trim($input['link']));
        $needUpdate = false;
        $itemId = intval($id);

        if ($itemId === 0)
        {
            return $response;
        }

        if (!$title || !$link)
        {
            $this->session->getFlashBag()->add('errors', 'Поля "Название" и "Ссылка" обязательные для заполнения');
            return $response->withHeader('Location', $url);
        }

        $item = Menu::find($itemId);
        if (!$item)
        {
            return $response;
        }

        if ($item->title !== $title)
        {
            $item->title = $title;
            $needUpdate = true;
        }
        if ($item->link !== $link)
        {
            if (Menu::where('link', $link)->exists())
            {
                $this->session->getFlashBag()->add('errors', 'Пункт меню со ссылкой '.$link.' уже существует');
                return $response->withHeader('Location', $url);
            }

            $item->link = $link;
            $needUpdate = true;
        }

        if ($needUpdate)
        {
            $item->save();

            if (config('app.cache.enable'))
            {
                $this->cache->delete('menu');
            }
        }

        $this->session->getFlashBag()->add('success', 'Пункт меню обновлён');

        return $response->withHeader('Location', config('admin.path').'/menu');
    }

    public function create($response)
    {
        $errors = $this->session->getFlashBag()->get('errors');
        return $this->view($response, 'admin.create-menu-item', compact('errors'));
    }

    public function store($request, $response)
    {
        $url = $request->getUri()->getPath();
        $input = $request->getParsedBody();
        $title = htmlspecialchars(trim($input['title']));
        $link = htmlspecialchars(trim($input['link']));

        if (!$title || !$link)
        {
            $this->session->getFlashBag()->add('errors', 'Поля "Название" и "Ссылка" обязательные для заполнения');
            return $response->withHeader('Location', $url);
        }

        if (Menu::where('link', $link)->exists())
        {
            $this->session->getFlashBag()->add('errors', 'Пункт меню со ссылкой '.$link.' уже существует');
            return $response->withHeader('Location', $url);
        }

        $item = Menu::create([
            'title' => $title,
            'link' => $link,
        ]);
        $item->save();

        if (config('app.cache.enable'))
        {
            $this->cache->delete('menu');
        }

        $this->session->getFlashBag()->add('success', 'Пункт меню успешно создан');

        return $response->withHeader('Location', config('admin.path').'/menu');
    }

    public function delete($response, $id)
    {
        $itemId = intval($id);
        $item = Menu::find($itemId);
        if ($item)
        {
            $res = $item->delete();
            if (!$res)
            {
                $this->session->getFlashBag()->add('errors', 'Что-то пошло не так, попробуйте позже');
            }
            else
            {
                if (config('app.cache.enable'))
                {
                    $this->cache->delete('menu');
                }
                $this->session->getFlashBag()->add('success', 'Пункт меню удалён');
            }
        }
        else
        {
            $this->session->getFlashBag()->add('errors', 'Пункт меню с id '.$itemId.' не найден');
        }

        return $response->withHeader('Location', config('admin.path').'/menu');
    }
}