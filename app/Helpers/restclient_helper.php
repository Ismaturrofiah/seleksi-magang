<?php

use App\Models\TokenModel;
use App\Models\UsersModel;

function token()
{
    $npp = session()->get('npp');
    if (!$npp) {
        return redirect()->to('/login');
    }
    $userModel = new UsersModel();
    $password = $userModel->getNpp($npp)['password'];
    $client = \Config\Services::curlrequest();
    $url = "http://localhost/itdash/public/api/login";
    $headers = [
        'Authorization' => 'Bearer ',
    ];
    $data = [
        'npp' => $npp,
        'password' => $password
    ];
    $response = $client->request('POST', $url, ['form_params' => $data, 'headers' => $headers, 'http_errors' => false]);
    $data = json_decode($response->getBody(), true);
    return $data['access_token'];
}

function access_restapi($method, $url, $data)
{
    $client = \Config\Services::curlrequest();
    $token = "";

    $headers = [
        'Authorization' => 'Bearer ' . $token
    ];

    $response = $client->request(
        $method,
        $url,
        [
            'headers' => $headers,
            'form_params' => $data,
            'http_errors' => false,
        ]
    );

    return $response->getBody();
}

function Getfetcher($url, $token, $data)
{
    $client = \Config\Services::curlrequest();

    $headers = [
        'Authorization' => 'Bearer ' . $token
    ];

    $response = $client->request(
        'GET',
        $url,
        [
            'headers' => $headers,
            'http_errors' => false,
        ]
    );

    $data = json_decode($response->getBody(), true);

    return $data;
}

function Postfetcher($url, $token, $data)
{
    $client = \Config\Services::curlrequest();
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $token
    ];

    $response = $client->request(
        'POST',
        $url,
        [
            'headers' => $headers,
            'http_errors' => false,
            'form_params' => $data
        ]
    );

    $data = json_decode($response->getBody(), true);
    dd($data);
    return $data;
}
