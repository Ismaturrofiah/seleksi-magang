<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TokenModel;

class Auth extends BaseController
{
    public function __construct()
    {
        helper('alert');
        helper('restclient');
    }

    public function index()
    {
        return view('auth/login');
    }

    public function signup()
    {
        return view('auth/signup');
    }

    public function login()
    {
        $npp = $this->request->getVar('npp');
        $password = $this->request->getVar('password');

        if ($npp) {
            $data = [
                'npp' => $npp,
                'password' => $password
            ];

            $response = access_restapi('POST', "http://localhost/itdash/public/api/login", $data);
            $apiData = json_decode($response, true);

            if (isset($apiData['message']['error'])) {
                setFlashDataError($apiData['messages']['error']);
                return redirect()->back()->withInput();
            } else {
                if ($apiData['status'] == '0') {
                    setFlashDataError($apiData['message']);
                    return redirect()->to(site_url('login'));
                } else {
                    $sessData = [
                        'id' => $apiData['data']['id'],
                        'npp' => $apiData['data']['npp'],
                        'nama' => $apiData['data']['nama'],
                        'email' => $apiData['data']['email'],
                        'role' => $apiData['data']['role'],
                        'token' => $apiData['access_token'],
                        'isLoggedIn' => TRUE
                    ];
                    session()->set($sessData);

                    $model = new TokenModel();
                    $token = [
                        'id' => '1',
                        'token' => $apiData['access_token']
                    ];
                    $insertToken = $model->save($token);

                    if ($insertToken) {
                        setFlashDataSuccess("Login Berhasil");
                        if (session()->get('role') != 3) {
                            return redirect()->to(site_url('dashboard/e-learning'));
                        } else {
                            return redirect()->to(site_url('/'));
                        }
                    } else {
                        setFlashDataError("Login Gagal");
                        return redirect()->to(site_url('login'));
                    }
                }
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('/login'));
    }
}
