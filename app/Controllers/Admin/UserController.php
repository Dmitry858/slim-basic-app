<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index($response)
    {
        if (config('app.cache.enable'))
        {
            if ($this->cache->get('users'))
            {
                $users = $this->cache->get('users');
            }
            else
            {
                $users = User::all()->toArray();
                $this->cache->set('users', $users);
            }
        }
        else
        {
            $users = User::all()->toArray();
        }

        $title = 'Список пользователей';
        $success = $this->session->getFlashBag()->get('success');

        return view($response, 'admin.users', compact('title', 'users', 'success'));
    }

    public function show($response, $id)
    {
        return $response;
    }

    public function update($request, $response, $id)
    {
        return $response;
    }

    public function create($request, $response)
    {
        return $response;
    }

    public function store($request, $response)
    {
        return $response;
    }

    public function delete($response, $id)
    {
        return $response;
    }
}