<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class AdminController extends Controller
{
    public function index($response)
    {
        return $this->view($response, 'admin.dashboard');
    }
}