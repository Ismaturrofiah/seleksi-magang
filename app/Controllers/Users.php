<?php

namespace App\Controllers;

use App\Models\TokenModel;

use CodeIgniter\Controller;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Users extends BaseController
{
    public function __construct()
    {
        helper('alert');
        helper('restclient');
        $this->token = new TokenModel();
    }

    public function index()
    {
        $token = session()->get('token');
        $data = [
            'token' => $token,
        ];
        return view('Users/index', $data);
    }

    public function profile()
    {
        return view('Users/user-profile');
    }

    public function apply()
    {
        return view('Users/user-apply');
    }

    public function info()
    {
        return view('Users/user-info');
    }
}
