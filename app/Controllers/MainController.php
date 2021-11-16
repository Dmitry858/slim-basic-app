<?php

namespace App\Controllers;

use App\Models\Page;
use App\Support\Auth;

class MainController extends Controller
{
    public function index($response)
    {
        $userData = Auth::user();
        $user = $userData->name;
        $success = $this->session->getFlashBag()->get('success');

        return view($response, 'home', compact('user', 'success'));
    }

    public function page($response, $slug)
    {
        $pages = Page::all()->toArray();
        if (empty($pages)) return $response->withStatus(404);

        foreach ($pages as $page)
        {
            if ($page['slug'] === $slug) $currentPage = $page;
        }

        if (!isset($currentPage)) return $response->withStatus(404);

        $title = $currentPage['title'];
        $content = $currentPage['content'];
        return view($response, 'page', compact('title', 'content'));
    }
}