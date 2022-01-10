<?php

namespace App\Controllers;

use App\Models\User;
use App\Support\Auth;

class RegisterController extends Controller
{
    public function show($request, $response)
    {
        $csrf = $this->getCsrf($request);
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'auth.register', compact('csrf', 'errors'));
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

        if (User::where('email', $email)->exists())
        {
            $this->session->getFlashBag()->add('errors', 'Пользователь с почтой '. $email .' уже существует');
            return $response->withHeader('Location', $url);
        }
        else
        {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);
            $user->save();

            $this->session->getFlashBag()->add('success', 'Регистрация прошла успешно!');

            Auth::attempt($email, $password);
            return $response->withHeader('Location', '/')->withStatus(302);
        }
    }
}