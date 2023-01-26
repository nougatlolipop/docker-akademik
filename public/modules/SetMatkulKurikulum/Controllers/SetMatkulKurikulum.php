<?php

/* 
This is Controller SetMatkulKurikulum
 */

namespace Modules\SetMatkulKurikulum\Controllers;

use App\Controllers\BaseController;
use Modules\SetMatkulKurikulum\Models\SetMatkulKurikulumModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\Kurikulum\Models\KurikulumModel;
use Modules\Matkul\Models\MatkulModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\StudiLevel\Models\StudiLevelModel;
use Modules\SetKurikulumDitawarkan\Models\SetKurikulumDitawarkanModel;

class SetMatkulKurikulum extends BaseController
{
    protected $setMatkulKurikulumModel;
    protected $prodiModel;
    protected $programKuliahModel;
    protected $matkulModel;
    protected $kurikulumModel;
    protected $fakultasModel;
    protected $studiLevelModel;
    protected $setKurikulumDitawarkanModel;
    protected $validation;
    public function __construct()
    {
        $this->setMatkulKurikulumModel = new SetMatkulKurikulumModel();
        $this->prodiModel = new ProdiModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->kurikulumModel = new KurikulumModel();
        $this->fakultasModel = new FakultasModel();
        $this->matkulModel = new MatkulModel();
        $this->studiLevelModel = new StudiLevelModel();
        $this->setKurikulumDitawarkanModel = new SetKurikulumDitawarkanModel();
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

        if ($this->request->getVar('kurikulum')) {
            $sourceData['kurikulum'] = $this->request->getVar('kurikulum');
            array_push($filter, ['type' => 'kurikulum', 'value' => getKurikulum($this->request->getVar('kurikulum'))[0]->kurikulumNama, 'id' => $this->request->getVar('kurikulum')]);
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

        // dd($sourceData);
        $setMatkulKurikulum = $this->setMatkulKurikulumModel->getSetMatkulKurikulum($sourceData, $fakultas);
        $currentPage = $this->request->getVar('page_setMatkulKurikulum') ? $this->request->getVar('page_setMatkulKurikulum') : 1;
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Mata Kuliah Kurikulum",
            'breadcrumb' => ['Setting', 'Penawaran Akademik', 'Mata Kuliah Kurikulum'],
            'setMatkulKurikulum' => $setMatkulKurikulum->paginate($this->numberPage, 'setMatkulKurikulum'),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'prodiBiro' => $userDetail,
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'kurikulumDitawarkan' => $this->setKurikulumDitawarkanModel->getSetKurikulumDitawarkan()->findAll(),
            'kurikulum' => $this->kurikulumModel->getKurikulum()->findAll(),
            'matkul' => $this->matkulModel->getMatkul()->findAll(),
            'matkulGroup' => $this->setMatkulKurikulumModel->getMatkulGroup()->get()->getResult(),
            'studiLevel' => $this->studiLevelModel->getStudiLevel()->findAll(),
            'currentPage' => $currentPage,
            'filter' => $filter,
            'numberPage' => $this->numberPage,
            'pager' => $this->setMatkulKurikulumModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\SetMatkulKurikulum\Views\setMatkulKurikulum', $data);
    }

    public function kurikulum()
    {
        $prodi = $this->request->getVar('prodiAkademik');
        $programKuliah = $this->request->getVar('programKuliahAkademik');
        $where = ['setting_kurikulum_tawarkan."setKurikulumTawarProdiId"' => $prodi, 'setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"' => $programKuliah];
        $kurikulumAkademik = $this->setKurikulumDitawarkanModel->kurikulumAkademik($where)->get()->getResult();
        $lists = "<option value=''>Pilih Kurikulum</option>";
        foreach ($kurikulumAkademik  as $data) {
            $lists .= "<option value='" . $data->kurikulumId . "'>" . $data->kurikulumNama .  "</option>";
        }
        $callback = array('list_kurikulum' => $lists);
        echo json_encode($callback);
    }

    public function kurikulumDitawarkan()
    {
        $whereIn = explode(',', $this->request->getVar('prodiAkademik'));
        $programKuliah = $this->request->getVar('programKuliahAkademik');
        $kurikulum = $this->request->getVar('kurikulumAkademik');
        $where = ['setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"' => $programKuliah, 'dt_kurikulum."kurikulumId"' => $kurikulum];
        $kurikulumAkademik = $this->setKurikulumDitawarkanModel->kurikulumAkademikDitawarkan($where, $whereIn)->get()->getResult();
        $lists = "";
        foreach ($kurikulumAkademik  as $data) {
            $lists .= "<option value='" . $data->setKurikulumTawarId . "'>" . $data->prodiNama . " / " . $data->kurikulumNama . " - Angkatan " . $data->setKurikulumTawarAngkatan . "</option>";
        }
        $callback = array('list_kurikulum' => $lists);
        echo json_encode($callback);
    }

    public function kurikulumDitawarkanEdit()
    {
        $prodi = $this->request->getVar('prodiAkademik');
        $programKuliah = $this->request->getVar('programKuliahAkademik');
        $where = ['setting_kurikulum_tawarkan."setKurikulumTawarProdiId"' => $prodi, 'setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"' => $programKuliah];
        $kurikulumAkademik = $this->setKurikulumDitawarkanModel->kurikulumAkademikDitawarkan($where)->get()->getResult();
        $lists = "";
        foreach ($kurikulumAkademik  as $data) {
            $lists .= "<option value='" . $data->setKurikulumTawarId . "'>" . $data->prodiNama . " / " . $data->kurikulumNama . " - Angkatan " . $data->setKurikulumTawarAngkatan . "</option>";
        }
        $callback = array('list_kurikulum' => $lists);
        echo json_encode($callback);
    }

    public function matkulProdi()
    {
        $whereIn = explode(',', $this->request->getVar('prodiAkademik'));
        $matkulProdi = $this->matkulModel->matkulProdi($whereIn)->get()->getResult();
        $matkulGroup = $this->setMatkulKurikulumModel->getMatkulGroup()->get()->getResult();
        $result = [];
        array_push($result, $matkulProdi, $matkulGroup);
        echo json_encode($result);
    }

    public function detailMatkulKurikulum($id)
    {
        $sourceData['setMatkulKurikulumId'] = $id;
        $data = $this->setMatkulKurikulumModel->getSetMatkulKurikulum($sourceData, null)->get()->getResult();
        echo json_encode($data);
    }

    public function add()
    {
        $rules = [
            'setMatkulKurikulumKurikulumTawarId' => rv('required', ['required' => 'Kurikulum ditawarkan harus dipilih!']),
            'setMatkulKurikulumStudiLevelId' => rv('required', ['required' => 'Studi level harus dipilih!']),
        ];
        $url =  $this->request->getServer('HTTP_REFERER');
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $urut = $this->request->getVar('urut');
        $setMatkulKurikulumMatkulId = $this->request->getVar('setMatkulKurikulumMatkulId');
        $setMatkulKurikulumMatkulGroupId = $this->request->getVar('setMatkulKurikulumMatkulGroupId');
        $setMatkulKurikulumSks = $this->request->getVar('setMatkulKurikulumSks');

        $index = [];
        foreach ($urut as $row) {
            array_push($index, $row);
        }

        $groupMk = [];
        $sks = [];
        $matkul = [];
        foreach ($index as $row) {
            array_push($matkul, $setMatkulKurikulumMatkulId[$row]);
            array_push($groupMk, $setMatkulKurikulumMatkulGroupId[$row]);
            array_push($sks, $setMatkulKurikulumSks[$row]);
        }

        $jml = count($urut);
        for ($i = 0; $i < $jml; $i++) {
            $jumlah = $this->setMatkulKurikulumModel->dataExist([
                'setMatkulKurikulumKurikulumTawarId' => $this->request->getVar('setMatkulKurikulumKurikulumTawarId'),
                'setMatkulKurikulumStudiLevelId' => $this->request->getVar('setProdiProgramKuliahProgramKuliahId'),
                'setMatkulKurikulumMatkulId' => $matkul[$i],
            ]);
            if ($jumlah == 0) {
                $data = array(
                    'setMatkulKurikulumKurikulumTawarId' => $this->request->getVar('setMatkulKurikulumKurikulumTawarId'),
                    'setMatkulKurikulumStudiLevelId' => $this->request->getvar('setMatkulKurikulumStudiLevelId'),
                    'setMatkulKurikulumMatkulId' => $matkul[$i],
                    'setMatkulKurikulumMatkulGroupId' => $groupMk[$i],
                    'setMatkulKurikulumSks' => $sks[$i],
                    'setMatkulKurikulumCreatedBy' => user()->email,
                );
                if ($this->setMatkulKurikulumModel->insert($data)) {
                    session()->setFlashdata('success', 'Data Mata Kuliah Kurikulum Berhasil Ditambahkan!');
                }
            } else {
                session()->setFlashdata('failed', 'Data Mata Kuliah Kurikulum Sudah Disetting!');
            }
        }
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url =  $this->request->getServer('HTTP_REFERER');
        $rules = [
            'prodi' => rv('required', ['required' => 'Prodi harus dipilih!']),
            'programKuliah' => rv('required', ['required' => 'Program Kuliah harus dipilih!']),
            'setMatkulKurikulumKurikulumTawarId' => rv('required', ['required' => 'Kurikulum ditawarkan harus dipilih!']),
            'setMatkulKurikulumMatkulId' => rv('required', ['required' => 'Mata kuliah harus dipilih!']),
            'setMatkulKurikulumMatkulGroupId' => rv('required', ['required' => 'Grup mata kuliah harus dipilih!']),
            'setMatkulKurikulumStudiLevelId' => rv('required', ['required' => 'Studi level harus dipilih!']),
            'setMatkulKurikulumSks' => rv('required', ['required' => 'Jumlah SKS harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $setMatkulKurikulumKurikulumTawarId = $this->request->getVar('setMatkulKurikulumKurikulumTawarId');
        $oldSetMatkulKurikulumKurikulumTawarId = $this->request->getVar('oldSetMatkulKurikulumKurikulumTawarId');
        $setMatkulKurikulumStudiLevelId = $this->request->getVar('setMatkulKurikulumStudiLevelId');
        $oldSetMatkulKurikulumStudiLevelId = $this->request->getVar('oldSetMatkulKurikulumStudiLevelId');
        $setMatkulKurikulumMatkulId = $this->request->getVar('setMatkulKurikulumMatkulId');
        $oldSetMatkulKurikulumMatkulId = $this->request->getVar('oldSetMatkulKurikulumMatkulId');

        $cek = ($setMatkulKurikulumKurikulumTawarId == $oldSetMatkulKurikulumKurikulumTawarId && $setMatkulKurikulumStudiLevelId == $oldSetMatkulKurikulumStudiLevelId && $setMatkulKurikulumMatkulId == $oldSetMatkulKurikulumMatkulId) ? 0 : 1;

        if ($cek == 0) {
            $data = array(
                'setMatkulKurikulumKurikulumTawarId' => $setMatkulKurikulumKurikulumTawarId,
                'setMatkulKurikulumStudiLevelId' => $setMatkulKurikulumStudiLevelId,
                'setMatkulKurikulumMatkulGroupId' => $this->request->getVar('setMatkulKurikulumMatkulGroupId'),
                'setMatkulKurikulumMatkulId' => $setMatkulKurikulumMatkulId,
                'setMatkulKurikulumSks' => $this->request->getVar('setMatkulKurikulumSks'),
                'setMatkulKurikulumModifiedBy' => user()->email,
            );
            if ($this->setMatkulKurikulumModel->update($id, $data)) {
                session()->setFlashdata('success', 'Data Mata Kuliah Kurikulum Berhasil Diubah!');
            }
        } else {
            $jumlah = $this->setMatkulKurikulumModel->dataExist([
                'setMatkulKurikulumKurikulumTawarId' => $setMatkulKurikulumKurikulumTawarId,
                'setMatkulKurikulumStudiLevelId' => $setMatkulKurikulumStudiLevelId,
                'setMatkulKurikulumMatkulId' => $setMatkulKurikulumMatkulId,
            ]);
            if ($jumlah == 0) {
                $data = array(
                    'setMatkulKurikulumKurikulumTawarId' => $setMatkulKurikulumKurikulumTawarId,
                    'setMatkulKurikulumStudiLevelId' => $setMatkulKurikulumStudiLevelId,
                    'setMatkulKurikulumMatkulGroupId' => $this->request->getVar('setMatkulKurikulumMatkulGroupId'),
                    'setMatkulKurikulumMatkulId' => $setMatkulKurikulumMatkulId,
                    'setMatkulKurikulumSks' => $this->request->getVar('setMatkulKurikulumSks'),
                    'setMatkulKurikulumModifiedBy' => user()->email,
                );
                if ($this->setMatkulKurikulumModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Data Mata Kuliah Kurikulum Berhasil Diubah!');
                }
            } else {
                session()->setFlashdata('failed', 'Gagal Mengubah Data Mata Kuliah Kurikulum, Data Sudah Disetting!');
            }
        }
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url =  $this->request->getServer('HTTP_REFERER');
        if ($this->setMatkulKurikulumModel->delete($id)) {
            session()->setFlashdata('success', 'Data Mata Kuliah Kurikulum Berhasil Dihapus!');
            return redirect()->to($url);
        };
    }
}
