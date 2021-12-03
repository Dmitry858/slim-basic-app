<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\ResetPassword;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ResetPasswordController extends Controller
{
    public function send($request, $response)
    {
        $csrf = $this->getCsrf($request);
        $errors = $this->session->getFlashBag()->get('errors');

        return view($response, 'auth.send-reset-password-link', compact('csrf', 'errors'));
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
            $mail = new PHPMailer();
            $link = $request->getUri() . '/' . $key;
            try
            {
                $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
                $mail->addAddress($user->email);
                $mail->isHTML(true);
                $mail->Subject = 'Ссылка на восстановление пароля';
                $mail->Body = 'Для восстановления пароля перейдите по ссылке <a href="'.$link.'">'.$link.'</a>';
                $mail->send();
                return $response->withHeader('Location', $url.'/confirm');
            }
            catch (Exception $e)
            {
                $this->session->getFlashBag()->add('errors', $mail->ErrorInfo);
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
        return view($response, 'auth.send-reset-password-link-success');
    }

    public function show($request, $response, $key)
    {
        $csrf = $this->getCsrf($request);
        $errors = $this->session->getFlashBag()->get('errors');

        return view($response, 'auth.reset-password', compact('csrf', 'errors', 'key'));
    }
}