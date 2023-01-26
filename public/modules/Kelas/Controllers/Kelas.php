<?php

/* 
This is Controller Kelas
 */

namespace Modules\Kelas\Controllers;

use App\Controllers\BaseController;
use Modules\Kelas\Models\KelasModel;


class Kelas extends BaseController
{
    protected $kelasModel;
    protected $validation;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_kelas') ? $this->request->getVar('page_kelas') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $kelas = $this->kelasModel->getKelasSearch($keyword);
        } else {
            $kelas = $this->kelasModel->getKelas();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Kelas",
            'breadcrumb' => ['Data', 'Kelas'],
            'kelas' => $kelas->paginate($this->numberPage, 'kelas'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->kelasModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Kelas\Views\kelas', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kelasKode' => rv('required', ['required' => 'Kode kelas harus diisi!']),
            'kelasNama' => rv('required', ['required' => 'Nama kelas harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'kelasKode' => $this->request->getVar('kelasKode'),
            'kelasNama' => $this->request->getVar('kelasNama'),
            'kelasCreatedBy' => user()->email,
        );

        if ($this->kelasModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kelas Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kelasKode' => rv('required', ['required' => 'Kode kelas harus diisi']),
            'kelasNama' => rv('required', ['required' => 'Nama kelas harus diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'kelasKode' => $this->request->getVar('kelasKode'),
            'kelasNama' => $this->request->getVar('kelasNama'),
            'kelasModifiedBy' => user()->email,
        );

        if ($this->kelasModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kelas Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->kelasModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kelas Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
