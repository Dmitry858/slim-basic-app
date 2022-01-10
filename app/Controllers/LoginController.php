<?php

namespace App\Controllers;

use App\Support\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function show($request, $response)
    {
        $csrf = $this->getCsrf($request);
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'auth.login', compact('csrf', 'errors'));
    }

    public function store($request, $response)
    {
        $input = $request->getParsedBody();
        $email = htmlspecialchars($input['email']);
        $password = sha1($input['password']);
        $remember_me = $input['remember_me'];

        $successful = Auth::attempt($email, $password);

        if (!$successful)
        {
            $url = $request->getUri()->getPath();

            $this->session->getFlashBag()->add('errors', 'Логин или пароль неверный');

            return $response->withHeader('Location', $url);
        }

        if ($remember_me)
        {
            $user = User::where('email', $email)->first();
            $token = hash('sha256', $user->id . $email . time() . 'anysalt');
            $user->remember_me_token = $token;
            $user->save();
            setcookie('remember_me', $token, time() + 86400 * 30);
        }

        return $response->withHeader('Location', '/')->withStatus(302);
    }

    public function logout($response)
    {
        if (isset($_COOKIE['remember_me']) && strlen(trim($_COOKIE['remember_me'])) > 0)
        {
            $token = htmlspecialchars($_COOKIE['remember_me']);
            $user = User::where('remember_me_token', $token)->first();
            setcookie('remember_me', '', time() - 3600);
            if ($user)
            {
                $user->remember_me_token = null;
                $user->save();
            }
        }

        Auth::logout();

        if (Auth::guest())
        {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }
    }
}