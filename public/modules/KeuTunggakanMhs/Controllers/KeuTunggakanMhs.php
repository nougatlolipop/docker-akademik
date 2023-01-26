<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuTunggakanMhs\Controllers;

use App\Controllers\BaseController;
use Modules\KeuTunggakanMhs\Models\KeuTunggakanMhsModel;

class KeuTunggakanMhs extends BaseController
{

    protected $validation;
    protected $keuTunggakanMhs;

    public function __construct()
    {
        $this->keuTunggakanMhs = new KeuTunggakanMhsModel();
    }

    public function index()
    {
        $ta = date('Y');
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Tunggakan Mahasiswa",
            'breadcrumb' => ['Keuangan', 'Tunggakan', 'Tunggakan Mahasiswa'],
            'mhs' => [],
            'tunggak' => [],
            'ta' => $ta,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KeuTunggakanMhs\Views\keuTunggakanMhs', $data);
    }

    public function loadData()
    {
        $mhs = $this->request->getVar('npm');
        $tahun = $this->request->getVar('tahun');
        $dtMhs = ['dt_mahasiswa."mahasiswaNpm"' => $mhs];
        $dtTunggak = [$mhs, $tahun];
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Tunggakan Mahasiswa",
            'breadcrumb' => ['Keuangan', 'Tunggakan', 'Tunggakan Mahasiswa'],
            'mhs' => $this->keuTunggakanMhs->getDataMhs($dtMhs)->getResult(),
            'tunggak' => $this->keuTunggakanMhs->getTunggakanMhs($dtTunggak)->getResult(),
            'ta' =>  $tahun,
            'validation' => \Config\Services::validation(),
        ];
        session()->setFlashdata('keterangan', $mhs);
        return view('Modules\KeuTunggakanMhs\Views\keuTunggakanMhs', $data);
    }
}
