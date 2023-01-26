<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuSaving\Controllers;

use App\Controllers\BaseController;
use Modules\KeuSaving\Models\KeuSavingModel;


class KeuSaving extends BaseController
{

    protected $keuSavingModel;
    protected $validation;

    public function __construct()
    {
        $this->keuSavingModel = new KeuSavingModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Saldo Dompet (Saving)",
            'breadcrumb' => ['Keuangan', 'Saldo Dompet'],
            'mhs' => [],
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KeuSaving\Views\keuSaving', $data);
    }

    public function loadData()
    {
        $mhs = $this->request->getVar('npm');
        $dtMhs = ['dt_mahasiswa."mahasiswaNpm"' => $mhs];
        $dtSv = ['"savingMahasiswaNpm"' => $mhs];
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Saldo Dompet (Saving)",
            'mhs' => $this->keuSavingModel->getDataMhs($dtMhs)->getResult(),
            'sv' => $this->keuSavingModel->getDataSaving($dtSv)->getResult(),
            'breadcrumb' => ['Keuangan', 'Saldo Dompet'],
            'validation' => \Config\Services::validation(),
        ];
        session()->setFlashdata('keterangan', $mhs);
        return view('Modules\KeuSaving\Views\keuSaving', $data);
    }

    public function add()
    {
        $npm = $this->request->getVar('npm');
        $nominal = $this->request->getVar('nominal');
        $creator = user()->email;
        $where = [$npm, $nominal, $creator];
        $this->keuSavingModel->insertSaving($where);
        $url = $this->request->getServer('HTTP_REFERER');
        session()->setFlashdata('success', 'Saldo Dompet (Saving) Berhasil Ditambah!');
        return redirect()->to($url);
    }
}
