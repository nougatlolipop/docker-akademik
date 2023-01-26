<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuTunggakanDetail\Controllers;

use App\Controllers\BaseController;
use Modules\KeuTunggakanDetail\Models\KeuTunggakanDetailModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;

class KeuTunggakanDetail extends BaseController
{

    protected $keuBayarFakultasModel;
    protected $tahunAjaranModel;
    protected $fakultasModel;
    protected $prodiModel;
    protected $validation;
    public function __construct()
    {
        $this->keuTunggakanDetailModel = new KeuTunggakanDetailModel();
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
            'title' => "Detail Tunggakan",
            'breadcrumb' => ['Keuangan', 'Tunggakan', 'Detail Tunggakan'],
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'tagihan' => [],
            'filter' => [null, null, null, null],
            'ta' => $ta,
            'validation' => \Config\Services::validation(),

        ];
        return view('Modules\KeuTunggakanDetail\Views\keuTunggakanDetail', $data);
    }

    public function loadData()
    {
        $tahunAjaran = $this->request->getVar('tahunAjaran');
        $fakultas = $this->request->getVar('fakultas');
        $angkatan = $this->request->getVar('angkatan');
        $tahap = $this->request->getVar('tahap');

        $filter = [$tahunAjaran, $fakultas, $angkatan, $tahap];
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Detail Tunggakan",
            'breadcrumb' => ['Keuangan', 'Tunggakan', 'Detail Tunggakan'],
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdiForKrs()->findAll(),
            'tagihan' => $this->keuTunggakanDetailModel->getTagihan($filter)->getResult(),
            'filter' => $filter,
            'ta' =>  $tahunAjaran,
            'validation' => \Config\Services::validation(),
        ];
        $thnAjr = $this->tahunAjaranModel->getWhere(['tahunAjaranId' => $tahunAjaran])->getResult()[0]->tahunAjaranNama;
        $fks = ($fakultas == 99) ? 'Semua' : $this->fakultasModel->getWhere(['fakultasId' => $fakultas])->getResult()[0]->fakultasNama;
        $session = [$thnAjr, $fks, $angkatan, $tahap];
        session()->setFlashdata('keterangan', $session);
        return view('Modules\KeuTunggakanDetail\Views\keuTunggakanDetail', $data);
    }

    public function print()
    {
        dd($_POST);
    }
}
