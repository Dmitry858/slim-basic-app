<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function index($response)
    {
        $pages = Page::paginate(15);
        $pages->withPath(config('admin.path').'/pages');
        $title = 'Список страниц';
        $success = $this->session->getFlashBag()->get('success');
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'admin.pages', compact('title', 'pages', 'success', 'errors'));
    }

    public function show($response, $id)
    {
        $page = Page::find($id)->toArray();
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'admin.edit-page', compact('page', 'errors'));
    }

    public function update($request, $response, $id)
    {
        $url = $request->getUri()->getPath();
        $input = $request->getParsedBody();
        $title = htmlspecialchars(trim($input['title']));
        $slug = htmlspecialchars(trim($input['slug']));
        $needUpdate = false;
        $pageId = intval($id);

        if ($pageId === 0)
        {
            return $response;
        }

        if (!$title || !$slug)
        {
            $this->session->getFlashBag()->add('errors', 'Поля "Заголовок" и "Слаг" обязательные для заполнения');
            return $response->withHeader('Location', $url);
        }

        $page = Page::find($pageId);
        if (!$page)
        {
            return $response;
        }

        if ($page->title !== $title)
        {
            $page->title = $title;
            $needUpdate = true;
        }
        if ($page->slug !== $slug)
        {
            if (Page::where('slug', $slug)->exists())
            {
                $this->session->getFlashBag()->add('errors', 'Страница со слагом '.$slug.' уже существует');
                return $response->withHeader('Location', $url);
            }

            $page->slug = $slug;
            $needUpdate = true;
        }
        if ($page->excerpt !== $input['excerpt'])
        {
            $page->excerpt = $input['excerpt'];
            $needUpdate = true;
        }
        if ($page->content !== $input['content'])
        {
            $page->content = $input['content'];
            $needUpdate = true;
        }

        if ($needUpdate)
        {
            $page->save();

            if (config('app.cache.enable'))
            {
                $this->cache->delete('pages');
            }
        }

        $this->session->getFlashBag()->add('success', 'Страница обновлена');

        return $response->withHeader('Location', config('admin.path').'/pages');
    }

    public function create($response)
    {
        $errors = $this->session->getFlashBag()->get('errors');
        return $this->view($response, 'admin.create-page', compact('errors'));
    }

    public function store($request, $response)
    {
        $url = $request->getUri()->getPath();
        $input = $request->getParsedBody();
        $title = htmlspecialchars(trim($input['title']));
        $slug = htmlspecialchars(trim($input['slug']));

        if (!$title || !$slug)
        {
            $this->session->getFlashBag()->add('errors', 'Поля "Заголовок" и "Слаг" обязательные для заполнения');
            return $response->withHeader('Location', $url);
        }

        if (Page::where('slug', $slug)->exists())
        {
            $this->session->getFlashBag()->add('errors', 'Страница со слагом '.$slug.' уже существует');
            return $response->withHeader('Location', $url);
        }

        $page = Page::create([
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $input['excerpt'],
            'content' => $input['content'],
        ]);
        $page->save();

        if (config('app.cache.enable'))
        {
            $this->cache->delete('pages');
        }

        $this->session->getFlashBag()->add('success', 'Страница успешно создана');

        return $response->withHeader('Location', config('admin.path').'/pages');
    }

    public function delete($response, $id)
    {
        $pageId = intval($id);
        $page = Page::find($pageId);
        if ($page)
        {
            $res = $page->delete();
            if (!$res)
            {
                $this->session->getFlashBag()->add('errors', 'Что-то пошло не так, попробуйте позже');
            }
            else
            {
                if (config('app.cache.enable'))
                {
                    $this->cache->delete('pages');
                }
                $this->session->getFlashBag()->add('success', 'Страница удалена');
            }
        }
        else
        {
            $this->session->getFlashBag()->add('errors', 'Страница с id '.$pageId.' не найдена');
        }

        return $response->withHeader('Location', config('admin.path').'/pages');
    }
}