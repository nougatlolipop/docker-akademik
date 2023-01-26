<?php

/* 
This is Controller Fakultas
 */

namespace Modules\Fakultas\Controllers;

use App\Controllers\BaseController;
use Modules\Fakultas\Models\FakultasModel;

class Fakultas extends BaseController
{
    protected $fakultasModel;
    protected $validation;
    public function __construct()
    {
        $this->fakultasModel = new FakultasModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_fakultas') ? $this->request->getVar('page_fakultas') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $fakultas = $this->fakultasModel->getFakultasSearch($keyword);
        } else {
            $fakultas = $this->fakultasModel->getFakultasForKrs();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Fakultas",
            'breadcrumb' => ['Data', 'Fakultas'],
            'fakultas' => $fakultas->paginate($this->numberPage, 'fakultas'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->fakultasModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Fakultas\Views\fakultas', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'fakultasKode' => rv('required', ['required' => 'Kode fakultas harus diisi!']),
            'fakultasNama' => rv('required', ['required' => 'Nama fakultas harus diisi!']),
            'fakultasAcronym' => rv('required', ['required' => 'Akronim fakultas harus diisi!']),
            'fakultasNamaAsing' => rv('required', ['required' => 'Nama asing fakultas harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'fakultasKode' => $this->request->getVar('fakultasKode'),
            'fakultasNama' => $this->request->getVar('fakultasNama'),
            'fakultasAcronym' => $this->request->getVar('fakultasAcronym'),
            'fakultasNamaAsing' => $this->request->getVar('fakultasNamaAsing'),
            'fakultasIsAktif' => trim($this->request->getVar('fakultasIsAktif')) == null ? 0 : 1,
            'fakultasCreateBy' => user()->email,
        );

        if ($this->fakultasModel->insert($data)) {
            session()->setFlashdata('success', 'Data Fakultas Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'fakultasKode' => rv('required', ['required' => 'Kode fakultas harus diisi!']),
            'fakultasNama' => rv('required', ['required' => 'Nama fakultas harus diisi!']),
            'fakultasAcronym' => rv('required', ['required' => 'Akronim fakultas harus diisi!']),
            'fakultasNamaAsing' => rv('required', ['required' => 'Nama asing fakultas harus diisi!'])
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'fakultasKode' => $this->request->getVar('fakultasKode'),
            'fakultasNama' => $this->request->getVar('fakultasNama'),
            'fakultasAcronym' => $this->request->getVar('fakultasAcronym'),
            'fakultasNamaAsing' => $this->request->getVar('fakultasNamaAsing'),
            'fakultasIsAktif' => $this->request->getVar('fakultasIsAktif') == null ? 0 : 1,
            'fakultasModifiedBy' => user()->email,
        );

        if ($this->fakultasModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Fakultas Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->fakultasModel->delete($id)) {
            session()->setFlashdata('success', 'Data Fakultas Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }

    public function updateDosen($id)
    {
        $email = $this->request->getVar('email');
        $dosenId = $this->request->getVar('dosenId');
        $jabatan = $this->request->getVar('jabatan');

        if ($jabatan == 'dekan') {
            $data = [
                'fakultasDekan' =>  $dosenId,
                'fakultasModifiedBy' => $email
            ];
        } elseif ($jabatan == 'wdI') {
            $data = [
                'fakultasWD1' =>  $dosenId,
                'fakultasModifiedBy' => $email
            ];
        } else {
            $data = [
                'fakultasWD3' =>  $dosenId,
                'fakultasModifiedBy' => $email
            ];
        }

        if ($this->fakultasModel->update($id, $data)) {
            $response = 1;
        } else {
            $response = 0;
        }
        echo json_encode($response);
    }
}
