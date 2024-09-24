<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.dashboard');
    }

    public function index2()
    {
        return view('admin.dashboard.dashboard2');
    }
}
