<?php

namespace App\Controllers;

class ResetPasswordController extends Controller
{
    public function send($request, $response)
    {
        $csrf = $this->getCsrf($request);
        $errors = $this->session->getFlashBag()->get('errors');

        return view($response, 'auth.send-reset-password-link', compact('csrf', 'errors'));
    }

    public function show($request, $response, $key)
    {
        $csrf = $this->getCsrf($request);
        $errors = $this->session->getFlashBag()->get('errors');

        return view($response, 'auth.reset-password', compact('csrf', 'errors', 'key'));
    }
}