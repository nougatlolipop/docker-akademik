<?php

/* 
This is Controller SetKurikulumDitawarkan
 */

namespace Modules\SetKurikulumDitawarkan\Controllers;

use App\Controllers\BaseController;
use Modules\SetKurikulumDitawarkan\Models\SetKurikulumDitawarkanModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\Kurikulum\Models\KurikulumModel;

class SetKurikulumDitawarkan extends BaseController
{
    protected $setKurikulumDitawarkanModel;
    protected $prodiModel;
    protected $programKuliahModel;
    protected $fakultasModel;
    protected $kurikulumModel;
    protected $validation;
    public function __construct()
    {
        $this->setKurikulumDitawarkanModel = new SetKurikulumDitawarkanModel();
        $this->prodiModel = new ProdiModel();
        $this->fakultasModel = new FakultasModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->kurikulumModel = new KurikulumModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $sourceData = [];
        $filter = [];

        if ($this->request->getVar('angMin')) {
            $sourceData['angkatan_min'] = $this->request->getVar('angMin');
            array_push($filter, ['type' => 'angMin', 'value' => 'Angkatan Terkecil', 'id' => $this->request->getVar('angMin')]);
        }

        if ($this->request->getVar('angMax')) {
            $sourceData['angkatan_max'] = $this->request->getVar('angMax');
            array_push($filter, ['type' => 'angMax', 'value' => 'Angkatan Terbesar', 'id' => $this->request->getVar('angMax')]);
        }

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
        $currentPage = $this->request->getVar('page_setKurikulumDitawarkan') ? $this->request->getVar('page_setKurikulumDitawarkan') : 1;
        $setKurikulumDitawarkan = $this->setKurikulumDitawarkanModel->getSetKurikulumDitawarkan($sourceData, $fakultas);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Kurikulum Ditawarkan",
            'breadcrumb' => ['Setting', 'Penawaran Akademik', 'Kurikulum Ditawarkan'],
            'setKurikulumDitawarkan' => $setKurikulumDitawarkan->paginate($this->numberPage, 'setKurikulumDitawarkan'),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodiBiro' => $userDetail,
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'kurikulum' => $this->kurikulumModel->getKurikulum()->findAll(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'filter' => $filter,
            'pager' => $this->setKurikulumDitawarkanModel->pager,
            'validation' => \Config\Services::validation()
        ];

        return view('Modules\SetKurikulumDitawarkan\Views\setKurikulumDitawarkan', $data);
    }

    public function programKuliah()
    {
        $prodi = $this->request->getVar('prodiAkademik');
        $where = ['setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"' => $prodi];
        $programKuliahAkademik = $this->programKuliahModel->programKuliahAkademik($where)->get()->getResult();
        $lists = "";
        foreach ($programKuliahAkademik  as $data) {
            $lists .= "<option value='" . $data->programKuliahId . "'>" . $data->programKuliahNama . "</option>";
        }
        $callback = array('list_program_kuliah' => $lists);
        echo json_encode($callback);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'setKurikulumTawarAngkatan' => rv('required', ['required' => 'Angkatan harus dipilih!']),
            'setKurikulumTawarKurikulumId' => rv('required', ['required' => 'Kurikulum harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $prodi = explode(",", $this->request->getVar('setKurikulumTawarProdiId'));

        foreach ($prodi as $dataProdi) {
            $jumlah = $this->setKurikulumDitawarkanModel->dataExist([
                'setKurikulumTawarProdiId' => $dataProdi,
                'setKurikulumTawarProgramKuliahId' => $this->request->getVar('setKurikulumTawarProgramKuliahId'),
                'setKurikulumTawarAngkatan' => $this->request->getVar('setKurikulumTawarAngkatan'),
                'setKurikulumTawarKurikulumId' => $this->request->getVar('setKurikulumTawarKurikulumId'),
            ]);
            if ($jumlah == 0) {
                $data = array(
                    'setKurikulumTawarProdiId' => $dataProdi,
                    'setKurikulumTawarProgramKuliahId' => $this->request->getVar('setKurikulumTawarProgramKuliahId'),
                    'setKurikulumTawarAngkatan' => $this->request->getVar('setKurikulumTawarAngkatan'),
                    'setKurikulumTawarKurikulumId' => $this->request->getVar('setKurikulumTawarKurikulumId'),
                    'setKurikulumTawarCreatedBy' => user()->email,
                );
                if ($this->setKurikulumDitawarkanModel->insert($data)) {
                    session()->setFlashdata('success', 'Data Kurikulum Ditawarkan Berhasil Ditambahkan!');
                }
            } else {
                session()->setFlashdata('failed', 'Data Kurikulum Ditawarkan Sudah Disetting!');
            }
        }
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');

        $rules = [
            'setKurikulumTawarProdiId' => rv('required', ['required' => 'Prodi harus dipilih!']),
            'setKurikulumTawarProgramKuliahId' => rv('required', ['required' => 'Program kuliah harus dipilih!']),
            'setKurikulumTawarAngkatan' => rv('required', ['required' => 'Angkatan harus dipilih!']),
            'setKurikulumTawarKurikulumId' => rv('required', ['required' => 'Kurikulum harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $jumlah = $this->setKurikulumDitawarkanModel->dataExist([
            'setKurikulumTawarProdiId' => $this->request->getVar('setKurikulumTawarProdiId'),
            'setKurikulumTawarProgramKuliahId' => $this->request->getVar('setKurikulumTawarProgramKuliahId'),
            'setKurikulumTawarAngkatan' => $this->request->getVar('setKurikulumTawarAngkatan'),
            'setKurikulumTawarKurikulumId' => $this->request->getVar('setKurikulumTawarKurikulumId'),
        ]);
        if ($jumlah == 0) {
            $data = array(
                'setKurikulumTawarProdiId' => $this->request->getVar('setKurikulumTawarProdiId'),
                'setKurikulumTawarProgramKuliahId' => $this->request->getVar('setKurikulumTawarProgramKuliahId'),
                'setKurikulumTawarAngkatan' => $this->request->getVar('setKurikulumTawarAngkatan'),
                'setKurikulumTawarKurikulumId' => $this->request->getVar('setKurikulumTawarKurikulumId'),
                'setKurikulumTawarModifiedBy' => user()->email,
            );
            if ($this->setKurikulumDitawarkanModel->update($id, $data)) {
                session()->setFlashdata('success', 'Data Kurikulum Ditawarkan Berhasil Diubah!');
            }
        } else {
            session()->setFlashdata('failed', 'Gagal Mengubah Data Kurikulum Ditawarkan, Data Sudah Disetting!');
        }

        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->setKurikulumDitawarkanModel->delete($id)) {
            session()->setFlashdata('success', 'Data Kurikulum Ditawarkan Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
