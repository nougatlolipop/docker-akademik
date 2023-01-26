<?php

/* 
This is Controller SetProdiProgKuliah
 */

namespace Modules\SetProdiProgKuliah\Controllers;

use App\Controllers\BaseController;
use Modules\SetProdiProgKuliah\Models\SetProdiProgKuliahModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\WaktuKuliah\Models\WaktuKuliahModel;
use Modules\KelompokKuliah\Models\KelompokKuliahModel;

class SetProdiProgKuliah extends BaseController
{
    protected $setProdiProgKuliahModel;
    protected $prodiModel;
    protected $fakultasModel;
    protected $programKuliahModel;
    protected $waktuKuliahModel;
    protected $kelompokKuliahModel;
    protected $validation;
    public function __construct()
    {
        $this->setProdiProgKuliahModel = new SetProdiProgKuliahModel();
        $this->prodiModel = new ProdiModel();
        $this->fakultasModel = new FakultasModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->waktuKuliahModel = new WaktuKuliahModel();
        $this->kelompokKuliahModel = new KelompokKuliahModel();
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
        $currentPage = $this->request->getVar('page_setProdiProgKuliah') ? $this->request->getVar('page_setProdiProgKuliah') : 1;
        $setProdiProgKuliah = $this->setProdiProgKuliahModel->getSetProdiProgKuliah($sourceData, $fakultas);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Prodi Prog. Kuliah",
            'breadcrumb' => ['Setting', 'Prodi Prog. Kuliah'],
            'setProdiProgKuliah' => $setProdiProgKuliah->paginate($this->numberPage, 'setProdiProgKuliah'),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'prodiBiro' => $userDetail,
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'waktuKuliah' => $this->waktuKuliahModel->getWaktuKuliah()->findAll(),
            'kelompokKuliah' => $this->kelompokKuliahModel->getKelompokKuliah()->findAll(),
            'currentPage' => $currentPage,
            'filter' => $filter,
            'numberPage' => $this->numberPage,
            'pager' => $this->setProdiProgKuliahModel->pager,
            'validation' => \Config\Services::validation()
        ];
        return view('Modules\SetProdiProgKuliah\Views\setProdiProgKuliah', $data);
    }

    public function add()
    {
        $url =  $this->request->getServer('HTTP_REFERER');
        $rules = [
            'setProdiProgramKuliahWaktuKuliahId' => rv('required', ['required' => 'Waktu kuliah harus dipilih!']),
            'setProdiProgramKuliahKelompokKuliahId' => rv('required', ['required' => 'Kelompok kuliah harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $prodi = explode(",", $this->request->getVar('setProdiProgramKuliahProdiId'));

        foreach ($prodi as $dataProdi) {
            $jumlah = $this->setProdiProgKuliahModel->dataExist([
                'setProdiProgramKuliahProdiId' => $dataProdi,
                'setProdiProgramKuliahProgramKuliahId' => $this->request->getVar('setProdiProgramKuliahProgramKuliahId'),
                'setProdiProgramKuliahWaktuKuliahId' => $this->request->getVar('setProdiProgramKuliahWaktuKuliahId'),
                'setProdiProgramKuliahKelompokKuliahId' => $this->request->getVar('setProdiProgramKuliahKelompokKuliahId'),
            ]);
            if ($jumlah == 0) {
                $data = array(
                    'setProdiProgramKuliahProdiId' => $dataProdi,
                    'setProdiProgramKuliahProgramKuliahId' => $this->request->getVar('setProdiProgramKuliahProgramKuliahId'),
                    'setProdiProgramKuliahWaktuKuliahId' => $this->request->getVar('setProdiProgramKuliahWaktuKuliahId'),
                    'setProdiProgramKuliahKelompokKuliahId' => $this->request->getVar('setProdiProgramKuliahKelompokKuliahId'),
                    'setProdiProgramKuliahIsAktif' => $this->request->getVar('setProdiProgramKuliahIsAktif') == null ? 0 : 1,
                    'setProdiProgramKuliahCreatedBy' => user()->email,
                );
                if ($this->setProdiProgKuliahModel->insert($data)) {
                    session()->setFlashdata('success', 'Data Prodi Program Kuliah Berhasil Ditambahkan!');
                }
            } else {
                session()->setFlashdata('failed', 'Data Prodi Program Kuliah Sudah Disetting!');
            }
        }
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url =  $this->request->getServer('HTTP_REFERER');
        $rules = [
            'setProdiProgramKuliahProdiId' => rv('required', ['required' => 'Prodi harus dipilih!']),
            'setProdiProgramKuliahProgramKuliahId' => rv('required', ['required' => 'Program kuliah harus dipilih!']),
            'setProdiProgramKuliahWaktuKuliahId' => rv('required', ['required' => 'Waktu kuliah harus dipilih!']),
            'setProdiProgramKuliahKelompokKuliahId' => rv('required', ['required' => 'Kelompok kuliah harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $jumlah = $this->setProdiProgKuliahModel->dataExist([
            'setProdiProgramKuliahProdiId' => $this->request->getVar('setProdiProgramKuliahProdiId'),
            'setProdiProgramKuliahProgramKuliahId' => $this->request->getVar('setProdiProgramKuliahProgramKuliahId'),
            'setProdiProgramKuliahWaktuKuliahId' => $this->request->getVar('setProdiProgramKuliahWaktuKuliahId'),
            'setProdiProgramKuliahKelompokKuliahId' => $this->request->getVar('setProdiProgramKuliahKelompokKuliahId'),
        ]);

        if ($jumlah == 0) {
            $data = array(
                'setProdiProgramKuliahProdiId' => $this->request->getVar('setProdiProgramKuliahProdiId'),
                'setProdiProgramKuliahProgramKuliahId' => $this->request->getVar('setProdiProgramKuliahProgramKuliahId'),
                'setProdiProgramKuliahWaktuKuliahId' => $this->request->getVar('setProdiProgramKuliahWaktuKuliahId'),
                'setProdiProgramKuliahKelompokKuliahId' => $this->request->getVar('setProdiProgramKuliahKelompokKuliahId'),
                'setProdiProgramKuliahIsAktif' => $this->request->getVar('setProdiProgramKuliahIsAktif') == null ? 0 : 1,
                'setProdiProgramKuliahModifiedBy' => user()->email,
            );
            if ($this->setProdiProgKuliahModel->update($id, $data)) {
                session()->setFlashdata('success', 'Data Prodi Program Kuliah Berhasil Diubah!');
            }
        } else {
            session()->setFlashdata('failed', 'Gagal Mengubah Data Prodi Program Kuliah, Data Sudah Disetting!');
        }

        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url =  $this->request->getServer('HTTP_REFERER');
        if ($this->setProdiProgKuliahModel->delete($id)) {
            session()->setFlashdata('success', 'Data Prodi Program Kuliah Berhasil Dihapus!');
            return redirect()->to($url);
        };
    }
}
