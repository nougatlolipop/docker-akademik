<?php

/* 
This is Controller MatkulType
 */

namespace Modules\MatkulType\Controllers;

use App\Controllers\BaseController;
use Modules\MatkulType\Models\MatkulTypeModel;


class MatkulType extends BaseController
{
    protected $matkulTypeModel;
    protected $validation;

    public function __construct()
    {
        $this->matkulTypeModel = new MatkulTypeModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_matkulType') ? $this->request->getVar('page_matkulType') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $matkulType = $this->matkulTypeModel->getMatkulTypeSearch($keyword);
        } else {
            $matkulType = $this->matkulTypeModel->getMatkulType();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jenis Mata Kuliah",
            'breadcrumb' => ['Data', 'Mata Kuliah', 'Jenis Mata Kuliah'],
            'matkulType' => $matkulType->paginate($this->numberPage, 'matkulType'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->matkulTypeModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\MatkulType\Views\matkulType', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'matkulTypeKode' => rv('required', ['required' => 'Kode jenis matkul harus diisi!']),
            'matkulTypeNama' => rv('required', ['required' => 'Nama jenis matkul harus diisi!']),
            'matkulTypeShortName' => rv('required', ['required' => 'Nama singkat jenis matkul harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'matkulTypeKode' => $this->request->getVar('matkulTypeKode'),
            'matkulTypeNama' => $this->request->getVar('matkulTypeNama'),
            'matkulTypeShortName' => $this->request->getVar('matkulTypeShortName'),
            'matkulTypeCreatedBy' => user()->email,
        );

        if ($this->matkulTypeModel->insert($data)) {
            session()->setFlashdata('success', 'Data Jenis Matkul Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'matkulTypeKode' => rv('required', ['required' => 'Kode jenis matkul harus diisi']),
            'matkulTypeNama' => rv('required', ['required' => 'Nama jenis matkul harus diisi']),
            'matkulTypeShortName' => rv('required', ['required' => 'Nama singkat jenis matkul harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'matkulTypeKode' => $this->request->getVar('matkulTypeKode'),
            'matkulTypeNama' => $this->request->getVar('matkulTypeNama'),
            'matkulTypeShortName' => $this->request->getVar('matkulTypeShortName'),
            'matkulTypeModifiedBy' => user()->email,
        );

        if ($this->matkulTypeModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Jenis Matkul Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->matkulTypeModel->delete($id)) {
            session()->setFlashdata('success', 'Data Jenis Matkul Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
