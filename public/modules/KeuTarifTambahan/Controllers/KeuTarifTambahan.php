<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuTarifTambahan\Controllers;

use App\Controllers\BaseController;
use Modules\SetProdiProgKuliah\Models\SetProdiProgKuliahModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\KelompokKuliah\Models\KelompokKuliahModel;
use Modules\JenisBiaya\Models\JenisBiayaModel;
use Modules\KeuTarifTambahan\Models\KeuTarifTambahanModel;

class KeuTarifTambahan extends BaseController
{
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
            if ($this->request->getVar('prodi') != '99') {
                $prodi = explode(',', $this->request->getVar('prodi'));
                $sourceData['prodi'] = $prodi;
                foreach ($prodi as $prd) {
                    array_push($filter, ['type' => 'prodi', 'value' => getProdiDetail($prd)[0]->prodiNama, 'id' => $prd]);
                }
            } else if ($this->request->getVar('prodi') == '99') {
                $prodi = [];
                foreach ($this->prodiModel->getProdi()->findAll() as $prd) {
                    array_push($prodi, $prd->prodiId);
                }
                $sourceData['prodi'] = null;
                array_push($filter, ['type' => 'prodi', 'value' => 'Semua Prodi', 'id' => 99]);
            }
            $tahap = getKeuTahap($prodi)[0]->refKeuTahapJumlah;
        }

        $sourceData['tambahan'] = [2];

        if ($this->request->getVar('jenisBiaya')) {
            $jenisBiaya = explode(',', $this->request->getVar('jenisBiaya'));
            $sourceData['jenisBiaya'] = $jenisBiaya;
            foreach ($jenisBiaya as $biaya) {
                array_push($filter, ['type' => 'jenisBiaya', 'value' => getJenisBiaya($biaya)[0]->refJenisBiayaNama, 'id' => $biaya]);
            }
        }

        if ($this->request->getVar('kelKuliah')) {
            $sourceData['kelKuliah'] = $this->request->getVar('kelKuliah');
            array_push($filter, ['type' => 'kelKuliah', 'value' => getKelompokKuliah($this->request->getVar('kelKuliah'))[0]->kelompokKuliahNama, 'id' => $this->request->getVar('kelKuliah')]);
        }

        if ($this->request->getVar('keyword')) {
            $sourceData['keyword'] = $this->request->getVar('keyword');
            array_push($filter, ['type' => 'keyword', 'value' => $this->request->getVar('keyword'), 'id' => $this->request->getVar('keyword')]);
        }

        $currentPage = $this->request->getVar('page_keuTarifTambahan') ? $this->request->getVar('page_keuTarifTambahan') : 1;
        $setProdiProgKuliah = $this->keuTarifTambahanModel->getKeuTarifTambahan($sourceData);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Tarif Tambahan",
            'breadcrumb' => ['Keuangan', 'Tarif', 'Biaya Tambahan'],
            'tagihanLain' => $setProdiProgKuliah->paginate($this->numberPage, 'keuTarifTambahan'),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'kelompokKuliah' => $this->kelompokKuliahModel->getKelompokKuliah()->findAll(),
            'tagihan' => $this->jenisBiayaModel->jenisTagihan('lain')->findAll(),
            'filter' => $filter,
            'tahap' => $tahap,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->keuTarifTambahanModel->pager,
            'validation' => \Config\Services::validation()
        ];
        return view('Modules\KeuTarifTambahan\Views\keuTarifTambahan', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');

        $rules = [
            'tarifLainNominal' => rv('required', ['required' => 'Nominal harus diisi!']),
            'tarifLainDeskripsi' => rv('required', ['required' => 'Deskripsi harus diisi!'])
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $prodi = explode(",", $this->request->getVar('tarifLainProdiId'));
        $biaya = explode(",", $this->request->getVar('tarifLainJenisBiayaId'));

        foreach ($biaya as $dataBiaya) {
            foreach ($prodi as $dataProdi) {
                $jumlah = $this->keuTarifTambahanModel->dataExist(
                    [
                        'tarifLainProdiId' => ($dataProdi == 99) ? null : $dataProdi,
                        'tarifLainKelompokKuliahId' => $this->request->getVar('tarifLainKelompokKuliahId'),
                        'tarifLainJenisBiayaId' => $dataBiaya,
                    ]
                );
                if ($jumlah == 0) {
                    $data = array(
                        'tarifLainProdiId' => ($dataProdi == 99) ? null : $dataProdi,
                        'tarifLainKelompokKuliahId' => $this->request->getVar('tarifLainKelompokKuliahId'),
                        'tarifLainSemester' => $this->request->getVar('tarifLainSemester'),
                        'tarifLainNominal' => $this->request->getVar('tarifLainNominal'),
                        'tarifLainIsAllowedAmount' => $this->request->getVar('tarifLainIsAllowedAmount') == null ? '0' : '1',
                        'tarifLainKodeBayar' => 9,
                        'tarifLainJenisBiayaId' => $dataBiaya,
                        'tarifLainIncludeTahap' => $this->request->getVar('tarifLainIncludeTahap'),
                        'tarifLainDeskripsi' => $this->request->getVar('tarifLainDeskripsi'),
                        'tarifLainCreatedBy' => user()->email,
                    );
                    if ($this->keuTarifTambahanModel->insert($data)) {
                        session()->setFlashdata('success', 'Data Tarif Tambahan Berhasil Ditambahkan!');
                    }
                } else {
                    session()->setFlashdata('failed', 'Data Tarif Tambahan Sudah Disetting!');
                }
            }
        }

        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');

        $rules = [
            'tarifLainJenisBiayaId' => rv('required', ['required' => 'Jenis biaya harus dipilih!']),
            'tarifLainNominal' => rv('required', ['required' => 'Nominal harus diisi!']),
            'tarifLainDeskripsi' => rv('required', ['required' => 'Deskripsi harus diisii!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $tarifLainJenisBiayaId = $this->request->getVar('tarifLainJenisBiayaId');
        $oldTarifLainJenisBiayaId = $this->request->getVar('oldTarifLainJenisBiayaId');
        $cek = ($tarifLainJenisBiayaId == $oldTarifLainJenisBiayaId) ? 0 : 1;

        if ($cek == 0) {
            $data = array(
                'tarifLainProdiId' => ($this->request->getVar('tarifLainProdiId') == '') ? null : $this->request->getVar('tarifLainProdiId'),
                'tarifLainKelompokKuliahId' => $this->request->getVar('tarifLainKelompokKuliahId'),
                'tarifLainSemester' => $this->request->getVar('tarifLainSemester'),
                'tarifLainKodeBayar' => 9,
                'tarifLainNominal' => $this->request->getVar('tarifLainNominal'),
                'tarifLainIsAllowedAmount' => $this->request->getVar('tarifLainIsAllowedAmount') == null ? '0' : '1',
                'tarifLainJenisBiayaId' => $tarifLainJenisBiayaId,
                'tarifLainIncludeTahap' => $this->request->getVar('tarifLainIncludeTahap'),
                'tarifLainDeskripsi' => $this->request->getVar('tarifLainDeskripsi'),
                'tarifLainModifiedBy' => user()->email,
            );
            if ($this->keuTarifTambahanModel->update($id, $data)) {
                session()->setFlashdata('success', 'Data Tarif Tambahan Berhasil Diupdate!');
            }
        } else {
            $jumlah = $this->keuTarifTambahanModel->dataExist(
                [
                    'tarifLainProdiId' => ($this->request->getVar('tarifLainProdiId') == '') ? null : $this->request->getVar('tarifLainProdiId'),
                    'tarifLainKelompokKuliahId' => $this->request->getVar('tarifLainKelompokKuliahId'),
                    'tarifLainJenisBiayaId' => $tarifLainJenisBiayaId,
                ]
            );
            if ($jumlah == 0) {
                $data = array(
                    'tarifLainProdiId' => ($this->request->getVar('tarifLainProdiId') == '') ? null : $this->request->getVar('tarifLainProdiId'),
                    'tarifLainKelompokKuliahId' => $this->request->getVar('tarifLainKelompokKuliahId'),
                    'tarifLainSemester' => $this->request->getVar('tarifLainSemester'),
                    'tarifLainKodeBayar' => 9,
                    'tarifLainNominal' => $this->request->getVar('tarifLainNominal'),
                    'tarifLainIsAllowedAmount' => $this->request->getVar('tarifLainIsAllowedAmount') == null ? '0' : '1',
                    'tarifLainJenisBiayaId' => $tarifLainJenisBiayaId,
                    'tarifLainIncludeTahap' => $this->request->getVar('tarifLainIncludeTahap'),
                    'tarifLainDeskripsi' => $this->request->getVar('tarifLainDeskripsi'),
                    'tarifLainModifiedBy' => user()->email,
                );
                if ($this->keuTarifTambahanModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Data Tarif Tambahan Berhasil Diupdate!');
                }
            } else {
                session()->setFlashdata('failed', 'Gagal Mengubah Data Tarif Tambahan, Data Sudah Disetting!');
            }
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
