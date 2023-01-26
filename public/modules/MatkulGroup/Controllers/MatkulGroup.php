<?php

/* 
This is Controller MatkulGroup
 */

namespace Modules\MatkulGroup\Controllers;

use App\Controllers\BaseController;
use Modules\MatkulGroup\Models\MatkulGroupModel;


class MatkulGroup extends BaseController
{
    protected $matkulGroupModel;
    protected $validation;

    public function __construct()
    {
        $this->matkulGroupModel = new MatkulGroupModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_matkulGroup') ? $this->request->getVar('page_matkulGroup') : 1;
        $keyword = $this->request->getVar('keyword');
        $matkulGroup = $this->matkulGroupModel->getMatkulGroup($keyword);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Kelompok Mata Kuliah",
            'breadcrumb' => ['Data', 'Mata Kuliah', 'Kelompok Mata Kuliah'],
            'matkulGroup' => $matkulGroup->paginate($this->numberPage, 'matkulGroup'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->matkulGroupModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\MatkulGroup\Views\matkulGroup', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'matkulGroupKode' => rv('required', ['required' => 'Kode mata kuliah harus diisi!']),
            'matkulGroupNama' => rv('required', ['required' => 'Nama mata kuliah harus diisi!']),
            'matkulGroupDeskripsi' => rv('required', ['required' => 'Nama asing mata kuliah harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'matkulGroupKode' => trim($this->request->getVar('matkulGroupKode')),
            'matkulGroupNama' => trim($this->request->getVar('matkulGroupNama')),
            'matkulGroupDeskripsi' => trim($this->request->getVar('matkulGroupDeskripsi')),
            'matkulGroupCreatedBy' => user()->email,
        );

        if ($this->matkulGroupModel->insert($data)) {
            session()->setFlashdata('success', 'Kelompok Mata Kuliah Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'matkulGroupKode' => rv('required', ['required' => 'Kode mata kuliah harus diisi!']),
            'matkulGroupNama' => rv('required', ['required' => 'Nama mata kuliah harus diisi!']),
            'matkulGroupDeskripsi' => rv('required', ['required' => 'Nama asing mata kuliah harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'matkulGroupKode' => trim($this->request->getVar('matkulGroupKode')),
            'matkulGroupNama' => trim($this->request->getVar('matkulGroupNama')),
            'matkulGroupDeskripsi' => trim($this->request->getVar('matkulGroupDeskripsi')),
            'matkulGroupModifiedBy' => user()->email,
        );

        if ($this->matkulGroupModel->update($id, $data)) {
            session()->setFlashdata('success', 'Kelompok Mata Kuliah Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->matkulGroupModel->delete($id)) {
            session()->setFlashdata('success', 'Kelompok Mata Kuliah Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
