<?php

/* 
This is Controller Krs
 */

namespace Modules\FdrMahasiswa\Controllers;

use App\Controllers\BaseController;
use Modules\Prodi\Models\ProdiModel;
use Modules\Fakultas\Models\FakultasModel;


class FdrMahasiswa extends BaseController
{
    protected $prodiModel;
    protected $fakultasModel;

    public function __construct()
    {
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $apiInfo = getApiInfo();
        $sourceData = [];
        $filter = [];

        $prd = [
            "act" => "GetProdi",
            'filter' => "status='A'"
        ];
        $prodiPDDIKTI = $this->dataProdiPDDIKTI($apiInfo[0]->ippublic, $prd);

        if ($this->request->getVar('angMin')) {
            $sourceData['angkatan_min'] = $this->request->getVar('angMin');
            array_push($filter, ['type' => 'angMin', 'value' => 'Angkatan', 'id' => $this->request->getVar('angMin') . '1']);
        }

        if ($this->request->getVar('prodi')) {
            $prodi = explode(',', $this->request->getVar('prodi'));
            $sourceData['prodi'] = $prodi;
            foreach ($prodi as $prd) {
                foreach ($prodiPDDIKTI as $key => $p) {
                    if ($prd == $p->id_prodi) {
                        array_push($filter, ['type' => 'prodi', 'value' => $p->nama_program_studi, 'id' => $prd]);
                    }
                }
            }
        }

        if ($this->request->getVar('keyword')) {
            $sourceData['keyword'] = $this->request->getVar('keyword');
            array_push($filter, ['type' => 'keyword', 'value' => $this->request->getVar('keyword'), 'id' => $this->request->getVar('keyword')]);
        }

        if (count($filter) > 0) {
            $textfilter = generateFilter($filter);
            $mahasiswa["filter"] = $textfilter[0];
            $mahasiswa["act"] = "GetListMahasiswa";
            $mahasiswa["order"] = "id_periode, nim, nama_mahasiswa ASC";
            if ($textfilter[1]) {
                $mahasiswa["limit"] = $this->numberPage;
                session()->setFlashdata('limit', '<strong>Informasi !!!</strong> Data yang akan ditampilkan terlalu banyak, kami hanya menampilkan sebagian sebanyak <strong>' . $this->numberPage . ' Data</strong>. Silahkan tambahkan filter atau keyword');
            }
            $dataMhs = $this->dataMahasiswa($apiInfo[0]->ippublic, $mahasiswa);
        } else {
            $dataMhs = [];
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Mahasiswa",
            'breadcrumb' => ['Feeder', 'Mahasiswa'],
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdiForKrs()->findAll(),
            'prodipddikti' => $prodiPDDIKTI,
            'filter' => $filter,
            'mahasiswa' => $dataMhs
        ];
        // dd($data['prodipddikti']);
        return view('Modules\FdrMahasiswa\Views\fdrMahasiswa', $data);
    }

    public function dataMahasiswa($url, $body)
    {
        $response = akses_api('POST', $url, $body);
        return json_decode($response)->data;
    }

    public function dataProdiPDDIKTI($url, $body)
    {
        $response = akses_api('POST', $url, $body);
        return json_decode($response)->data;
    }

    public function dataDetail($url, $body)
    {
        $response = akses_api('POST', $url, $body);
        return json_decode($response)->data;
    }

    public function detail()
    {
        $apiInfo = getApiInfo();
        $idMhs = $this->request->getVar('id');

        $detailMahasiswa = [
            "act" => "GetBiodataMahasiswa",
            'filter' => "id_mahasiswa='{$idMhs}'"
        ];
        $detailMhs = $this->dataDetail($apiInfo[0]->ippublic, $detailMahasiswa);

        $detailPrestasi = [
            "act" => "GetListPrestasiMahasiswa",
            'filter' => "id_mahasiswa='{$idMhs}'"
        ];
        $detailPres = $this->dataDetail($apiInfo[0]->ippublic, $detailPrestasi);

        $detailPerkuliahan = [
            "act" => "GetAktivitasKuliahMahasiswa",
            'filter' => "id_mahasiswa='{$idMhs}'",
            'order' => "nama_semester ASC"
        ];
        $detailPerkuliah = $this->dataDetail($apiInfo[0]->ippublic, $detailPerkuliahan);
        echo json_encode([$detailMhs, $detailPres, $detailPerkuliah]);
    }
}
