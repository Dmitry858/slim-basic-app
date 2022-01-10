<?php

namespace App\Controllers;

use App\Models\Page;
use App\Support\Auth;

class MainController extends Controller
{
    public function index($response)
    {
        if (config('app.cache.enable'))
        {
            if ($this->cache->get('home'))
            {
                $home = $this->cache->get('home');
            }
            else
            {
                $home = Page::where('slug', 'home')->first();
                if ($home) $this->cache->set('home', $home);
            }
        }
        else
        {
            $home = Page::where('slug', 'home')->first();
        }

        $title = $home->title;
        $content = $home->content;
        $userData = Auth::user();
        $user = $userData->name;
        $success = $this->session->getFlashBag()->get('success');

        return $this->view($response, 'home', compact('title', 'content', 'user', 'success'));
    }

    public function page($response, $slug)
    {
        if (config('app.cache.enable'))
        {
            if ($this->cache->get('pages'))
            {
                $pages = $this->cache->get('pages');
            }
            else
            {
                $pages = Page::all()->toArray();
                $this->cache->set('pages', $pages);
            }
        }
        else
        {
            $pages = Page::all()->toArray();
        }

        if (empty($pages))
        {
            $code = 404;
            return $this->view($response->withStatus(404), 'error', compact('code'));
        }

        foreach ($pages as $page)
        {
            if ($page['slug'] === $slug) $currentPage = $page;
        }

        if (!isset($currentPage))
        {
            $code = 404;
            return $this->view($response->withStatus(404), 'error', compact('code'));
        }

        $title = $currentPage['title'];
        $content = $currentPage['content'];
        return $this->view($response, 'page', compact('title', 'content'));
    }
}