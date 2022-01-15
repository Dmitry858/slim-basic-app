<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index($response)
    {
        $users = User::paginate(15);
        $users->withPath(config('admin.path').'/users');
        $title = 'Список пользователей';
        $success = $this->session->getFlashBag()->get('success');
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'admin.users', compact('title', 'users', 'success', 'errors'));
    }

    public function show($response, $id)
    {
        $user = User::find($id)->toArray();
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'admin.edit-user', compact('user', 'errors'));
    }

    public function update($request, $response, $id)
    {
        $url = $request->getUri()->getPath();
        $input = $request->getParsedBody();
        $name = htmlspecialchars(trim($input['name']));
        $email = htmlspecialchars(trim($input['email']));
        $newPassword = htmlspecialchars(trim($input['new_password']));
        $isAdmin = intval($input['is_admin']);
        $hasErrors = false;
        $needUpdate = false;
        $userId = intval($id);

        if ($userId === 0)
        {
            return $response;
        }

        if (!$name || !$email)
        {
            $hasErrors = true;
            $this->session->getFlashBag()->add('errors', 'Поля "Имя" и "Email" обязательные для заполнения');
        }

        if ($input['new_password'] !== $input['confirm_new_password'])
        {
            $hasErrors = true;
            $this->session->getFlashBag()->add('errors', 'Новый пароль и подтверждение нового пароля не совпадают');
        }

        if ($hasErrors)
        {
            return $response->withHeader('Location', $url);
        }

        $user = User::find($userId);
        if (!$user)
        {
            return $response;
        }

        if ($user->name !== $name)
        {
            $user->name = $name;
            $needUpdate = true;
        }
        if ($user->email !== $email)
        {
            $user->email = $email;
            $needUpdate = true;
        }
        if ($user->is_admin !== $isAdmin)
        {
            $user->is_admin = $isAdmin;
            $needUpdate = true;
        }
        if ($newPassword)
        {
            $user->password = sha1($newPassword);
            $needUpdate = true;
        }

        if ($needUpdate)
        {
            $user->save();

            if (config('app.cache.enable'))
            {
                $this->cache->delete('users');
            }
        }

        $this->session->getFlashBag()->add('success', 'Пользователь обновлён');

        return $response->withHeader('Location', config('admin.path').'/users');
    }

    public function create($response)
    {
        $errors = $this->session->getFlashBag()->get('errors');
        return $this->view($response, 'admin.create-user', compact('errors'));
    }

    public function store($request, $response)
    {
        $url = $request->getUri()->getPath();
        $input = $request->getParsedBody();
        $hasErrors = false;
        foreach ($input as $value)
        {
            if (trim($value) === '')
            {
                $hasErrors = true;
                $this->session->getFlashBag()->add('errors', 'Все поля обязательные для заполнения');
                break;
            }
        }

        if ($input['password'] !== $input['confirm_password'])
        {
            $hasErrors = true;
            $this->session->getFlashBag()->add('errors', 'Пароль и подтверждение пароля не совпадают');
        }

        if ($hasErrors)
        {
            return $response->withHeader('Location', $url);
        }

        $name = htmlspecialchars($input['name']);
        $email = htmlspecialchars($input['email']);
        $password = sha1($input['password']);
        $isAdmin = intval($input['is_admin']);

        if (User::where('email', $email)->exists())
        {
            $this->session->getFlashBag()->add('errors', 'Пользователь с почтой '. $email .' уже существует');
            return $response->withHeader('Location', $url);
        }
        else
        {
            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = $password;
            $user->is_admin = $isAdmin;
            $user->save();

            $this->session->getFlashBag()->add('success', 'Пользователь успешно создан');

            return $response->withHeader('Location', config('admin.path').'/users');
        }
    }

    public function delete($response, $id)
    {
        $userId = intval($id);
        $user = User::find($userId);
        if ($user)
        {
            $res = $user->delete();
            if (!$res)
            {
                $this->session->getFlashBag()->add('errors', 'Что-то пошло не так, попробуйте позже');
            }
            else
            {
                if (config('app.cache.enable'))
                {
                    $this->cache->delete('users');
                }
                $this->session->getFlashBag()->add('success', 'Пользователь удалён');
            }
        }
        else
        {
            $this->session->getFlashBag()->add('errors', 'Пользователь с id '.$userId.' не найден');
        }

        return $response->withHeader('Location', config('admin.path').'/users');
    }
}