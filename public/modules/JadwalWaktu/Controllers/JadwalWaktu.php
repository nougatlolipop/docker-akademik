<?php

/* 
This is Controller JadwalWaktu
 */

namespace Modules\JadwalWaktu\Controllers;

use App\Controllers\BaseController;
use Modules\JadwalWaktu\Models\JadwalWaktuModel;
use Modules\KelompokKuliah\Models\KelompokKuliahModel;
use App\Models\ReferensiModel;


class JadwalWaktu extends BaseController
{
    protected $jadwalWaktuModel;
    protected $kelompokKuliahModel;
    protected $referensiModel;
    protected $validation;

    public function __construct()
    {
        $this->jadwalWaktuModel = new JadwalWaktuModel();
        $this->kelompokKuliahModel = new KelompokKuliahModel();
        $this->referensiModel = new ReferensiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_jadwalWaktu') ? $this->request->getVar('page_jadwalWaktu') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $jadwalWaktu = $this->jadwalWaktuModel->getJadwalWaktuSearch($keyword);
        } else {
            $jadwalWaktu = $this->jadwalWaktuModel->getJadwalWaktu();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jadwal Waktu Kuliah",
            'breadcrumb' => ['Data', 'Jadwal Waktu Kuliah'],
            'jadwalWaktu' => $jadwalWaktu->paginate($this->numberPage, 'jadwalWaktu'),
            'kelompokKuliah' => $this->kelompokKuliahModel->getKelompokKuliah()->findAll(),
            'hari' => $this->referensiModel->getHari()->getResult(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->jadwalWaktuModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\JadwalWaktu\Views\jadwalWaktu', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'jadwalKuliahKelompokId' => rv('required', ['required' => 'Kelompok kuliah harus dipilih!']),
            'jadwalKuliahHariId' => rv('required', ['required' => 'Hari harus dipilih!']),
            'jadwalKuliahDeskripsi' => rv('required', ['required' => 'Deskripsi harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        foreach ($this->request->getVar('jadwalKuliahKelompokId') as $kelompokKuliah) {
            foreach ($this->request->getVar('jadwalKuliahHariId') as $hari) {
                $data = array(
                    'jadwalKuliahKelompokId' => $kelompokKuliah,
                    'jadwalKuliahHariId' => $hari,
                    'jadwalKuliahMulai' => $this->request->getVar('jadwalKuliahMulai'),
                    'jadwalKuliahSelesai' => $this->request->getVar('jadwalKuliahSelesai'),
                    'jadwalKuliahDeskripsi' => $this->request->getVar('jadwalKuliahDeskripsi'),
                    'jadwalKuliahCreatedBy' => user()->email,
                );
                if ($this->jadwalWaktuModel->insert($data)) {
                    session()->setFlashdata('success', 'Data Jadwal Waktu Kuliah Berhasil Ditambahkan!');
                }
            }
        }

        return  redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'jadwalKuliahKelompokId' => rv('required', ['required' => 'Kelompok kuliah harus dipilih!']),
            'jadwalKuliahHariId' => rv('required', ['required' => 'Hari harus dipilih!']),
            'jadwalKuliahDeskripsi' => rv('required', ['required' => 'Deskripsi harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'jadwalKuliahKelompokId' => $this->request->getVar('jadwalKuliahKelompokId'),
            'jadwalKuliahHariId' => $this->request->getVar('jadwalKuliahHariId'),
            'jadwalKuliahMulai' => $this->request->getVar('jadwalKuliahMulai'),
            'jadwalKuliahSelesai' => $this->request->getVar('jadwalKuliahSelesai'),
            'jadwalKuliahDeskripsi' => $this->request->getVar('jadwalKuliahDeskripsi'),
            'jadwalKulihModifiedBy' => user()->email,
        );

        if ($this->jadwalWaktuModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Jadwal Waktu Kuliah Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->jadwalWaktuModel->delete($id)) {
            session()->setFlashdata('success', 'Data Jadwal Waktu Kuliah Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
