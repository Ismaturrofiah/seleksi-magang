<?php

use App\Models\UsersModel;
use Firebase\JWT\JWT;
use Firebase\JWT\KEY;

function createJWT($npp)
{
    $key = getenv('JWT_SECRET_KEY');
    $RequestToken = time();
    $ExpiredToken = $RequestToken + 3600;
    $payload = [
        'npp' => $npp,
        'iat' => $RequestToken,
        'exp' => $ExpiredToken,
    ];
    $jwt = JWT::encode($payload, $key, 'H256');
    return $jwt;
}

function getJWT($autentikasiHeader)
{
    if (is_null($autentikasiHeader)) {
        throw new Exception("Autentikasi JWT gagal");
    }
    return explode(" ", $autentikasiHeader)[1];
}

function validateJWT($encodedToken)
{
    $key = getenv('JWT_SECRET_KEY');
    $decodedToken = JWT::decode($encodedToken, new KEY($key, 'HS256'));
    $modelUsers = new UsersModel();

    $modelUsers->getNPP($decodedToken->npp);
}
