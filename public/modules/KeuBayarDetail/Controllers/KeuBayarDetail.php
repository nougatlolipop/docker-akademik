<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuBayarDetail\Controllers;

use App\Controllers\BaseController;
use Modules\KeuBayarDetail\Models\KeuBayarDetailModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;
use App\Models\ReferensiModel;

class KeuBayarDetail extends BaseController
{

    protected $keuBayarDetailModel;
    protected $tahunAjaranModel;
    protected $fakultasModel;
    protected $prodiModel;
    protected $referensiModel;
    protected $validation;
    public function __construct()
    {
        $this->keuBayarDetailModel = new KeuBayarDetailModel();
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
            'title' => "Detail Pembayaran",
            'breadcrumb' => ['Keuangan', 'Pembayaran', 'Detail Pembayaran'],
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'bank' => $this->referensiModel->getBank()->getResult(),
            'pemb' => [],
            'ta' => $ta,
            'filter' => [null, null, null, null, null],
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KeuBayarDetail\Views\keuBayarDetail', $data);
    }

    public function loadData()
    {
        $tahunAjaran = $this->request->getVar('tahunAjaran');
        $fakultas = $this->request->getVar('fakultas');
        $angkatan = $this->request->getVar('angkatan');
        $tahap = $this->request->getVar('tahap');
        $bank = $this->request->getVar('bank');

        if ($fakultas == 99 && $angkatan == 99 && $tahap == 99 && $bank == 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran];
        } elseif ($fakultas != 99 && $angkatan == 99 && $tahap == 99 && $bank == 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"fakultasId"' => $fakultas];
        } elseif ($fakultas != 99 && $angkatan != 99 && $tahap == 99 && $bank == 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"fakultasId"' => $fakultas, '"mahasiswaAngkatan"' => $angkatan];
        } elseif ($fakultas != 99 && $angkatan != 99 && $tahap != 99 && $bank == 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"fakultasId"' => $fakultas, '"mahasiswaAngkatan"' => $angkatan, '"tahap"' => $tahap];
        } elseif ($fakultas == 99 && $angkatan != 99 && $tahap == 99 && $bank == 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"mahasiswaAngkatan"' => $angkatan];
        } elseif ($fakultas == 99 && $angkatan == 99 && $tahap != 99 && $bank == 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"tahap"' => $tahap];
        } elseif ($fakultas == 99 && $angkatan == 99 && $tahap == 99 && $bank != 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"bankId"' => $bank];
        } elseif ($fakultas != 99 && $angkatan == 99 && $tahap != 99 && $bank == 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"fakultasId"' => $fakultas, '"tahap"' => $tahap];
        } elseif ($fakultas != 99 && $angkatan == 99 && $tahap == 99 && $bank != 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"fakultasId"' => $fakultas, '"bankId"' => $bank];
        } elseif ($fakultas == 99 && $angkatan != 99 && $tahap != 99 && $bank == 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"mahasiswaAngkatan"' => $angkatan, '"tahap"' => $tahap];
        } elseif ($fakultas == 99 && $angkatan != 99 && $tahap == 99 && $bank != 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"mahasiswaAngkatan"' => $angkatan, '"bankId"' => $bank];
        } elseif ($fakultas == 99 && $angkatan == 99 && $tahap != 99 && $bank != 99) {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"tahap"' => $tahap, '"bankId"' => $bank];
        } else {
            $filter = ['"tahunAjarId"' => $tahunAjaran, '"fakultasId"' => $fakultas, '"mahasiswaAngkatan"' => $angkatan, '"tahap"' => $tahap, '"bankId"' => $bank];
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Detail Pembayaran",
            'breadcrumb' => ['Keuangan', 'Pembayaran', 'Detail Pembayaran'],
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'bank' => $this->referensiModel->getBank()->getResult(),
            'prodi' => $this->prodiModel->getProdiForKrs()->findAll(),
            'pemb' => $this->keuBayarDetailModel->getBayarDetail($filter)->getResult(),
            'fk' => $fakultas,
            'ta' =>  $tahunAjaran,
            'filter' => [$tahunAjaran, $fakultas, $angkatan, $tahap, $bank],
            'validation' => \Config\Services::validation(),
        ];

        $thnAjr = $this->tahunAjaranModel->getWhere(['tahunAjaranId' => $tahunAjaran])->getResult()[0]->tahunAjaranNama;
        $fks = ($fakultas == 99) ? 'Semua' : $this->fakultasModel->getWhere(['fakultasId' => $fakultas])->getResult()[0]->fakultasNama;
        $bnk = ($bank == 99) ? 'Semua' : $this->referensiModel->getBank(['bankId' => $bank])->getResult()[0]->bankKode;
        $session = [$thnAjr, $fks, $angkatan, $tahap, $bnk];
        session()->setFlashdata('keterangan', $session);
        return view('Modules\KeuBayarDetail\Views\keuBayarDetail', $data);
    }

    public function print()
    {
        dd($_POST);
    }
}
