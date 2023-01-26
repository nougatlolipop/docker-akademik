<?php

/* 
This is Controller KeuTunggakanTotal
 */

namespace Modules\KeuTunggakanTotal\Controllers;

use App\Controllers\BaseController;
use Modules\KeuTunggakanTotal\Models\KeuTunggakanTotalModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;


class KeuTunggakanTotal extends BaseController
{

    protected $keuTunggakanTotalModel;
    protected $tahunAjaranModel;
    protected $fakultasModel;
    protected $prodiModel;
    protected $validation;
    public function __construct()
    {
        $this->keuTunggakanTotalModel = new KeuTunggakanTotalModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $ta = getTahunAjaranBerjalan()[0]->tahunAjaranId;
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Total Tunggakan",
            'breadcrumb' => ['Keuangan', 'Tunggakan', 'Total Tunggakan'],
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'tagihan' => [],
            'filter' => [null, null],
            'ta' => $ta,
        ];
        return view('Modules\KeuTunggakanTotal\Views\keuTunggakanTotal', $data);
    }

    public function loadData()
    {
        $tahunAjaran = $this->request->getVar('tahunAjaran');
        $tahap = $this->request->getVar('tahap');
        $angkatan = [];
        for ($i = 2016; $i <= date("Y"); $i++) {
            array_push($angkatan, $i);
        }
        $filter = [$tahunAjaran, $tahap];
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Total Tunggakan",
            'breadcrumb' => ['Keuangan', 'Tunggakan', 'Total Tunggakan'],
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdiForKrs()->findAll(),
            'angkatan' => $angkatan,
            'tagihan' => $this->keuTunggakanTotalModel->getTagihanTotal($filter)->getResult(),
            'filter' => $filter,
            'ta' =>  $tahunAjaran,
            'validation' => \Config\Services::validation(),
        ];

        $thnAjr = $this->tahunAjaranModel->getWhere(['tahunAjaranId' => $tahunAjaran])->getResult()[0]->tahunAjaranNama;
        $session = [$thnAjr, $tahap];
        session()->setFlashdata('keterangan', $session);
        return view('Modules\KeuTunggakanTotal\Views\keuTunggakanTotal', $data);
    }

    public function print()
    {
        dd($_POST);
    }
}
