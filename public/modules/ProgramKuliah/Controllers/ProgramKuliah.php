<?php

/* 
This is Controller ProgramKuliah
 */

namespace Modules\ProgramKuliah\Controllers;

use App\Controllers\BaseController;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;

class ProgramKuliah extends BaseController
{
    protected $programKuliahModel;
    protected $validation;
    public function __construct()
    {
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_programKuliah') ? $this->request->getVar('page_programKuliah') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $programKuliah = $this->programKuliahModel->getProgramKuliahSearch($keyword);
        } else {
            $programKuliah = $this->programKuliahModel->getProgramKuliah();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Program Kuliah",
            'breadcrumb' => ['Data', 'Program Kuliah'],
            'programKuliah' => $programKuliah->paginate($this->numberPage, 'programKuliah'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->programKuliahModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\ProgramKuliah\Views\programKuliah', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'programKuliahKode' => rv('required', ['required' => 'Kode program kuliah harus diisi!']),
            'programKuliahNama' => rv('required', ['required' => 'Nama program kuliah harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'programKuliahKode' => $this->request->getVar('programKuliahKode'),
            'programKuliahNama' => $this->request->getVar('programKuliahNama'),
            'programKuliahCreatedBy' => user()->email,
        );

        if ($this->programKuliahModel->insert($data)) {
            session()->setFlashdata('success', 'Data Program Kuliah Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'programKuliahKode' => rv('required', ['required' => 'Kode program kuliah harus diisi!']),
            'programKuliahNama' => rv('required', ['required' => 'Nama program kuliah harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'programKuliahKode' => $this->request->getVar('programKuliahKode'),
            'programKuliahNama' => $this->request->getVar('programKuliahNama'),
            'programKuliahModifiedBy' => user()->email,
        );

        if ($this->programKuliahModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Program Kuliah Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->programKuliahModel->delete($id)) {
            session()->setFlashdata('success', 'Data Program Kuliah Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
