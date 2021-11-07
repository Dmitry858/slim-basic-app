<?php

namespace App\Controllers;

use App\Models\User;
use App\Support\Auth;

class RegisterController extends Controller
{
    public function show($request, $response)
    {
        $csrf = [
            $this->csrfNameKey => $request->getAttribute($this->csrfNameKey),
            $this->csrfValueKey => $request->getAttribute($this->csrfValueKey),
        ];

        return view($response, 'auth.register', compact('csrf'));
    }

    public function store($request, $response)
    {
        $input = $request->getParsedBody();
        $hasErrors = false;
        foreach ($input as $value)
        {
            if (trim($value) === '')
            {
                $hasErrors = true;
                echo 'Все поля обязательные для заполнения';
                echo '<br>';
                break;
            }
        }

        if ($input['password'] !== $input['confirm_password'])
        {
            $hasErrors = true;
            echo 'Пароль и подтверждение пароля не совпадают';
        }

        if ($hasErrors) return $response;

        $name = htmlspecialchars($input['name']);
        $email = htmlspecialchars($input['email']);
        $password = sha1($input['password']);

        if (User::where('email', $email)->exists())
        {
            echo 'Пользователь с почтой '. $email .' уже существует';
            return $response;
        }
        else
        {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);
            $user->save();

            Auth::attempt($email, $password);
            return $response->withHeader('Location', '/')->withStatus(302);
        }
    }
}