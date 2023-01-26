<?php

/* 
This is Controller WaktuKuliah
 */

namespace Modules\WaktuKuliah\Controllers;

use App\Controllers\BaseController;
use Modules\WaktuKuliah\Models\WaktuKuliahModel;


class WaktuKuliah extends BaseController
{
    protected $waktuModel;
    protected $validation;

    public function __construct()
    {
        $this->waktuModel = new WaktuKuliahModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_waktu') ? $this->request->getVar('page_waktu') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $waktu = $this->waktuModel->getWaktuKuliahSearch($keyword);
        } else {
            $waktu = $this->waktuModel->getWaktuKuliah();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Waktu Kuliah",
            'breadcrumb' => ['Data', 'Waktu Kuliah'],
            'waktu' => $waktu->paginate($this->numberPage, 'waktu'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->waktuModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\WaktuKuliah\Views\waktuKuliah', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'waktuNama' => rv('required', ['required' => 'Nama Waktu Kuliah harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'waktuKode' => $this->request->getVar('waktuKode'),
            'waktuNama' => $this->request->getVar('waktuNama'),
            'waktuCreatedBy' => user()->email,
        );

        if ($this->waktuModel->insert($data)) {
            session()->setFlashdata('success', 'Data Waktu Kuliah Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'waktuNama' => rv('required', ['required' => 'Nama Waktu Kuliah harus diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'waktuNama' => $this->request->getVar('waktuNama'),
            'waktuModifiedBy' => user()->email,
        );

        if ($this->waktuModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Waktu Kuliah Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->waktuModel->delete($id)) {
            session()->setFlashdata('success', 'Data Waktu Kuliah Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
