<?php

/* 
This is Controller Nilai
 */

namespace Modules\Nilai\Controllers;

use App\Controllers\BaseController;
use Modules\Nilai\Models\NilaiModel;


class Nilai extends BaseController
{
    protected $nilaiModel;
    protected $validation;

    public function __construct()
    {
        $this->nilaiModel = new NilaiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_nilai') ? $this->request->getVar('page_nilai') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $nilai = $this->nilaiModel->getNilaiSearch($keyword);
        } else {
            $nilai = $this->nilaiModel->getNilai();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Nilai",
            'breadcrumb' => ['Data', 'Aturan', 'Nilai'],
            'nilai' => $nilai->paginate($this->numberPage, 'nilai'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->nilaiModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Nilai\Views\nilai', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'gradeNilaiKode' => rv('required', ['required' => 'Kode nilai harus diisi!']),
            'gradeNilaiNama' => rv('required', ['required' => 'Nama nilai harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'gradeNilaiKode' => $this->request->getVar('gradeNilaiKode'),
            'gradeNilaiNama' => $this->request->getVar('gradeNilaiNama'),
            'gradeNilaiCreatedBy' => user()->email,
        );
        if ($this->nilaiModel->insert($data)) {
            session()->setFlashdata('success', 'Data Nilai Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'gradeNilaiKode' => rv('required', ['required' => 'Kode nilai harus diisi']),
            'gradeNilaiNama' => rv('required', ['required' => 'Nama nilai harus diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'gradeNilaiKode' => $this->request->getVar('gradeNilaiKode'),
            'gradeNilaiNama' => $this->request->getVar('gradeNilaiNama'),
            'gradeNilaiModifiedBy' => user()->email,
        );

        if ($this->nilaiModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Nilai Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->nilaiModel->delete($id)) {
            session()->setFlashdata('success', 'Data Nilai Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
