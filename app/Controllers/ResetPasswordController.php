<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\ResetPassword;
use App\Support\Mail;

class ResetPasswordController extends Controller
{
    public function send($request, $response)
    {
        $csrf = $this->getCsrf($request);
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'auth.send-reset-password-link', compact('csrf', 'errors'));
    }

    public function store($request, $response)
    {
        $url = $request->getUri()->getPath();
        $input = $request->getParsedBody();
        $email = htmlspecialchars($input['email']);

        if (trim($email) === '')
        {
            $this->session->getFlashBag()->add('errors', 'Поле Email обязательно для заполнения');
            return $response->withHeader('Location', $url);
        }

        $user = User::where('email', $email)->first();
        if (!$user)
        {
            $this->session->getFlashBag()->add('errors', 'Пользователя с почтой '. $email .' не существует');
            return $response->withHeader('Location', $url);
        }

        $key = sha1($user->id . $user->email . time());

        $resetPass = ResetPassword::create([
            'key' => $key,
            'user_id' => $user->id
        ]);
        $result = $resetPass->save();

        if ($result)
        {
            $link = $request->getUri()->getScheme() . '://' . $request->getUri()->getHost() . $request->getUri()->getPath() . '/' . $key;
            $message = 'Для восстановления пароля перейдите по ссылке <a href="'.$link.'">'.$link.'</a>';
            $subject = 'Ссылка на восстановление пароля';

            $mail = new Mail;
            $sent = $mail->send($message, $subject, $user->email);

            if ($sent['status'] === 'success')
            {
                return $response->withHeader('Location', $url.'/confirm');
            }
            else
            {
                $this->session->getFlashBag()->add('errors', $sent['message']);
                return $response->withHeader('Location', $url);
            }
        }
        else
        {
            $this->session->getFlashBag()->add('errors', 'Что-то пошло не так, попробуйте позже');
            return $response->withHeader('Location', $url);
        }
    }

    public function confirm($response)
    {
        return $this->view($response, 'auth.send-reset-password-link-success');
    }

    public function show($request, $response, $key)
    {
        $csrf = $this->getCsrf($request);
        $errors = $this->session->getFlashBag()->get('errors');

        return $this->view($response, 'auth.reset-password', compact('csrf', 'errors', 'key'));
    }

    public function update($request, $response, $key)
    {
        $url = $request->getUri()->getPath();
        $input = $request->getParsedBody();
        $password = htmlspecialchars($input['password']);
        $confirm_password = htmlspecialchars($input['confirm_password']);
        $hasError = false;
        $resetPass = ResetPassword::where('key', $key)->first();

        if (!$resetPass)
        {
            $this->session->getFlashBag()->add('errors', 'Ссылка недействительная');
            $hasError = true;
        }

        if (!$password || !$confirm_password)
        {
            $this->session->getFlashBag()->add('errors', 'Все поля обязательные для заполнения');
            $hasError = true;
        }

        if ($password !== $confirm_password)
        {
            $this->session->getFlashBag()->add('errors', 'Пароль и подтвержение пароля не совпадают');
            $hasError = true;
        }

        if ($hasError)
        {
            return $response->withHeader('Location', $url);
        }

        $user = $resetPass->user;
        $user->password = sha1($password);
        $result = $user->save();

        if ($result)
        {
            $resetPass->delete();
            return $response->withHeader('Location', '/login');
        }

        $this->session->getFlashBag()->add('errors', 'Что-то пошло не так, попробуйте ещё раз');
        return $response->withHeader('Location', $url);
    }
}