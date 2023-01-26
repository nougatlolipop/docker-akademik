<?php

/* 
This is Controller Semester
 */

namespace Modules\Semester\Controllers;

use App\Controllers\BaseController;
use Modules\Semester\Models\SemesterModel;


class Semester extends BaseController
{
    protected $semesterModel;
    protected $validation;

    public function __construct()
    {
        $this->semesterModel = new SemesterModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_semester') ? $this->request->getVar('page_semester') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $semester = $this->semesterModel->getSemesterSearch($keyword);
        } else {
            $semester = $this->semesterModel->getSemester();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Semester",
            'breadcrumb' => ['Data', 'Semester'],
            'semester' => $semester->paginate($this->numberPage, 'semester'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->semesterModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Semester\Views\semester', $data);
    }

    public function add()
    {
        $rules = [
            'semesterKode' => rv('required', ['required' => 'Kode semester harus diisi!']),
            'semesterNama' => rv('required', ['required' => 'Nama semester harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('/semester')->withInput();
        };

        $data = array(
            'semesterKode' => $this->request->getVar('semesterKode'),
            'semesterNama' => $this->request->getVar('semesterNama'),
            'semesterCreatedBy' => user()->email,
        );

        if ($this->semesterModel->insert($data)) {
            session()->setFlashdata('success', 'Data Semester Berhasil Ditambahkan!');
            return redirect()->to('/semester');
        }
    }

    public function edit($id)
    {
        $rules = [
            'semesterKode' => rv('required', ['required' => 'Kode semester harus diisi']),
            'semesterNama' => rv('required', ['required' => 'Nama semester harus diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('/semester')->withInput();
        };

        $data = array(
            'semesterKode' => $this->request->getVar('semesterKode'),
            'semesterNama' => $this->request->getVar('semesterNama'),
            'semesterModifiedBy' => user()->email,
        );

        if ($this->semesterModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Semester Berhasil Diubah!');
            return redirect()->to('/semester');
        }
    }

    public function delete($id)
    {
        if ($this->semesterModel->delete($id)) {
            session()->setFlashdata('success', 'Data Semester Berhasil Dihapus!');
        };
        return redirect()->to('/semester');
    }
}
