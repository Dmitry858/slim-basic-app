<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class AdminController extends Controller
{
    public function index($response)
    {
        return view($response, 'admin.dashboard');
    }
}