<?php

namespace App\Support;

use App\Models\User;

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

        $_SESSION['user'] = [
            'id' => $user->id,
            'email' => $user->email,
            'password' => $user->password
        ];

        return true;
    }

    public static function logout()
    {
        $_SESSION['user'] = [
            'id' => null,
            'email' => null,
            'password' => null
        ];

        return self::guest();
    }

    public static function user()
    {
        $user = User::where($_SESSION['user']);

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