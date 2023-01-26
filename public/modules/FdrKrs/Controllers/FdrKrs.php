<?php

/* 
This is Controller FdrKrs
 */

namespace Modules\FdrKrs\Controllers;

use App\Controllers\BaseController;


class FdrKrs extends BaseController
{
    public function index()
    {
        $apiInfo = getApiInfo();
        $sourceData = [];
        $filter = [];

        if ($this->request->getVar('keyword')) {
            $sourceData['keyword'] = $this->request->getVar('keyword');
            array_push($filter, ['type' => 'keyword', 'value' => $this->request->getVar('keyword'), 'id' => $this->request->getVar('keyword')]);
        }

        if (count($filter) > 0) {
            $textfilter = generateFilter($filter);
            $krs["filter"] = $textfilter[0];
            $krs["act"] = "GetRekapKRSMahasiswa";
            $krs["order"] = "nama_periode ASC";
            $dataKrsMhs = $this->dataKrs($apiInfo[0]->ippublic, $krs);
        } else {
            $dataKrsMhs = [];
        }

        $ta = [];
        foreach ($dataKrsMhs as $key => $value) {
            $ta[] = $value->nama_periode;
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "KRS",
            'breadcrumb' => ['Feeder', 'KRS'],
            'datakrs' => $dataKrsMhs,
            'tahunAjar' => array_unique($ta)
        ];
        // dd($data['datakrs']);
        return view('Modules\FdrKrs\Views\fdrKrs', $data);
    }

    public function dataKrs($url, $body)
    {
        $response = akses_api('POST', $url, $body);
        return json_decode($response)->data;
    }
}
