<?php

/* 
This is Controller KeuBayarTotal
 */

namespace Modules\KeuBayarTotal\Controllers;

use App\Controllers\BaseController;
use Modules\KeuBayarTotal\Models\KeuBayarTotalModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;
use App\Models\ReferensiModel;

class KeuBayarTotal extends BaseController
{

    protected $keuBayarTotalModel;
    protected $tahunAjaranModel;
    protected $fakultasModel;
    protected $prodiModel;
    protected $referensiModel;
    protected $validation;
    public function __construct()
    {
        $this->keuBayarTotalModel = new KeuBayarTotalModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
        $this->referensiModel = new ReferensiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $ta = getTahunAjaranBerjalan()[0]->tahunAjaranId;
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Total Pembayaran",
            'breadcrumb' => ['Keuangan', 'Pembayaran', 'Total Pembayaran'],
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'bank' => $this->referensiModel->getBank()->getResult(),
            'pemb' => [],
            'filter' => [null, null, null],
            'ta' => $ta,
        ];
        return view('Modules\KeuBayarTotal\Views\keuBayarTotal', $data);
    }

    public function loadData()
    {
        $tahunAjaran = $this->request->getVar('tahunAjaran');
        $tahap = $this->request->getVar('tahap');
        $bank = $this->request->getVar('bank');
        $angkatan = [];
        for ($i = 2016; $i <= date("Y"); $i++) {
            array_push($angkatan, $i);
        }
        $filter = [$tahunAjaran, $tahap, $bank];
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Total Pembayaran",
            'breadcrumb' => ['Keuangan', 'Pembayaran', 'Total Pembayaran'],
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'bank' => $this->referensiModel->getBank()->getResult(),
            'prodi' => $this->prodiModel->getProdiForKrs()->findAll(),
            'angkatan' => $angkatan,
            'pemb' => $this->keuBayarTotalModel->getBayarTotal($filter)->getResult(),
            'filter' => $filter,
            'ta' =>  $tahunAjaran,
            'validation' => \Config\Services::validation(),
        ];

        $thnAjr = $this->tahunAjaranModel->getWhere(['tahunAjaranId' => $tahunAjaran])->getResult()[0]->tahunAjaranNama;
        $bnk = ($bank == 99) ? 'Semua' : $this->referensiModel->getBank(['bankId' => $bank])->getResult()[0]->bankKode;
        $session = [$thnAjr, $tahap, $bnk];
        session()->setFlashdata('keterangan', $session);
        return view('Modules\KeuBayarTotal\Views\keuBayarTotal', $data);
    }

    public function print()
    {
        dd($_POST);
    }
}
