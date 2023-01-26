<?php

/* 
This is Controller FdrTranskrip
 */

namespace Modules\FdrTranskrip\Controllers;

use App\Controllers\BaseController;


class FdrTranskrip extends BaseController
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
            $transkrip["filter"] = $textfilter[0];
            $transkrip["act"] = "GetDetailNilaiPerkuliahanKelas";
            $transkrip["order"] = "nama_semester ASC";
            $dataTranskripMhs = $this->dataTranskrip($apiInfo[0]->ippublic, $transkrip);
        } else {
            $dataTranskripMhs = [];
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Transkrip",
            'breadcrumb' => ['Feeder', 'Transkrip'],
            'datatranskrip' => $dataTranskripMhs
        ];
        // dd($data['datatranskrip']);
        return view('Modules\FdrTranskrip\Views\fdrTranskrip', $data);
    }

    public function dataTranskrip($url, $body)
    {
        $response = akses_api('POST', $url, $body);
        return json_decode($response)->data;
    }


    public function getTranskrip()
    {
        $apiInfo = getApiInfo();
        $idRegMhs = $this->request->getVar('id');

        $detailMahasiswa = [
            "act" => "GetDetailNilaiPerkuliahanKelas",
            'filter' => "id_registrasi_mahasiswa='{$idRegMhs}'"
        ];
        $detailMhs = $this->dataTranskrip($apiInfo[0]->ippublic, $detailMahasiswa);
        echo json_encode($detailMhs);
    }
}
