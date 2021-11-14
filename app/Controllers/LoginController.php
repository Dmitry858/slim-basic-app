<?php

namespace App\Controllers;

use App\Support\Auth;

class LoginController extends Controller
{
    public function show($request, $response)
    {
        $csrf = [
            $this->csrfNameKey => $request->getAttribute($this->csrfNameKey),
            $this->csrfValueKey => $request->getAttribute($this->csrfValueKey),
        ];

        $errors = $this->session->getFlashBag()->get('errors');

        return view($response, 'auth.login', compact('csrf', 'errors'));
    }

    public function store($request, $response)
    {
        $input = $request->getParsedBody();
        $email = htmlspecialchars($input['email']);
        $password = sha1($input['password']);

        $successful = Auth::attempt($email, $password);

        if (!$successful)
        {
            $url = $request->getUri()->getPath();

            $this->session->getFlashBag()->add('errors', 'Логин или пароль неверный');

            return $response->withHeader('Location', $url);
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