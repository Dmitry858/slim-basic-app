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
        $user = User::where('email', $sessionUser['email'])->where('password', $sessionUser['password']);

        return $user->exists() ? $user->first() : false;
    }

    public static function check()
    {
        return self::user();
    }

    public static function guest()
    {
        return !self::check();
    }
}