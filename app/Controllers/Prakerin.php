<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Prakerin extends BaseController
{
    public function index()
    {
    }

    public function quota()
    {
        return view('Prakerin/quota-prakerin');
    }
}
