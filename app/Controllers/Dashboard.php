<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function elearning()
    {
        return view('Dashboard/elearning-dashboard');
    }
    public function workorder()
    {
        return view('Dashboard/workorder-dashboard');
    }
}
