<?php

use \Modules\Maja\Models\MajaModel;

function getMajaInfo()
{
    $model = new Modules\SettingMaja\Models\SettingMajaModel;
    $result = $model->where(['status' => '1'])->findAll();
    return $result;
}

function requestToken()
{
    $majaInfo = getMajaInfo();
    $client = \Config\Services::curlrequest();
    $url = $majaInfo[0]->url;
    $body['client_id'] = $majaInfo[0]->client_id;
    $body['client_secret'] = $majaInfo[0]->client_secret;
    $body['grant_type'] = 'password';
    $body['username'] = $majaInfo[0]->username;
    $body['password'] = $majaInfo[0]->password;
    $response = $client->request("POST", $url, [
        'form_params' => $body,
        'headers' => [
            "Content-Type" => "application/x-www-form-urlencoded"
        ],
    ]);

    return $response->getBody();
}

function akses_maja($url, $body)
{
    $client = \Config\Services::curlrequest();
    $idToken = '1';
    $model = new MajaModel();
    $tkn = $model->getToken($idToken);
    $token = $tkn[0];
    $refresh_token = $tkn[1];
    $tokenPart = explode('.', $token);
    $payload = $tokenPart[1];
    $decode = base64_decode($payload);
    $json = json_decode($decode, true);
    $exp = $json['exp'];
    $waktuSekarang = time();
    if ($exp <= $waktuSekarang) {
        $response = json_decode(requestToken(), true);
        $token = $response['access_token'];
        $refresh_token = $response['refresh_token'];
        $dataToken = [
            'id' => $idToken,
            'access_token' => $token,
            'refresh_token' => $refresh_token
        ];
        $model->save($dataToken);
    }

    $response = $client->setBody($body)->post($url, [
        "headers" => [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ]
    ]);

    return $response->getBody();
}
