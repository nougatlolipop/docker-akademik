<?php

/* 
This is Controller TahunAjaran
 */

namespace Modules\TahunAjaran\Controllers;

use App\Controllers\BaseController;
use Modules\TahunAjaran\Models\TahunAjaranModel;


class TahunAjaran extends BaseController
{

    protected $tahunAjaranModel;
    protected $validation;

    public function __construct()
    {
        $this->tahunAjaranModel = new TahunAjaranModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_tahunAjaran') ? $this->request->getVar('page_tahunAjaran') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $tahunAjaran = $this->tahunAjaranModel->getTahunAjaranSearch($keyword);
        } else {
            $tahunAjaran = $this->tahunAjaranModel->getTahunAjaran();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Tahun Ajaran",
            'breadcrumb' => ['Data', 'Tahun Ajaran'],
            'tahunAjaran' => $tahunAjaran->paginate($this->numberPage, 'tahunAjaran'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->tahunAjaranModel->pager,
            'semester' => $this->tahunAjaranModel->getSemester()->getResult(),
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\TahunAjaran\Views\tahunAjaran', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'tahunAjaranKode' => rv('required', ['required' => 'Kode Tahun Ajaran harus diisi!']),
            'tahunAjaranNama' => rv('required', ['required' => 'Nama Tahun Ajaran harus diisi!']),
            'semesterId' => rv('required', ['required' => 'Semester harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'tahunAjaranKode' => $this->request->getVar('tahunAjaranKode'),
            'tahunAjaranNama' => $this->request->getVar('tahunAjaranNama'),
            'tahunAjaranSemesterId' => $this->request->getVar('semesterId'),
            'tahunAjaranStartDate' => $this->request->getVar('tahunAjaranStartDate'),
            'tahunAjaranEndDate' => $this->request->getVar('tahunAjaranEndDate'),
            'tahunAjaranCreatedBy' => user()->email,
        );

        if ($this->tahunAjaranModel->insert($data)) {
            session()->setFlashdata('success', 'Data Tahun Ajaran Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'tahunAjaranKode' => rv('required', ['required' => 'Kode Tahun Ajaran harus diisi']),
            'tahunAjaranNama' => rv('required', ['required' => 'Nama Tahun Ajaran harus diisi']),
            'semesterId' => rv('required', ['required' => 'Semester harus dipilih!'])
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'tahunAjaranKode' => $this->request->getVar('tahunAjaranKode'),
            'tahunAjaranNama' => $this->request->getVar('tahunAjaranNama'),
            'tahunAjaranSemesterId' => $this->request->getVar('semesterId'),
            'tahunAjaranStartDate' => $this->request->getVar('tahunAjaranStartDate'),
            'tahunAjaranEndDate' => $this->request->getVar('tahunAjaranEndDate'),
            'tahunAjaranModifiedBy' => user()->email,
        );

        if ($this->tahunAjaranModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Tahun Ajaran Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->tahunAjaranModel->delete($id)) {
            session()->setFlashdata('success', 'Data Tahun Ajaran Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
