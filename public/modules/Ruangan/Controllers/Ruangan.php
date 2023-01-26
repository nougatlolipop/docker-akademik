<?php

/* 
This is Controller Ruangan
 */

namespace Modules\Ruangan\Controllers;

use App\Controllers\BaseController;
use Modules\Ruangan\Models\RuanganModel;
use Modules\KelompokKuliah\Models\KelompokKuliahModel;


class Ruangan extends BaseController
{
    protected $ruanganModel;
    protected $kelompokKuliahModel;
    protected $validation;

    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
        $this->kelompokKuliahModel = new KelompokKuliahModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_ruangan') ? $this->request->getVar('page_ruangan') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $ruangan = $this->ruanganModel->getRuanganSearch($keyword);
        } else {
            $ruangan = $this->ruanganModel->getRuangan();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Ruang Kuliah",
            'breadcrumb' => ['Data', 'Ruang Kuliah'],
            'ruangan' => $ruangan->paginate($this->numberPage, 'ruangan'),
            'gedung' => $this->ruanganModel->getGedung(),
            'kelompok' => $this->kelompokKuliahModel->findAll(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->ruanganModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Ruangan\Views\ruangan', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'ruanganKode' => rv('required', ['required' => 'Kode ruang kuliah harus diisi!']),
            'ruanganNama' => rv('required', ['required' => 'Nama ruang kuliah harus diisi!']),
            'ruanganGedungId' => rv('required', ['required' => 'Gedung ruang kuliah harus dipilih!']),
            'ruanganKelompokId' => rv('required', ['required' => 'Kelompok kuliah harus dipilih!']),
            'ruanganDeskripsi' => rv('required', ['required' => 'Deskripsi ruang kuliah harus diisi!']),
            'ruanganKapasitas' => rv('required', ['required' => 'Kapasitas ruang kuliah harus diisi!']),
            'ruanganAkronim' => rv('required', ['required' => 'Akronim ruang kuliah harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'ruangKode' => trim($this->request->getVar('ruanganKode')),
            'ruangNama' => trim($this->request->getVar('ruanganNama')),
            'ruangGedungId' => trim($this->request->getVar('ruanganGedungId')),
            'ruangKelompokId' => trim($this->request->getVar('ruanganKelompokId')),
            'ruangDeskripsi' => trim($this->request->getVar('ruanganDeskripsi')),
            'ruangKapasitas' => trim($this->request->getVar('ruanganKapasitas')),
            'ruangAkronim' => trim($this->request->getVar('ruanganAkronim')),
            'ruangIsAktif' => trim($this->request->getVar('ruanganIsAktif')) == null ? 0 : 1,
            'ruangCreatedBy' => user()->email,
        );
        if ($this->ruanganModel->insert($data)) {
            session()->setFlashdata('success', 'Data Ruang kuliah Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'ruanganKode' => rv('required', ['required' => 'Kode ruang kuliah harus diisi!']),
            'ruanganNama' => rv('required', ['required' => 'Nama ruang kuliah harus diisi!']),
            'ruanganGedungId' => rv('required', ['required' => 'Gedung ruang kuliah harus dipilih!']),
            'ruanganKelompokId' => rv('required', ['required' => 'Kelompok kuliah harus dipilih!']),
            'ruanganDeskripsi' => rv('required', ['required' => 'Deskripsi ruang kuliah harus diisi!']),
            'ruanganKapasitas' => rv('required', ['required' => 'Kapasitas ruang kuliah harus diisi!']),
            'ruanganAkronim' => rv('required', ['required' => 'Akronim ruang kuliah harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'ruangKode' => trim($this->request->getVar('ruanganKode')),
            'ruangNama' => trim($this->request->getVar('ruanganNama')),
            'ruangGedungId' => trim($this->request->getVar('ruanganGedungId')),
            'ruangKelompokId' => trim($this->request->getVar('ruanganKelompokId')),
            'ruangDeskripsi' => trim($this->request->getVar('ruanganDeskripsi')),
            'ruangKapasitas' => trim($this->request->getVar('ruanganKapasitas')),
            'ruangAkronim' => trim($this->request->getVar('ruanganAkronim')),
            'ruangIsAktif' => trim($this->request->getVar('ruanganIsAktif')) == null ? 0 : 1,
            'ruangModifiedBy' => user()->email,
        );

        if ($this->ruanganModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Ruang Kuliah Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->ruanganModel->delete($id)) {
            session()->setFlashdata('success', 'Data Ruang Kuliah Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
