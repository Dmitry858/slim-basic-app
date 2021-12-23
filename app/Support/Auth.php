<?php

namespace App\Support;

use App\Models\User;
use Symfony\Component\HttpFoundation\Session\Session;

class Auth
{
    public static function attempt($email, $password)
    {
        $user = User::where('email', $email);

        if (!$user->exists())
        {
            return false;
        }

        $user = $user->first();

        if ($password !== $user->password)
        {
            return false;
        }

        $session = new Session();
        $session->set('user', [
            'id' => $user->id,
            'email' => $user->email,
            'password' => $user->password
        ]);

        return true;
    }

    public static function logout()
    {
        $session = new Session();
        $session->set('user', [
            'id' => null,
            'email' => null,
            'password' => null
        ]);

        return self::guest();
    }

    public static function user()
    {
        $session = new Session();
        $sessionUser = $session->get('user');
        if ($sessionUser['email'] && $sessionUser['password'])
        {
            $user = User::where('email', $sessionUser['email'])->where('password', $sessionUser['password'])->first();
        }
        else
        {
            if (isset($_COOKIE['remember_me']) && strlen(trim($_COOKIE['remember_me'])) > 0)
            {
                $token = htmlspecialchars($_COOKIE['remember_me']);
                $user = User::where('remember_me_token', $token)->first();
                if ($user)
                {
                    $session->set('user', [
                        'id' => $user->id,
                        'email' => $user->email,
                        'password' => $user->password
                    ]);
                }
            }
            else
            {
                $user = null;
            }
        }

        return $user;
    }

    public static function check()
    {
        return self::user();
    }

    public static function guest()
    {
        return !self::check();
    }

    public static function admin()
    {
        $is_admin = false;
        $user = self::user();
        if ($user && $user->is_admin === 1)
        {
            $is_admin = true;
        }
        return $is_admin;
    }
}