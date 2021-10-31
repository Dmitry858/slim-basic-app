<?php

namespace App\Controllers;

class RegisterController
{
    public function show($response)
    {
        return view($response, 'auth.register');
    }

    public function store($response)
    {
        echo 'register';

        return $response;
    }
}