<?php

/* 
This is Controller KeuTahap
 */

namespace Modules\KeuTahap\Controllers;

use App\Controllers\BaseController;
use Modules\KeuTahap\Models\KeuTahapModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\DataMahasiswa\Models\DataMahasiswaModel;
use Modules\SetProdiProgKuliah\Models\SetProdiProgKuliahModel;
use Modules\Semester\Models\SemesterModel;


class KeuTahap extends BaseController
{
    protected $keuTahapModel;
    protected $prodiModel;
    protected $programKuliahModel;
    protected $fakultasModel;
    protected $dataMahasiswaModel;
    protected $setProdiProgKuliahModel;
    protected $semesterModel;
    protected $validation;
    public function __construct()
    {
        $this->keuTahapModel = new KeuTahapModel();
        $this->prodiModel = new ProdiModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->fakultasModel = new FakultasModel();
        $this->dataMahasiswaModel = new DataMahasiswaModel();
        $this->setProdiProgKuliahModel = new SetProdiProgKuliahModel();
        $this->semesterModel = new SemesterModel();
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
        $currentPage = $this->request->getVar('page_keuTahap') ? $this->request->getVar('page_keuTahap') : 1;
        $keuTahap = $this->keuTahapModel->getKeuTahap($sourceData);

        // dd($this->dataMahasiswaModel->getWhere(['mahasiswaNpm' => '2202050001'])[0]->getResult());

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Tahap Pembayaran",
            'breadcrumb' => ['Keuangan', 'Setting', 'Tahap Pembayaran'],
            'keuTahap' => $keuTahap->paginate($this->numberPage, 'keuTahap'),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'filter' => $filter,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->keuTahapModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KeuTahap\Views\keuTahap', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'refKeuTahapAngkatan' => rv('required', ['required' => 'Angkatan harus diisi!']),
            'refKeuTahapJumlah' => rv('required', ['required' => 'Jumlah tahap harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $prodi = explode(",", $this->request->getVar('refKeuTahapProdiId'));
        $tahap = ($this->request->getVar('refKeuTahapHer') == null) ? null : json_encode(array_map('intval', $this->request->getVar('refKeuTahapHer')));

        foreach ($prodi as $dataProdi) {
            $jumlah = $this->keuTahapModel->dataExist([
                'refKeuTahapProdiId' => $dataProdi,
                'refKeuTahapProgramKuliahId' => $this->request->getVar('refKeuTahapProgramKuliahId'),
                'refKeuTahapAngkatan' => $this->request->getVar('refKeuTahapAngkatan'),
            ]);

            if ($jumlah == 0) {
                $data = array(
                    'refKeuTahapProdiId' => $dataProdi,
                    'refKeuTahapProgramKuliahId' => $this->request->getVar('refKeuTahapProgramKuliahId'),
                    'refKeuTahapAngkatan' => $this->request->getVar('refKeuTahapAngkatan'),
                    'refKeuTahapJumlah' => $this->request->getVar('refKeuTahapJumlah'),
                    'refKeuTahapIsHer' => ($this->request->getVar('refKeuTahapIsHer') == null) ? null : $this->request->getVar('refKeuTahapIsHer'),
                    'refKeuTahapHer' => $tahap,
                    'refKeuTahapCreatedBy' => user()->email,
                );
                if ($this->keuTahapModel->insert($data)) {
                    session()->setFlashdata('success', 'Data Tahap Pembayaran Berhasil Ditambahkan!');
                }
            } else {
                session()->setFlashdata('failed', 'Data Tahap Pembayaran Sudah Disetting!');
            }
        }

        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'refKeuTahapAngkatan' => rv('required', ['required' => 'Angkatan harus diisi!']),
            'refKeuTahapJumlah' => rv('required', ['required' => 'Jumlah tahap harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $refKeuTahapAngkatan = $this->request->getVar('refKeuTahapAngkatan');
        $oldRefKeuTahapAngkatan = $this->request->getVar('oldRefKeuTahapAngkatan');
        $cek = ($refKeuTahapAngkatan == $oldRefKeuTahapAngkatan) ? 0 : 1;

        if ($cek == 0) {
            $data = array(
                'refKeuTahapProdiId' => $this->request->getVar('refKeuTahapProdiId'),
                'refKeuTahapProgramKuliahId' => $this->request->getVar('refKeuTahapProgramKuliahId'),
                'refKeuTahapAngkatan' =>  $refKeuTahapAngkatan,
                'refKeuTahapJumlah' => $this->request->getVar('refKeuTahapJumlah'),
                'refKeuTahapModifiedBy' => user()->email,
            );
            if ($this->keuTahapModel->update($id, $data)) {
                session()->setFlashdata('success', 'Data Tahap Pembayaran Berhasil Diubah!');
            }
        } else {
            $jumlah = $this->keuTahapModel->dataExist([
                'refKeuTahapProdiId' => $this->request->getVar('refKeuTahapProdiId'),
                'refKeuTahapProgramKuliahId' => $this->request->getVar('refKeuTahapProgramKuliahId'),
                'refKeuTahapAngkatan' =>  $refKeuTahapAngkatan,
            ]);
            if ($jumlah == 0) {
                $data = array(
                    'refKeuTahapProdiId' => $this->request->getVar('refKeuTahapProdiId'),
                    'refKeuTahapProgramKuliahId' => $this->request->getVar('refKeuTahapProgramKuliahId'),
                    'refKeuTahapAngkatan' =>  $refKeuTahapAngkatan,
                    'refKeuTahapJumlah' => $this->request->getVar('refKeuTahapJumlah'),
                    'refKeuTahapModifiedBy' => user()->email,
                );
                if ($this->keuTahapModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Data Tahap Pembayaran Berhasil Diubah!');
                }
            } else {
                session()->setFlashdata('failed', 'Gagal Mengubah Data Tahap Pembayaran, Data Sudah Disetting!');
            }
        }

        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->keuTahapModel->delete($id)) {
            session()->setFlashdata('success', 'Data Tahap Pembayaran Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }

    public function jumlahTahap()
    {
        $npm = $this->request->getVar('npm');
        $dtMhs = $this->dataMahasiswaModel->getWhere(['mahasiswaNpm' => $npm])->getResult();
        foreach ($dtMhs as $key => $mhs) {
            $prodiProg = $mhs->mahasiswaProdiProgramKuliahId;
            $angkatan = $mhs->mahasiswaAngkatan;
        }
        $dtProdiProg = $this->setProdiProgKuliahModel->getWhere(['setProdiProgramKuliahId' => $prodiProg])->getResult();
        foreach ($dtProdiProg as $key => $ppg) {
            $prodi = $ppg->setProdiProgramKuliahProdiId;
            $programKuliah = $ppg->setProdiProgramKuliahProgramKuliahId;
        }
        $tahap = "";
        $tahap .= $this->keuTahapModel->getWhere(['refKeuTahapProdiId' => $prodi, 'refKeuTahapProgramKuliahId' => $programKuliah, 'refKeuTahapAngkatan' => $angkatan])->getResult()[0]->refKeuTahapJumlah;
        $dtTahap = ['data_tahap' => $tahap];
        echo json_encode($dtTahap);
    }
}
