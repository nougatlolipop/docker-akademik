<?php

/* 
This is Controller KelompokKuliah
 */

namespace Modules\KelompokKuliah\Controllers;

use App\Controllers\BaseController;
use Modules\KelompokKuliah\Models\KelompokKuliahModel;


class KelompokKuliah extends BaseController
{
    protected $kelompokKuliahModel;
    protected $validation;

    public function __construct()
    {
        $this->kelompokKuliahModel = new KelompokKuliahModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_kelompokKuliah') ? $this->request->getVar('page_kelompokKuliah') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $kelompokKuliah = $this->kelompokKuliahModel->getKelompokKuliahSearch($keyword);
        } else {
            $kelompokKuliah = $this->kelompokKuliahModel->getKelompokKuliah();
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Kelompok Kuliah",
            'breadcrumb' => ['Data', 'Kelompok Kuliah'],
            'kelompokKuliah' => $kelompokKuliah->paginate($this->numberPage, 'kelompokKuliah'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->kelompokKuliahModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KelompokKuliah\Views\kelompokKuliah', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kelompokKuliahKode' => rv('required', ['required' => 'Kode Kelompok Kuliah harus diisi!']),
            'kelompokKuliahNama' => rv('required', ['required' => 'Nama Kelompok Kuliah harus diisi!']),
            'kelompokKuliahDeskripsi' => rv('required', ['required' => 'Deskripsi Kelompok Kuliah harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'kelompokKuliahKode' => $this->request->getVar('kelompokKuliahKode'),
            'kelompokKuliahNama' => $this->request->getVar('kelompokKuliahNama'),
            'kelompokKuliahDeskripsi' => $this->request->getVar('kelompokKuliahDeskripsi'),
            'kelompokKuliahCreatedBy' => user()->email,
        );

        if ($this->kelompokKuliahModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kelompok Kuliah Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kelompokKuliahKode' => rv('required', ['required' => 'Kode Kelompok Kuliah harus diisi']),
            'kelompokKuliahNama' => rv('required', ['required' => 'Nama Kelompok Kuliah harus diisi']),
            'kelompokKuliahDeskripsi' => rv('required', ['required' => 'Deskripsi Kelompok Kuliah harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'kelompokKuliahKode' => $this->request->getVar('kelompokKuliahKode'),
            'kelompokKuliahNama' => $this->request->getVar('kelompokKuliahNama'),
            'kelompokKuliahDeskripsi' => $this->request->getVar('kelompokKuliahDeskripsi'),
            'kelompokKuliahModifiedBy' => user()->email,
        );

        if ($this->kelompokKuliahModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kelompok Kuliah Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->kelompokKuliahModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kelompok Kuliah Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
