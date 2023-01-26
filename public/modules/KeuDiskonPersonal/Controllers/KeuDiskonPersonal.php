<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuDiskonPersonal\Controllers;

use App\Controllers\BaseController;
use Modules\KeuDiskonPersonal\Models\KeuDiskonPersonalModel;
use Modules\JenisBiaya\Models\JenisBiayaModel;

class KeuDiskonPersonal extends BaseController
{

    protected $keuDiskonPersonal;
    protected $jenisBiayaModel;
    protected $validation;

    public function __construct()
    {
        $this->keuDiskonPersonal = new KeuDiskonPersonalModel();
        $this->jenisBiayaModel = new JenisBiayaModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Diskon Personal",
            'breadcrumb' => ['Keuangan', 'Setting', 'Diskon Personal'],
            'mhs' => [],
            'tagihan' => $this->jenisBiayaModel->jenisTagihan('pokok')->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KeuDiskonPersonal\Views\KeuDiskonPersonal', $data);
    }

    public function loadData()
    {
        $mhs = $this->request->getVar('npm');
        $tahunAjaran = getTahunAjaranAktif($mhs, 'krs');
        $dtMhs = ['dt_mahasiswa."mahasiswaNpm"' => $mhs];
        if (count($tahunAjaran) >= 1) {
            $dtTgh = [$mhs, $tahunAjaran[0]->tahunAjaranKode];
        } else {
            $dtTgh = [$mhs, null];
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Diskon Personal",
            'breadcrumb' => ['Keuangan', 'Setting', 'Diskon Personal'],
            'mhs' => $this->keuDiskonPersonal->getDataMhs($dtMhs)->getResult(),
            'tgh' => $this->keuDiskonPersonal->getDataTgh($dtTgh)->getResult(),
            'tagihan' => $this->jenisBiayaModel->jenisTagihan('pokok')->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        session()->setFlashdata('keterangan', $mhs);
        return view('Modules\KeuDiskonPersonal\Views\KeuDiskonPersonal', $data);
    }

    public function setting()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'tagihPersonalTahun' => rv('required', ['required' => 'Tahun tagihan harus dipilih!']),
            'tagihPersonalJenisBiayaId' => rv('required', ['required' => 'Nama tagihan harus dipilih!']),
            'tagihPersonalTahapLunas' => rv('required', ['required' => 'Jenis pembayaran harus dipilih!']),
            'tagihPersonalDiskonPersentase' => rv('required', ['required' => 'Persentase diskon harus diisi!']),
            'tagihPersonalKeterangan' => rv('required', ['required' => 'Keterangan harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $tagihan = explode(",", $this->request->getvar('tagihPersonalJenisBiayaId'));
        $tahap = $this->request->getVar('tagihPersonalTahapLunas');
        $jmlThp = ($tahap == 0) ? $tahap : $this->request->getVar('jenisTahap');
        $mhs = $this->request->getVar('npm');

        foreach ($tagihan as $tgh) {
            $data = array(
                'tagihPersonalMahasiswaNpm' => $this->request->getVar('tagihPersonalMahasiswaNpm'),
                'tagihPersonalJenisBiayaId' => $tgh,
                'tagihPersonalTahun' => $this->request->getVar('tagihPersonalTahun'),
                'tagihPersonalTahapLunas' => $jmlThp,
                'tagihPersonalDiskonPersentase' => $this->request->getVar('tagihPersonalDiskonPersentase'),
                'tagihPersonalKeterangan' => $this->request->getVar('tagihPersonalKeterangan'),
                'tagihPersonalCreatedBy' => user()->email,
            );
            if ($this->keuDiskonPersonal->insert($data)) {
                session()->setFlashdata('success', 'Diskon Personal <strong>' . $mhs . '</strong> Berhasil Disetting!');
            }
        }
        return redirect()->to($url);
    }
}
