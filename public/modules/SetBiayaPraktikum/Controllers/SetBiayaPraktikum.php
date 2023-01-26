<?php

/* 
This is Controller SetBiayaPraktikum
 */

namespace Modules\SetBiayaPraktikum\Controllers;

use App\Controllers\BaseController;
use Modules\SetProdiProgKuliah\Models\SetProdiProgKuliahModel;
use Modules\SetMatkulDitawarkan\Models\SetMatkulDitawarkanModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\KelompokKuliah\Models\KelompokKuliahModel;
use Modules\JenisBiaya\Models\JenisBiayaModel;
use Modules\KeuTarifTambahan\Models\KeuTarifTambahanModel;


class SetBiayaPraktikum extends BaseController
{
    protected $setMatkulDitawarkanModel;
    protected $setProdiProgKuliahModel;
    protected $prodiModel;
    protected $fakultasModel;
    protected $programKuliahModel;
    protected $kelompokKuliahModel;
    protected $jenisBiayaModel;
    protected $validation;
    protected $keuTarifTambahanModel;
    public function __construct()
    {
        $this->setProdiProgKuliahModel = new SetProdiProgKuliahModel();
        $this->setMatkulDitawarkanModel = new SetMatkulDitawarkanModel();
        $this->prodiModel = new ProdiModel();
        $this->fakultasModel = new FakultasModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->kelompokKuliahModel = new KelompokKuliahModel();
        $this->jenisBiayaModel = new JenisBiayaModel();
        $this->keuTarifTambahanModel = new KeuTarifTambahanModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $sourceData = [];
        $filter = [];
        $tahap = 0;

        if ($this->request->getVar('prodi')) {
            $prodi = explode(',', $this->request->getVar('prodi'));
            $sourceData['prodi'] = $prodi;
            foreach ($prodi as $prd) {
                array_push($filter, ['type' => 'prodi', 'value' => getProdiDetail($prd)[0]->prodiNama, 'id' => $prd]);
            }
            $tahap = getKeuTahap($prodi)[0]->refKeuTahapJumlah;
        }

        $sourceData['tambahan'] = [3];

        if ($this->request->getVar('kelKuliah')) {
            $sourceData['kelKuliah'] = $this->request->getVar('kelKuliah');
            array_push($filter, ['type' => 'kelKuliah', 'value' => getKelompokKuliah($this->request->getVar('kelKuliah'))[0]->kelompokKuliahNama, 'id' => $this->request->getVar('kelKuliah')]);
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
        $currentPage = $this->request->getVar('page_keuTarifTambahan') ? $this->request->getVar('page_keuTarifTambahan') : 1;
        $keuTarifTambahan = $this->keuTarifTambahanModel->getKeuTarifTambahan($sourceData, $fakultas);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Biaya Praktikum",
            'breadcrumb' => ['Setting', 'Biaya Praktikum'],
            'tagihanLain' => $keuTarifTambahan->paginate($this->numberPage, 'keuTarifTambahan'),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'prodiBiro' => $userDetail,
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'kelompokKuliah' => $this->kelompokKuliahModel->getKelompokKuliah()->findAll(),
            'filter' => $filter,
            'tahap' => $tahap,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->keuTarifTambahanModel->pager,
            'validation' => \Config\Services::validation()
        ];
        return view('Modules\SetBiayaPraktikum\Views\setBiayaPraktikum', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');

        $rules = [
            'matkulKurikulum' => rv('required', ['required' => 'Mata kuliah kurikulum harus dipilih!']),
            'tarifLainNominal' => rv('required', ['required' => 'Nominal harus diisi!']),
            'tarifLainDeskripsi' => rv('required', ['required' => 'Desripsi harus diisi!'])
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $matkulKurikulum = $this->request->getVar('matkulKurikulum');
        $where = ['setting_matkul_tawarkan."setMatkulTawarMatkulKurikulumId"' => $matkulKurikulum];
        $matkulTawar = $this->setMatkulDitawarkanModel->getMatkulTawarPrak($where)->get()->getResult();
        $mk = [];
        foreach ($matkulTawar as $dt) {
            array_push($mk, $dt->setMatkulTawarId);
        }
        $prodi = explode(",", $this->request->getVar('tarifLainProdiId'));

        foreach ($mk as $mkTawar) {
            foreach ($prodi as $dataProdi) {
                $jumlah = $this->keuTarifTambahanModel->dataExist(
                    [
                        'tarifLainProdiId' => $dataProdi,
                        'tarifLainKelompokKuliahId' => $this->request->getVar('tarifLainKelompokKuliahId'),
                        'tarifLainJenisBiayaId' => 8,
                        'tarifLainMatkulTawarId' => $mkTawar,
                    ]
                );
                if ($jumlah == 0) {
                    $data = array(
                        'tarifLainProdiId' => $dataProdi,
                        'tarifLainKelompokKuliahId' => $this->request->getVar('tarifLainKelompokKuliahId'),
                        'tarifLainSemester' => '0',
                        'tarifLainMatkulTawarId' => $mkTawar,
                        'tarifLainNominal' => $this->request->getVar('tarifLainNominal'),
                        'tarifLainKodeBayar' => 9,
                        'tarifLainJenisBiayaId' => 8,
                        'tarifLainIncludeTahap' => $this->request->getVar('tarifLainIncludeTahap'),
                        'tarifLainDeskripsi' => $this->request->getVar('tarifLainDeskripsi'),
                        'tarifLainCreatedBy' => user()->email,
                    );
                    if ($this->keuTarifTambahanModel->insert($data)) {
                        session()->setFlashdata('success', 'Data Tarif Biaya Praktikum Berhasil Ditambahkan!');
                    }
                } else {
                    session()->setFlashdata('failed', 'Data Tarif Biaya Praktikum Sudah Disetting!');
                }
            }
        }

        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'tarifLainNominal' => rv('required', ['required' => 'Nominal harus diisi!']),
            'tarifLainDeskripsi' => rv('required', ['required' => 'Desripsi harus diisi!'])
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'tarifLainProdiId' => $this->request->getVar('tarifLainProdiId'),
            'tarifLainKelompokKuliahId' => $this->request->getVar('tarifLainKelompokKuliahId'),
            'tarifLainSemester' => '0',
            'tarifLainMatkulTawarId' => $this->request->getVar('tarifLainMatkulTawarId'),
            'tarifLainNominal' => $this->request->getVar('tarifLainNominal'),
            'tarifLainKodeBayar' => 9,
            'tarifLainJenisBiayaId' => 8,
            'tarifLainIncludeTahap' => $this->request->getVar('tarifLainIncludeTahap'),
            'tarifLainDeskripsi' => $this->request->getVar('tarifLainDeskripsi'),
            'tarifLainModifiedBy' => user()->email,
        );

        if ($this->keuTarifTambahanModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Tarif Biaya Praktikum Berhasil Diupdate!');
        }
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->keuTarifTambahanModel->delete($id)) {
            session()->setFlashdata('success', 'Data Tarif Tambahan Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
