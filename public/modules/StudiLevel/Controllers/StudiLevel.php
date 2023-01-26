<?php

/* 
This is Controller StudiLevel
 */

namespace Modules\StudiLevel\Controllers;

use App\Controllers\BaseController;
use Modules\StudiLevel\Models\StudiLevelModel;


class StudiLevel extends BaseController
{
    protected $studiLevelModel;
    protected $validation;

    public function __construct()
    {
        $this->studiLevelModel = new StudiLevelModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_studiLevel') ? $this->request->getVar('page_studiLevel') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $studiLevel = $this->studiLevelModel->getStudiLevelSearch($keyword);
        } else {
            $studiLevel = $this->studiLevelModel->getStudiLevel();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Studi Level",
            'breadcrumb' => ['Data', 'Studi Level'],
            'studiLevel' => $studiLevel->paginate($this->numberPage, 'studiLevel'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->studiLevelModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\StudiLevel\Views\studiLevel', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'studiLevelKode' => rv('required', ['required' => 'Kode study level harus diisi!']),
            'studiLevelNama' => rv('required', ['required' => 'Nama study level harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'studiLevelKode' => $this->request->getVar('studiLevelKode'),
            'studiLevelNama' => $this->request->getVar('studiLevelNama'),
            'studiLevelCreatedBy' => user()->email,
        );

        if ($this->studiLevelModel->insert($data)) {
            session()->setFlashdata('success', 'Data Studi Level Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'studiLevelKode' => rv('required', ['required' => 'Kode study level harus diisi']),
            'studiLevelNama' => rv('required', ['required' => 'Nama study level harus diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'studiLevelKode' => $this->request->getVar('studiLevelKode'),
            'studiLevelNama' => $this->request->getVar('studiLevelNama'),
            'studiLevelModifiedBy' => user()->email,
        );

        if ($this->studiLevelModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Studi Level Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->studiLevelModel->delete($id)) {
            session()->setFlashdata('success', 'Data Studi Level Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
