<?php

/* 
This is Controller FdrNilai
 */

namespace Modules\FdrNilai\Controllers;

use App\Controllers\BaseController;


class FdrNilai extends BaseController
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
            $nilai["filter"] = $textfilter[0];
            $nilai["act"] = "GetDetailNilaiPerkuliahanKelas";
            $nilai["order"] = "nama_semester ASC";
            $dataNilaiMhs = $this->dataNilai($apiInfo[0]->ippublic, $nilai);
        } else {
            $dataNilaiMhs = [];
        }

        $ta = [];
        foreach ($dataNilaiMhs as $key => $value) {
            $ta[] = $value->nama_semester;
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Nilai",
            'breadcrumb' => ['Feeder', 'Nilai'],
            'datanilai' => $dataNilaiMhs,
            'tahunAjar' => array_unique($ta)
        ];
        return view('Modules\FdrNilai\Views\fdrNilai', $data);
    }

    public function dataNilai($url, $body)
    {
        $response = akses_api('POST', $url, $body);
        return json_decode($response)->data;
    }
}
