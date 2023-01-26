<?php

/* 
This is Controller Konversi
 */

namespace Modules\Konversi\Controllers;

use App\Controllers\BaseController;
use Modules\Nilai\Models\NilaiModel;
use Modules\Konversi\Models\KonversiModel;

class Konversi extends BaseController
{
    protected $nilaiModel;
    protected $konversiModel;

    public function __construct()
    {
        $this->konversiModel = new KonversiModel();
        $this->nilaiModel = new NilaiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Transfer",
            'breadcrumb' => ['Akademik', 'Konversi Nilai', 'Transfer'],
            'nilai' => $this->nilaiModel->getNilai()->findAll(),
        ];
        return view('Modules\Konversi\Views\konversi', $data);
    }

    public function add()
    {
        // dd($_POST);
        $matkulLama = [];
        $matkulkonversi = [];

        $kode = $this->request->getVar('kode');
        $nama = $this->request->getVar('nama');
        $sksampu = $this->request->getVar('sks');
        $nilaiLama = $this->request->getVar('nilai');
        $matkulKonversi = $this->request->getVar('mkKonversiSave');
        $nilaiSave = $this->request->getVar('nilaiSave');
        $npmMahasiswa = $this->request->getVar('npmKonversi');
        $thAjar = getTahunAjaranAktif($npmMahasiswa, 'nilai')[0];

        for ($i = 0; $i < count($kode); $i++) {
            $data = [
                'id' => $i + 1,
                'matkulKode' => $kode[$i],
                'matkulNama' => $nama[$i],
                'sks' => $sksampu[$i],
                'nilai' => $nilaiLama[$i],
                'matkulIdBaru' => (int)$matkulKonversi[$i],
            ];

            $sks = getMatkul($matkulKonversi[$i])[0];
            $nilai = getNilaiAngka([$thAjar->prodiId, $nilaiSave[$i]])[0];
            $dataKonversi = [
                'matkulId' => (int)$matkulKonversi[$i],
                'gradeId' => (int)$nilaiSave[$i],
                'status' => 1,
                'nilai' => (float)$nilai->gradeProdiNilaiBobot,
                'totalNilai' => (float)$nilai->gradeProdiNilaiBobot * (int)$sks->setMatkulKurikulumSks,

            ];
            array_push($matkulLama, $data);
            array_push($matkulkonversi, $dataKonversi);
        }
        $thnAjar = getTahunAjaranAktif($npmMahasiswa, 'krs')[0];

        $dataSave = [
            'konversiNilaiMahasiswaNpm' => $npmMahasiswa,
            'konversiNilaiTahunAjaranId' => $thnAjar->setJadwalAkademikTahunAjaranId,
            'konversiNilaiMatkulOld' => json_encode(["data" => $matkulLama]),
            'konversiNilaiMatkulNew' => json_encode(["data" => $matkulkonversi]),
            'konversiNilaiJenisKonversiId' => 1,
            'konversiNilaiCreatedBy' => user()->email,
        ];

        $dataSession = [
            'matkulkonversi' => $matkulkonversi,
            'npm' => $npmMahasiswa,
            'prodi' => $thnAjar->prodiId,
            'dataSave' => $dataSave,
        ];

        if (count($dataSave) > 0) {
            session()->set('dataSession', $dataSession);
            session()->setFlashdata('success', 'Data Konversi Berhasil Disinkronsisasi (Belum Tersimpan)!');
            return redirect()->to('/konversi');
        }
    }

    public function clearSync()
    {
        session()->remove('dataSession');
        session()->setFlashdata('success', 'Pembatalan Berhasil!');
        return redirect()->to('/konversi');
    }

    public function proses()
    {
        if ($this->konversiModel->insert(session()->get('dataSession')['dataSave'])) {
            session()->remove('dataSession');
            session()->setFlashdata('success', 'Data Konversi Berhasil Disimpan!');
            return redirect()->to('/konversi');
        }
    }
}
