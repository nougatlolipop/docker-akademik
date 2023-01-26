<?php

/* 
This is Controller Matkul
 */

namespace Modules\Matkul\Controllers;

use App\Controllers\BaseController;
use Modules\Matkul\Models\MatkulModel;
use Modules\Prodi\Models\ProdiModel;


class Matkul extends BaseController
{
    protected $matkulModel;
    protected $prodiModel;
    protected $validation;

    public function __construct()
    {
        $this->matkulModel = new MatkulModel();
        $this->prodiModel = new ProdiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_matkul') ? $this->request->getVar('page_matkul') : 1;
        $keyword = $this->request->getVar('keyword');
        if (in_groups('Fakultas')) {
            $fakultas = ['dt_prodi."prodiFakultasId"' => getUserDetail()[0]->fakultasId];
            $breadcrumb = ['Data', 'Mata Kuliah'];
        } else {
            $fakultas = null;
            $breadcrumb = ['Data', 'Mata Kuliah', 'Data Mata Kuliah'];
        }
        $matkul = $this->matkulModel->getMatkul($fakultas, $keyword);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Data Mata Kuliah",
            'breadcrumb' => $breadcrumb,
            'matkul' => $matkul->paginate($this->numberPage, 'matkul'),
            'type' => $this->matkulModel->getMatkulType(),
            'prodi' => $this->prodiModel->getProdi()->get()->getResult(),
            'prodiBiro' => getUserDetail(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->matkulModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Matkul\Views\matkul', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'matkulKode' => rv('required', ['required' => 'Kode mata kuliah harus diisi!']),
            'matkulNama' => rv('required', ['required' => 'Nama mata kuliah harus diisi!']),
            'matkulNamaEnglish' => rv('required', ['required' => 'Nama asing mata kuliah harus diisi!']),
            'matkulTypeId' => rv('required', ['required' => 'Tipe mata kuliah harus dipilih!']),
            'matkulProdiId' => rv('required', ['required' => 'Prodi mata kuliah prodi harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $jumlah = $this->matkulModel->dataExist(['matkulKode' => trim($this->request->getVar('matkulKode'))]);

        if ($jumlah == 0) {
            $data = array(
                'matkulKode' => trim($this->request->getVar('matkulKode')),
                'matkulNama' => trim($this->request->getVar('matkulNama')),
                'matkulNamaEnglish' => trim($this->request->getVar('matkulNamaEnglish')),
                'matkulTypeId' => trim($this->request->getVar('matkulTypeId')),
                'matkulProdiId' => trim($this->request->getVar('matkulProdiId')),
                'matkulCreatedBy' => user()->email,
            );
            if ($this->matkulModel->insert($data)) {
                session()->setFlashdata('success', 'Data Mata Kuliah Berhasil Ditambahkan!');
            }
        } else {
            session()->setFlashdata('failed', 'Data Mata Kuliah Sudah Disetting!');
        }
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'matkulKode' => rv('required', ['required' => 'Kode mata kuliah harus diisi!']),
            'matkulNama' => rv('required', ['required' => 'Nama mata kuliah harus diisi!']),
            'matkulNamaEnglish' => rv('required', ['required' => 'Nama asing mata kuliah harus diisi!']),
            'matkulTypeId' => rv('required', ['required' => 'Tipe mata kuliah harus dipilih!']),
            'matkulProdiId' => rv('required', ['required' => 'Prodi mata kuliah prodi harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $matkulKode = trim($this->request->getVar('matkulKode'));
        $oldMatkulKode = trim($this->request->getVar('oldMatkulKode'));
        $cek = ($matkulKode == $oldMatkulKode) ? 0 : 1;

        if ($cek == 0) {
            $data = array(
                'matkulKode' => $matkulKode,
                'matkulNama' => trim($this->request->getVar('matkulNama')),
                'matkulNamaEnglish' => trim($this->request->getVar('matkulNamaEnglish')),
                'matkulTypeId' => trim($this->request->getVar('matkulTypeId')),
                'matkulProdiId' => trim($this->request->getVar('matkulProdiId')),
                'matkulModifiedBy' => user()->email,
            );
            if ($this->matkulModel->update($id, $data)) {
                session()->setFlashdata('success', 'Data Mata Kuliah Berhasil Diubah!');
            }
        } else {
            $jumlah = $this->matkulModel->dataExist(['matkulKode' => $matkulKode]);
            if ($jumlah == 0) {
                $data = array(
                    'matkulKode' => $matkulKode,
                    'matkulNama' => trim($this->request->getVar('matkulNama')),
                    'matkulNamaEnglish' => trim($this->request->getVar('matkulNamaEnglish')),
                    'matkulTypeId' => trim($this->request->getVar('matkulTypeId')),
                    'matkulProdiId' => trim($this->request->getVar('matkulProdiId')),
                    'matkulModifiedBy' => user()->email,
                );
                if ($this->matkulModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Data Mata Kuliah Berhasil Diubah!');
                }
            } else {
                session()->setFlashdata('failed', 'Gagal Mengubah Data Mata Kuliah, Data Sudah Disetting!');
            }
        }
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->matkulModel->delete($id)) {
            session()->setFlashdata('success', 'Data Mata Kuliah Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
