<?php

/* 
This is Controller KhsMahasiswa
 */

namespace Modules\KhsMahasiswa\Controllers;

use App\Controllers\BaseController;
use Modules\KrsMahasiswa\Models\KrsMahasiswaModel;
use Modules\KhsMahasiswa\Models\KhsMahasiswaModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\WaktuKuliah\Models\WaktuKuliahModel;
use Modules\Nilai\Models\NilaiModel;


class KhsMahasiswa extends BaseController
{

    protected $krsMahasiswaModel;
    protected $fakultasModel;
    protected $prodiModel;
    protected $tahunAjaranModel;
    protected $programKuliahModel;
    protected $waktuKuliahModel;
    protected $khsMahasiswaModel;
    protected $sksDefault;
    protected $validation;
    protected $nilaiModel;

    public function __construct()
    {
        $this->krsMahasiswaModel = new KrsMahasiswaModel();
        $this->khsMahasiswaModel = new KhsMahasiswaModel();
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->waktuKuliahModel = new WaktuKuliahModel();
        $this->nilaiModel = new NilaiModel();
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

        if ($this->request->getVar('pgKuliah')) {
            $sourceData['program_kuliah'] = $this->request->getVar('pgKuliah');
            array_push($filter, ['type' => 'pgKuliah', 'value' => getProgramKuliah($this->request->getVar('pgKuliah'))[0]->programKuliahNama, 'id' => $this->request->getVar('pgKuliah')]);
        }

        if ($this->request->getVar('prodi')) {
            $prodi = explode(',', $this->request->getVar('prodi'));
            $sourceData['prodi'] = $prodi;
            foreach ($prodi as $prd) {
                array_push($filter, ['type' => 'prodi', 'value' => getProdiDetail($prd)[0]->prodiNama, 'id' => $prd]);
            }
        }

        if ($this->request->getVar('wktKuliah')) {
            $waktu = explode(',', $this->request->getVar('wktKuliah'));
            $sourceData['waktuKuliah'] = $waktu;
            foreach ($waktu as $wkt) {
                array_push($filter, ['type' => 'wktKuliah', 'value' => getWaktuKuliahDetail($wkt)[0]->waktuNama, 'id' => $wkt]);
            }
        }

        if ($this->request->getVar('keyword')) {
            $sourceData['keyword'] = $this->request->getVar('keyword');
            array_push($filter, ['type' => 'keyword', 'value' => $this->request->getVar('keyword'), 'id' => $this->request->getVar('keyword')]);
        }

        if ($this->request->getVar('thnAjar')) {
            $sourceData['tahunAjar'] = $this->request->getVar('thnAjar');
            array_push($filter, ['type' => 'thnAjar', 'value' => 'Tahun Ajaran', 'id' => $this->request->getVar('thnAjar')]);
        }

        $userDetail = getUserDetail();
        if (in_groups('Fakultas')) {
            $fakultas = ['dt_prodi."prodiFakultasId"' => $userDetail[0]->fakultasId];
        } else {
            $fakultas = null;
        }

        $currentPage = $this->request->getVar('page_khs') ? $this->request->getVar('page_khs') : 1;
        $khs = $this->khsMahasiswaModel->getKhs($sourceData, $fakultas);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Per Mahasiswa",
            'breadcrumb' => ['Akademik', 'KHS', 'Per Mahasiswa'],
            'numberPage' => $this->numberPage,
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdiForKrs()->findAll(),
            'prodiBiro' => $userDetail,
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'waktuKuliah' => $this->waktuKuliahModel->getWaktuKuliah()->findAll(),
            'validation' => \Config\Services::validation(),
            'nilai' => $this->nilaiModel->getNilai()->findAll(),
            'filter' => $filter,
            'khs' => $khs->paginate($this->numberPage, 'khs'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->khsMahasiswaModel->pager,
        ];
        return view('Modules\KhsMahasiswa\Views\khsMahasiswa', $data);
    }

    public function cari()
    {
        $khsRes = [];
        $npm = $this->request->getVar('npm');
        $where = [
            'akd_khs.khsMahasiswaNpm' => $npm
        ];
        $khs = $this->khsMahasiswaModel->cariKhs($where)->findAll();
        echo json_encode($khs);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $nilaiBaru = [];
        $nilaiSave = [];
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        $thAjar = getTahunAjaranAktif($this->request->getVar('npmKhs'), 'nilai')[0];
        $khs = getKhs($this->request->getVar('npmKhs'), 'nilai')[0];
        for ($i = 0; $i < count($keys); $i++) {
            if (is_numeric($keys[$i])) {
                $sks = getMatkul($keys[$i])[0];
                $nilai = getNilaiAngka([$thAjar->prodiId, $values[$i], nilaiAll($thAjar->prodiId)]); // ????
                $data = [
                    "gradeId" => (int)$values[$i],
                    "matkulId" => (int)$keys[$i],
                    "status" => 1,
                    "nilai" => (float)$nilai->gradeProdiNilaiBobot,
                    "totalNilai" => (float)$nilai->gradeProdiNilaiBobot * (int)$sks->setMatkulKurikulumSks,
                ];
                array_push($nilaiBaru, $data);
            }
        }
        foreach ($nilaiBaru as $mkNew) {
            $data = [
                "gradeId" => $mkNew['gradeId'],
                "matkulId" => $mkNew['matkulId'],
                "status" => $mkNew['status'],
                "nilai" => $mkNew['nilai'],
                "totalNilai" => $mkNew['totalNilai'],
            ];
            array_push($nilaiSave, $data);
        }
        foreach (json_decode($khs->khsNilaiMatkul)->data as $mkOld) {
            $data = [
                "gradeId" => (int)$mkOld->gradeId,
                "matkulId" => (int)$mkOld->matkulId,
                "status" => $mkOld->status,
                "nilai" => $mkOld->nilai,
                "totalNilai" => $mkOld->totalNilai,
            ];
            array_push($nilaiSave, $data);
        }
        $dataEdit = [
            "khsNilaiMatkul" => json_encode(["data" => unique_key($nilaiSave, 'matkulId')]),
            'khsModifiedBy' => user()->email,
        ];
        if ($this->khsMahasiswaModel->update($khs->khsId, $dataEdit)) {
            session()->setFlashdata('success', 'Data Khs Mendapatkan Perubahan!');
            return redirect()->to($url);
        }
    }
}
