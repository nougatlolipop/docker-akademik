<?php

/* 
This is Controller KurikulumType
 */

namespace Modules\KurikulumType\Controllers;

use App\Controllers\BaseController;
use Modules\KurikulumType\Models\KurikulumTypeModel;


class KurikulumType extends BaseController
{
    protected $kurikulumTypeModel;
    protected $validation;

    public function __construct()
    {
        $this->kurikulumTypeModel = new KurikulumTypeModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_kurikulumType') ? $this->request->getVar('page_kurikulumType') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $kurikulumType = $this->kurikulumTypeModel->getKurikulumTypeSearch($keyword);
        } else {
            $kurikulumType = $this->kurikulumTypeModel->getKurikulumType();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jenis Kurikulum",
            'breadcrumb' => ['Data', 'Kurikulum', 'Jenis Kurikulum'],
            'kurikulumType' => $kurikulumType->paginate($this->numberPage, 'kurikulumType'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->kurikulumTypeModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KurikulumType\Views\kurikulumType', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kurikulumTypeKode' => rv('required', ['required' => 'Kode jenis kurikulum harus diisi!']),
            'kurikulumTypeNama' => rv('required', ['required' => 'Nama jenis kurikulum harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'kurikulumTypeKode' => $this->request->getVar('kurikulumTypeKode'),
            'kurikulumTypeNama' => $this->request->getVar('kurikulumTypeNama'),
            'kurikulumTypeCreatedBy' => user()->email,
        );

        if ($this->kurikulumTypeModel->insert($data)) {
            session()->setFlashdata('success', 'Data Jenis Kurikulum Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kurikulumTypeKode' => rv('required', ['required' => 'Kode jenis kurikulum harus diisi']),
            'kurikulumTypeNama' => rv('required', ['required' => 'Nama jenis kurikulum harus diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'kurikulumTypeKode' => $this->request->getVar('kurikulumTypeKode'),
            'kurikulumTypeNama' => $this->request->getVar('kurikulumTypeNama'),
            'kurikulumTypeModifiedBy' => user()->email,
        );

        if ($this->kurikulumTypeModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Jenis Kurikulum Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->kurikulumTypeModel->delete($id)) {
            session()->setFlashdata('success', 'Data Jenis Kurikulum Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
