<?php

/* 
This is Controller Kurikulum
 */

namespace Modules\Kurikulum\Controllers;

use App\Controllers\BaseController;
use Modules\Kurikulum\Models\KurikulumModel;
use Modules\Sks\Models\SksModel;

class Kurikulum extends BaseController
{
    protected $kurikulumModel;
    protected $sksModel;
    protected $validation;
    public function __construct()
    {
        $this->kurikulumModel = new KurikulumModel();
        $this->sksModel = new SksModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_kurikulum') ? $this->request->getVar('page_kurikulum') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $kurikulum = $this->kurikulumModel->getKurikulumSearch($keyword);
        } else {
            $kurikulum = $this->kurikulumModel->getKurikulum();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Data Kurikulum",
            'breadcrumb' => ['Data', 'Kurikulum', 'Data Kurikulum'],
            'kurikulum' => $kurikulum->paginate($this->numberPage, 'kurikulum'),
            'sksAllow' => $this->sksModel->getSks()->get()->getResult(),
            'kurikulumType' => $this->kurikulumModel->getKurikulumType()->getResult(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->kurikulumModel->pager,
            'validation' => \Config\Services::validation()
        ];
        return view('Modules\Kurikulum\Views\kurikulum', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kurikulumKode' => rv('required', ['required' => 'Kode kurikulum harus diisi!']),
            'kurikulumNama' => rv('required', ['required' => 'Nama kurikulum harus diisi!']),
            'kurikulumKurTypeId' => rv('required', ['required' => 'Tipe kurikulum harus dipilih!']),
            'kurikulumSksAllowId' => rv('required', ['required' => 'Aturan SKS harus dipilih!'])
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'kurikulumKode' => $this->request->getVar('kurikulumKode'),
            'kurikulumNama' => $this->request->getVar('kurikulumNama'),
            'kurikulumKurTypeId' => $this->request->getVar('kurikulumKurTypeId'),
            'kurikulumSksAllowId' => $this->request->getVar('kurikulumSksAllowId'),
            'kurikulumCreatedBy' => user()->email,
        );

        if ($this->kurikulumModel->insert($data)) {
            session()->setFlashdata('success', 'Data Kurikulum Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kurikulumKode' => rv('required', ['required' => 'Kode kurikulum harus diisi']),
            'kurikulumNama' => rv('required', ['required' => 'Nama kurikulum harus diisi']),
            'kurikulumKurTypeId' => rv('required', ['required' => 'Tipe kurikulum harus dipilih']),
            'kurikulumSksAllowId' => rv('required', ['required' => 'Aturan SKS harus dipilih'])
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'kurikulumKode' => $this->request->getVar('kurikulumKode'),
            'kurikulumNama' => $this->request->getVar('kurikulumNama'),
            'kurikulumKurTypeId' => $this->request->getVar('kurikulumKurTypeId'),
            'kurikulumSksAllowId' => $this->request->getVar('kurikulumSksAllowId'),
            'kurikulumModifiedBy' => user()->email,
        );

        if ($this->kurikulumModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Kurikulum Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->kurikulumModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kurikulum Berhasil Dihapus!');
            return redirect()->to($url);
        };
    }
}
