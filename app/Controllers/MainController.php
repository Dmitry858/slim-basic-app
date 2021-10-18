<?php
namespace App\Controllers;

class MainController
{
    public function index($response)
    {
        return view($response, 'home');
    }

    public function page($response, $slug)
    {
        echo $slug;
        $title = 'Внутренняя страница';
        return view($response, 'page', compact('title'));
    }
}