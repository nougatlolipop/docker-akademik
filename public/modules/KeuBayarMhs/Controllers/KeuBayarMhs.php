<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuBayarMhs\Controllers;

use App\Controllers\BaseController;
use Modules\KeuBayarMhs\Models\KeuBayarMhsModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;

class KeuBayarMhs extends BaseController
{

    protected $validation;
    protected $tahunModel;
    protected $keuBayarMhs;

    public function __construct()
    {
        $this->keuBayarMhs = new KeuBayarMhsModel();
        $this->tahunModel = new TahunAjaranModel();
    }

    public function index()
    {
        $ta = date('Y');
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Pembayaran Mahasiswa",
            'breadcrumb' => ['Keuangan', 'Pembayaran', 'Pembayaran Mahasiswa'],
            'mhs' => [],
            'pemb' => [],
            'ta' => $ta,
            'thp' => '',
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KeuBayarMhs\Views\keuBayarMhs', $data);
    }

    public function loadData()
    {
        $mhs = $this->request->getVar('npm');
        $tahun = $this->request->getVar('tahun');
        $dtMhs = ['dt_mahasiswa."mahasiswaNpm"' => $mhs];
        $dtPemb = [$mhs, $tahun];
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Pembayaran Mahasiswa",
            'breadcrumb' => ['Keuangan', 'Pembayaran', 'Pembayaran Mahasiswa'],
            'mhs' => $this->keuBayarMhs->getDataMhs($dtMhs)->getResult(),
            'pemb' => $this->keuBayarMhs->getRiwayatPemb($dtPemb)->getResult(),
            'ta' => $tahun,
            'validation' => \Config\Services::validation(),
        ];

        session()->setFlashdata('keterangan', $mhs);
        return view('Modules\KeuBayarMhs\Views\keuBayarMhs', $data);
    }
}
