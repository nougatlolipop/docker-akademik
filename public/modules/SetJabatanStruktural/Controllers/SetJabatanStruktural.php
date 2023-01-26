<?php

/* 
This is Controller SetJabatanStruktural
 */

namespace Modules\SetJabatanStruktural\Controllers;

use App\Controllers\BaseController;
use Modules\SetJabatanStruktural\Models\SetJabatanStrukturalModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Dosen\Models\DosenModel;
use App\Models\ReferensiModel;


class SetJabatanStruktural extends BaseController
{
    protected $jabatanStrukturalModel;
    protected $fakultasModel;
    protected $validation;
    protected $jabatan;
    protected $dosenModel;

    public function __construct()
    {
        $this->jabatanStrukturalModel = new SetJabatanStrukturalModel();
        $this->fakultasModel = new FakultasModel();
        $this->jabatan = new ReferensiModel();
        $this->dosenModel = new DosenModel;

        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_jabatanStruktural') ? $this->request->getVar('page_jabatanStruktural') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $jabatanStruktural = $this->jabatanStrukturalModel->getJabatanStrukturalSearch($keyword);
        } else {
            $jabatanStruktural = $this->jabatanStrukturalModel->getJabatanStruktural();
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jabatan Struktural",
            'breadcrumb' => ['Setting', 'Jabatan Struktural'],
            'jabatan' => $jabatanStruktural->paginate($this->numberPage, 'jabatanStruktural'),
            'dosen' => $this->dosenModel->findAll(),
            'fakultas' => $this->fakultasModel->getFakultas()->findAll(),
            'struktural' => $this->jabatan->getJabatan()->getResult(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->jabatanStrukturalModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\SetJabatanStruktural\Views\setJabatanStruktural', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'dosenId' => rv('required', ['required' => 'Dosen harus dipilih!']),
            'fakultasId' => rv('required', ['required' => 'Fakultas harus dipilih!']),
            'jabatanId' => rv('required', ['required' => 'Jabatan harus dipilih!']),
            'nomorSK' => rv('required', ['required' => 'Nomor SK harus diisi!']),
            'fileSK' => rv('uploaded[fileSK]', ['uploaded' => 'File SK harus dipilih!']),
        ];

        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        }

        $jumlah = $this->jabatanStrukturalModel->dataExist([
            'setJabatanStukturalId' => $this->request->getVar('jabatanId'),
            'setJabatanFakultasId' => $this->request->getVar('fakultasId'),
        ]);

        if ($jumlah == 0) {

            // upload file
            $fileDokumen = $this->request->getFile('fileSK');
            $fileDokumen->move('Dokumen/sk');
            $namaDokumen = $fileDokumen->getName();

            $data = [
                'setJabatanDosenId' => $this->request->getVar('dosenId'),
                'setJabatanStukturalId' => $this->request->getVar('jabatanId'),
                'setJabatanFakultasId' => $this->request->getVar('fakultasId'),
                'setJabatanNoSK' => $this->request->getVar('nomorSK'),
                'setJabatanTanggalSK' => $this->request->getVar('jabatanTanggalSK'),
                'setJabatanStartDate' => $this->request->getVar('jabatanStartDate'),
                'setJabatanEndDate' => $this->request->getVar('jabatanEndDate'),
                'setJabatanSKDokumen' => $namaDokumen,
                'setJabatanCreatedBy' => user()->email,
            ];

            if ($this->jabatanStrukturalModel->insert($data)) {
                session()->setFlashdata('success', 'Data Jabatan Struktural Berhasil Ditambahkan!');
            }
        } else {
            session()->setFlashdata('failed', 'Data Jabatan Struktural Sudah Disetting!');
        }
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'dosenId' => rv('required', ['required' => 'Dosen harus dipilih!']),
            'fakultasId' => rv('required', ['required' => 'Fakultas harus dipilih!']),
            'jabatanId' => rv('required', ['required' => 'Jabatan harus dipilih!']),
            'nomorSK' => rv('required', ['required' => 'Nomor SK harus diisi!']),
        ];

        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        }

        $fileDokumen = $this->request->getFile('fileSK');

        $jabatanId = $this->request->getVar('jabatanId');
        $oldJabatanId = $this->request->getVar('oldJabatanId');
        $fakultasId = $this->request->getVar('fakultasId');
        $oldFakultasId = $this->request->getVar('oldFakultasId');
        $cek = ($jabatanId == $oldJabatanId && $fakultasId == $oldFakultasId) ? 0 : 1;

        if ($cek == 0) {
            if ($fileDokumen->getError() == 4) {
                $namaDokumen = $this->request->getVar('fileLama');
            } else {
                $fileDokumen->move('Dokumen/sk');
                $namaDokumen = $fileDokumen->getName();
                unlink('Dokumen/sk/' . $this->request->getVar('fileLama'));
            }

            $data = [
                'setJabatanDosenId' => $this->request->getVar('dosenId'),
                'setJabatanStukturalId' => $jabatanId,
                'setJabatanFakultasId' => $fakultasId,
                'setJabatanNoSK' => $this->request->getVar('nomorSK'),
                'setJabatanTanggalSK' => $this->request->getVar('jabatanTanggalSK'),
                'setJabatanStartDate' => $this->request->getVar('jabatanStartDate'),
                'setJabatanEndDate' => $this->request->getVar('jabatanEndDate'),
                'setJabatanSKDokumen' => $namaDokumen,
                'setJabatanModifiedBy' => user()->email,
            ];

            if ($this->jabatanStrukturalModel->update($id, $data)) {
                session()->setFlashdata('success', 'Data Jabatan Struktural Berhasil Di Ubah!');
            }
        } else {
            $jumlah = $this->jabatanStrukturalModel->dataExist([
                'setJabatanStukturalId' => $jabatanId,
                'setJabatanFakultasId' => $fakultasId,
            ]);

            if ($jumlah == 0) {
                if ($fileDokumen->getError() == 4) {
                    $namaDokumen = $this->request->getVar('fileLama');
                } else {
                    $fileDokumen->move('Dokumen/sk');
                    $namaDokumen = $fileDokumen->getName();
                    unlink('Dokumen/sk/' . $this->request->getVar('fileLama'));
                }

                $data = [
                    'setJabatanDosenId' => $this->request->getVar('dosenId'),
                    'setJabatanStukturalId' => $jabatanId,
                    'setJabatanFakultasId' => $fakultasId,
                    'setJabatanNoSK' => $this->request->getVar('nomorSK'),
                    'setJabatanTanggalSK' => $this->request->getVar('jabatanTanggalSK'),
                    'setJabatanStartDate' => $this->request->getVar('jabatanStartDate'),
                    'setJabatanEndDate' => $this->request->getVar('jabatanEndDate'),
                    'setJabatanSKDokumen' => $namaDokumen,
                    'setJabatanModifiedBy' => user()->email,
                ];

                if ($this->jabatanStrukturalModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Data Jabatan Struktural Berhasil Di Ubah!');
                }
            } else {
                session()->setFlashdata('failed', 'Gagal Mengubah Data Jabatan Struktural, Data Sudah Disetting!');
            }
        }

        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->jabatanStrukturalModel->delete($id)) {
            session()->setFlashdata('success', 'Data Jabatan Struktural Berhasil Di Hapus!');
            return redirect()->to($url);
        }
    }
}
