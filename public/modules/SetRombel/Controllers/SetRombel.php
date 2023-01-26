<?php

/* 
This is Controller SetRombel
 */

namespace Modules\SetRombel\Controllers;

use App\Controllers\BaseController;
use Modules\SetRombel\Models\SetRombelModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\SetProdiProgKuliah\Models\SetProdiProgKuliahModel;
use Modules\SetDosenProdi\Models\SetDosenProdiModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Kelas\Models\KelasModel;


class SetRombel extends BaseController
{
    protected $setRombelModel;
    protected $prodiModel;
    protected $programKuliahModel;
    protected $setProdiProgKuliahModel;
    protected $setDosenProdiModel;
    protected $fakultasModel;
    protected $kelasModel;
    protected $validation;
    public function __construct()
    {
        $this->setRombelModel = new SetRombelModel();
        $this->prodiModel = new ProdiModel();
        $this->setProdiProgKuliahModel = new SetProdiProgKuliahModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->setDosenProdiModel = new SetDosenProdiModel();
        $this->fakultasModel = new FakultasModel();
        $this->kelasModel = new KelasModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {

        $sourceData = [];
        $filter = [];

        if ($this->request->getVar('prodi')) {
            $prodi = explode(',', $this->request->getVar('prodi'));
            $sourceData['prodi'] = $prodi;
            foreach ($prodi as $prd) {
                array_push($filter, ['type' => 'prodi', 'value' => getProdiDetail($prd)[0]->prodiNama, 'id' => $prd]);
            }
        }
        if ($this->request->getVar('pgKuliah')) {
            $sourceData['program_kuliah'] = $this->request->getVar('pgKuliah');
            array_push($filter, ['type' => 'pgKuliah', 'value' => getProgramKuliah($this->request->getVar('pgKuliah'))[0]->programKuliahNama, 'id' => $this->request->getVar('pgKuliah')]);
        }
        if ($this->request->getVar('keyword')) {
            $sourceData['keyword'] = $this->request->getVar('keyword');
            array_push($filter, ['type' => 'keyword', 'value' => $this->request->getVar('keyword'), 'id' => $this->request->getVar('keyword')]);
        }

        $userDetail = getUserDetail();
        if (in_groups('Fakultas')) {
            $fakultas = ['dt_prodi."prodiFakultasId"' => $userDetail[0]->fakultasId];
        } else {
            $fakultas = null;
        }

        $currentPage = $this->request->getVar('page_setRombel') ? $this->request->getVar('page_setRombel') : 1;
        $setRombel = $this->setRombelModel->getSetRombel($sourceData, $fakultas);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Rombel Dosen PA",
            'breadcrumb' => ['Setting', 'Rombel Dosen PA'],
            'setRombel' => $setRombel->paginate($this->numberPage, 'setRombel'),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'prodiBiro' => getUserDetail(),
            'dosenProdi' => $this->setDosenProdiModel->getDosenProdi($sourceData)->findAll(),
            'prodiProg' => $this->setProdiProgKuliahModel->getSetProdiProgKuliah($sourceData)->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'filter' => $filter,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->setRombelModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\SetRombel\Views\setRombel', $data);
    }

    public function add()
    {
        // dd($_POST);
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'setRombelKelasId' => rv('required', ['required' => 'Kelas harus dipilih!']),
            'setRombelAngkatan' => rv('required', ['required' => 'Angkatan harus diisi!']),
            'setRombelDosenPA' => rv('required', ['required' => 'Dosen PA harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $jumlah = $this->setRombelModel->dataExist([
            'setRombelTahunAjaranId' => getTahunAjaranBerjalan()[0]->tahunAjaranId,
            'setRombelKelasId' => $this->request->getVar('setRombelKelasId'),
            'setRombelAngkatan' => $this->request->getVar('setRombelAngkatan'),
            'setRombelProdiProgramKuliahId' => $this->request->getVar('setRombelProdiProgramKuliahId'),
            'setRombelDosenPA' => $this->request->getVar('setRombelDosenPA'),
        ]);

        if ($jumlah == 0) {
            $data = array(
                'setRombelTahunAjaranId' => getTahunAjaranBerjalan()[0]->tahunAjaranId,
                'setRombelKelasId' => $this->request->getVar('setRombelKelasId'),
                'setRombelAngkatan' => $this->request->getVar('setRombelAngkatan'),
                'setRombelProdiProgramKuliahId' => $this->request->getVar('setRombelProdiProgramKuliahId'),
                'setRombelDosenPA' => $this->request->getVar('setRombelDosenPA'),
                'setRombelCreatedBy' => user()->email,
            );
            if ($this->setRombelModel->insert($data)) {
                session()->setFlashdata('success', 'Data Rombel Dosen PA Berhasil Ditambahkan!');
            }
        } else {
            session()->setFlashdata('failed', 'Data Rombel Dosen PA Sudah Disetting!');
        }

        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'setRombelKelasId' => rv('required', ['required' => 'Kelas harus dipilih!']),
            'setRombelAngkatan' => rv('required', ['required' => 'Angkatan harus dipilih!']),
            'setRombelDosenPA' => rv('required', ['required' => 'Dosen PA harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $jumlah = $this->setRombelModel->dataExist([
            'setRombelKelasId' => $this->request->getVar('setRombelKelasId'),
            'setRombelAngkatan' => $this->request->getVar('setRombelAngkatan'),
            'setRombelTahunAjaranId' => $this->request->getVar('setRombelTahunAjaranId'),
            'setRombelProdiProgramKuliahId' => $this->request->getVar('setRombelProdiProgramKuliahId'),
            'setRombelDosenPA' => $this->request->getVar('setRombelDosenPA'),
        ]);
        if ($jumlah == 0) {
            $data = array(
                'setRombelKelasId' => $this->request->getVar('setRombelKelasId'),
                'setRombelAngkatan' => $this->request->getVar('setRombelAngkatan'),
                'setRombelTahunAjaranId' => $this->request->getVar('setRombelTahunAjaranId'),
                'setRombelProdiProgramKuliahId' => $this->request->getVar('setRombelProdiProgramKuliahId'),
                'setRombelDosenPA' => $this->request->getVar('setRombelDosenPA'),
                'setRombelModifiedBy' => user()->email,
            );
            if ($this->setRombelModel->update($id, $data)) {
                session()->setFlashdata('success', 'Data Rombel Dosen PA Berhasil Diubah!');
            }
        } else {
            session()->setFlashdata('failed', 'Gagal Mengubah Data Rombel Dosen PA, Data Sudah Disetting!');
        }
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->setRombelModel->delete($id)) {
            session()->setFlashdata('success', 'Data Rombel Dosen PA Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }

    public function updateDosen($id)
    {
        $email = $this->request->getVar('email');
        $dosenId = $this->request->getVar('dosenId');
        $data = [
            'setRombelDosenPA' =>  $dosenId,
            'setRombelModifiedBy' => $email
        ];

        if ($this->setRombelModel->update($id, $data)) {
            $response = 1;
        } else {
            $response = 0;
        }
        echo json_encode($response);
    }
}
