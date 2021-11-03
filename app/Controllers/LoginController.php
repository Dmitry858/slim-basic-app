<?php

namespace App\Controllers;

use App\Support\Auth;

class LoginController
{
    public function show($response)
    {
        return view($response, 'auth.login');
    }

    public function store($request, $response)
    {
        $input = $request->getParsedBody();
        $email = htmlspecialchars($input['email']);
        $password = sha1($input['password']);

        $successful = Auth::attempt($email, $password);

        if (!$successful)
        {
            echo 'Логин или пароль неверный';
            return $response;
        }

        return $response->withHeader('Location', '/')->withStatus(302);
    }

    public function logout($request, $response)
    {
        Auth::logout();

        if (Auth::guest())
        {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }
    }
}