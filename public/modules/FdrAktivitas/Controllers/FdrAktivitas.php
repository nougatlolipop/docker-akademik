<?php

/* 
This is Controller FdrAktivitas
 */

namespace Modules\FdrAktivitas\Controllers;

use App\Controllers\BaseController;


class FdrAktivitas extends BaseController
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
            $aktivitas["filter"] = $textfilter[0];
            $aktivitas["act"] = "GetListAnggotaAktivitasMahasiswa";
            $aktivitas["order"] = "nim ASC";
            $dataAktivitasMhs = $this->dataAktivitas($apiInfo[0]->ippublic, $aktivitas);
        } else {
            $dataAktivitasMhs = [];
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Aktivitas",
            'breadcrumb' => ['Feeder', 'Aktivitas'],
            'dataaktivitas' => $dataAktivitasMhs
        ];
        // dd($data['dataaktivitas']);
        return view('Modules\FdrAktivitas\Views\fdrAktivitas', $data);
    }

    public function dataAktivitas($url, $body)
    {
        $response = akses_api('POST', $url, $body);
        return json_decode($response)->data;
    }

    public function detail()
    {
        $apiInfo = getApiInfo();
        $idAkt = $this->request->getVar('id');

        $detailAktivitas = [
            "act" => "GetListAktivitasMahasiswa",
            'filter' => "id_aktivitas='{$idAkt}'"
        ];
        $detailAkt = $this->dataAktivitas($apiInfo[0]->ippublic, $detailAktivitas);

        $detailPembimbing = [
            "act" => "GetListBimbingMahasiswa",
            'filter' => "id_aktivitas='{$idAkt}'"
        ];
        $detailPembimbing = $this->dataAktivitas($apiInfo[0]->ippublic, $detailPembimbing);
        echo json_encode([$detailPembimbing, $detailAkt]);
    }
}
