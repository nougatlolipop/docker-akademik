<?php

use \Modules\Token\Models\TokenModel;

function getApiInfo()
{
    $model = new Modules\SettingApi\Models\SettingApiModel;
    $result = $model->findAll();
    return $result;
}

function getTokenFromApi()
{
    $apiInfo = getApiInfo();
    $body = [
        "act" => "GetToken",
        "username" => $apiInfo[0]->user,
        "password" => $apiInfo[0]->pass
    ];
    $response = service('curlrequest')->request("POST", $apiInfo[0]->ippublic, [
        'form_params' => $body,
        "headers" => [
            "Accept" => "application/json"
        ],
    ]);

    return $response->getBody();
}

function akses_api($method, $url, $body)
{
    $client = \Config\Services::curlrequest();
    $idToken = '1';
    $model = new TokenModel();
    $token = $model->getToken($idToken);
    $tokenPart = explode('.', $token);
    $payload = $tokenPart[1];
    $decode = base64_decode($payload);
    $json = json_decode($decode, true);
    $exp = $json['exp'];
    $waktuSekarang = time();
    if ($exp <= $waktuSekarang) {
        $response = json_decode(getTokenFromApi(), true);
        $token = $response['data']['token'];
        $dataToken = [
            'id' => $idToken,
            'token' => $token
        ];
        $model->save($dataToken);
    }
    $body['token'] = $token;
    $response = $client->request($method, $url, [
        'form_params' => $body,
        "headers" => [
            "Accept" => "application/json"
        ]
    ]);

    return $response->getBody();
}

function getIdProdiPDDIKTI($nama, $jenjang, $data)
{
    $result = '';
    foreach ($data as $key => $dt) {
        if (trim(strtolower($dt->nama_program_studi)) == trim(strtolower($nama)) && trim(strtolower($jenjang)) == trim(strtolower($dt->nama_jenjang_pendidikan))) {
            $result = $dt->id_prodi;
        }
    }
    return $result;
}

function generateFilter($filter)
{
    $textfilter = '';
    $filterdata = [];
    $angkatan = false;
    foreach ($filter as $key => $fil) {
        if ($fil['type'] == 'angMin') {
            $filterdata[] = [
                "type" => "filter",
                "key" => "id_periode",
                "val" => $fil['id']
            ];
        }

        if ($fil['type'] == 'prodi') {
            $filterdata[] = [
                "type" => "filter",
                "key" => "id_prodi",
                "val" => $fil['id']
            ];
        }

        if ($fil['type'] == 'keyword') {
            $filterdata[] = [
                "type" => "keyword",
                "key" => "nim",
                "val" => $fil['id']
            ];
            $filterdata[] = [
                "type" => "keyword",
                "key" => "nama_mahasiswa",
                "val" => $fil['id']
            ];
        }
    }
    $keywordData = [];
    $filterData = [];
    foreach ($filterdata as $key => $value) {
        if ($value['type'] == 'keyword') {
            $keywordData[] = ['key' => $value['key'], 'val' => $value['val']];
        }
        if ($value['type'] == 'filter') {
            $filterData[] = ['key' => $value['key'], 'val' => $value['val']];
        }
    }

    if (count($keywordData) > 0) {
        foreach ($keywordData as $idxkey => $keyData) {
            if (count($filterData) > 0) {
                foreach ($filterData as $idxfil => $filData) {
                    $textfilter .= "{$filData['key']}='{$filData['val']}'";
                    $textfilter .= " AND ";
                }
            }

            $textfilter .= "{$keyData['key']} LIKE '%{$keyData['val']}%'";
            if ($idxkey + 1 < count($keywordData)) {
                $textfilter .= " OR ";
            }
        }
    } else {
        if (count($filterData) > 0) {
            foreach ($filterData as $idxfil => $filData) {
                $textfilter .= "{$filData['key']}='{$filData['val']}'";
                if ($idxfil + 1 < count($filterData)) {
                    $textfilter .= " AND ";
                }
            }
        }
    }
    if (count($filterData) < 2 && count($keywordData) == 0) {
        $angkatan = true;
    }

    return [$textfilter, $angkatan];
}
