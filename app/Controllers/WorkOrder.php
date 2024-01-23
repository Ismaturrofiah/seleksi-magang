<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class WorkOrder extends BaseController
{
    public function index()
    {
        // return view('WorkOrder/categories-workorder');
    }

    public function categories()
    {
        return view('WorkOrder/categories-workorder');
    }
}
