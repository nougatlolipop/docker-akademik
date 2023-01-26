<?php

/* 
This is Controller SetMatkulDitawarkan
 */

namespace Modules\KhsKelas\Controllers;

use App\Controllers\BaseController;
use Modules\KhsKelas\Models\KhsKelasModel;
use Modules\SetMatkulKurikulum\Models\SetMatkulKurikulumModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\SetProdiProgKuliah\Models\SetProdiProgKuliahModel;
use Modules\Dosen\Models\DosenModel;
use Modules\Tagihan\Models\TagihanModel;
use Modules\Kelas\Models\KelasModel;
use Modules\Nilai\Models\NilaiModel;
use Modules\SetMatkulDitawarkan\Models\SetMatkulDitawarkanModel;

class KhsKelas extends BaseController
{

    protected $khsKelasModel;
    protected $setMatkulKurikulumModel;
    protected $prodiModel;
    protected $fakultasModel;
    protected $programKuliahModel;
    protected $setProdiProgKuliahModel;
    protected $dosenModel;
    protected $kelasModel;
    protected $tahunAjaranModel;
    protected $tagihanModel;
    protected $validation;
    protected $tagihan;
    protected $nilaiModel;
    protected $setMatkulDitawarkanModel;

    public function __construct()
    {
        $this->setMatkulDitawarkanModel = new SetMatkulDitawarkanModel();
        $this->khsKelasModel = new KhsKelasModel();
        $this->setMatkulKurikulumModel = new SetMatkulKurikulumModel();
        $this->prodiModel = new ProdiModel();
        $this->fakultasModel = new FakultasModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->setProdiProgKuliahModel = new SetProdiProgKuliahModel();
        $this->dosenModel = new DosenModel();
        $this->kelasModel = new KelasModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
        $this->tagihanModel = new TagihanModel();
        $this->nilaiModel = new NilaiModel();
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
        if ($this->request->getVar('thnAjar')) {
            $sourceData['tahunAjar'] = $this->request->getVar('thnAjar');
            array_push($filter, ['type' => 'thnAjar', 'value' => 'Tahun Ajaran', 'id' => $this->request->getVar('thnAjar')]);
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

        $currentPage = $this->request->getVar('page_khskelas') ? $this->request->getVar('page_khskelas') : 1;
        $khsKelasModel = $this->setMatkulDitawarkanModel->getMatkultawar($sourceData, $fakultas);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Per Kelas",
            'breadcrumb' => ['Akademik', 'KHS', 'Per Kelas'],
            'setMatkulDitawarkan' => $khsKelasModel->paginate($this->numberPage, 'khskelas'),
            'setMatkulKurikulum' => $this->setMatkulKurikulumModel->getSetMatkulKurikulum()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'prodiBiro' => $userDetail,
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'filter' => $filter,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->setMatkulDitawarkanModel->pager,
            'nilai' => $this->nilaiModel->getNilai()->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KhsKelas\Views\khsKelas', $data);
    }

    public function cari()
    {
        $npm = $this->request->getVar('npm');
        $kelas = $this->request->getVar('kelas');
        $ta = getTahunAjaranAktif($npm, 'krs')[0];
        $tahunAjar = $ta->setJadwalAkademikTahunAjaranId;
        $tahun = $ta->tahunAjaranKode;
        $semester = $ta->semesterKode;
        $noReg = $ta->mahasiswaNoDaftar;

        $initInfo = [$npm, $kelas, $tahunAjar];

        $mkDitawarkan = $this->setMatkulDitawarkanModel->cariMatkulDitawarkan($initInfo)->findAll();


        $dataCek = [
            'keu_tagihan."tagihNoDaftar"' => $noReg,
            'keu_tagihan."tagihTahunAjaran"' => $ta->setJadwalAkademikTahunAjaranId,
            'keu_tagihan_detail."tagihanDetailIsPaid"' => '0'
        ];

        if ($ta->semesterKode == 'Ganjil') {
            $krsInit = 'krsGanjil'; //constant
        } else {
            $krsInit = 'krsGenap'; //constant
        }
        $tunggakan = $this->tagihanModel->cekTunggakan($dataCek, $krsInit)->getResult();


        if (count($tunggakan) > 0) {
            $response = ['status' => false, 'message' => 'Mahasiswa Masih Memiliki Tunggakan pra-syarat', 'data' => $tunggakan, 'tahunAjaran' => $tahun, 'semester' => $semester, 'noReg' => $noReg];
        } else {
            if (count($mkDitawarkan) > 0) {
                $response = ['status' => true, 'message' => 'Data ditemukan', 'data' => $mkDitawarkan, 'tahunAjaran' => $tahun, 'semester' => $semester, 'noReg' => $noReg];
            } else {
                $response = ['status' => false, 'message' => 'Tidak ada data', 'data' => [], 'tahunAjaran' => $tahun, 'semester' => $semester, 'noReg' => $noReg];
            }
        }

        echo json_encode($response);
    }

    public function getTakenKrs()
    {
        $ta = $this->request->getVar('where')[0];
        $prodi = $this->request->getVar('where')[1];
        $programKuliah = $this->request->getVar('where')[2];
        $mkTawarId = $this->request->getVar('matkulTawarId');

        $where = [
            'akd_khs."khsTahunAjaranId"' => $ta,
            'dt_prodi."prodiId"' => $prodi,
            'dt_program_kuliah."programKuliahId"' => $programKuliah,
        ];

        $data = $this->khsKelasModel->getTakenKrs($where)->findAll();
        $formNilai = $this->nilaiModel->getNilai()->findAll();

        $result = [];
        foreach ($data as $row) {
            foreach (json_decode($row->khsNilaiMatkul)->data as $nilai) {
                if ($nilai->matkulId == $mkTawarId) {
                    $mk = getMatkul($mkTawarId)[0];
                    array_push($result, [
                        "mahasiswaNpm" => $row->khsMahasiswaNpm, "mahasiswaNamaLengkap" => $row->mahasiswaNamaLengkap, "matkulTawarId" => $mkTawarId, "nilai" => $nilai->gradeId, "matkulNama" => $mk->matkulNama, "formNilai" => $formNilai, "tahunAjar" => $mk->setMatkulTawarTahunAjaranId
                    ]);
                }
            }
        }

        echo json_encode($result);
    }

    public function add()
    {
        $tahunAjaran = $this->request->getVar('tahunAjaran');
        $matkulId = $this->request->getVar('matkulId');
        $data = $this->request->getVar('npm');
        $npm = array_keys($data);
        $nilai = array_values($data);
        $id = [];
        $khsLama = [];
        $nilaiUbah = [];
        $nilaiSave = [];
        $sks = getMatkul($matkulId)[0];

        for ($i = 0; $i < count($npm); $i++) {
            $khs = getKhsMahasiswa([$npm[$i], $tahunAjaran])[0];
            $getNilai = getNilaiProdiDetailByNpm([(string)$npm[$i], (int)$nilai[$i]])[0];
            array_push($id, ["id" => $khs->khsId, "npm" => $khs->khsMahasiswaNpm]);
            array_push($khsLama, ["npm" => $khs->khsMahasiswaNpm, "nilai" => $khs->khsNilaiMatkul]);
            array_push(
                $nilaiUbah,
                ["npm" => $khs->khsMahasiswaNpm, "nilai" => json_encode([
                    "matkulId" => (int)$matkulId,
                    "gradeId" => (int)$nilai[$i],
                    "status" => 1,
                    "nilai" => (float)$getNilai->gradeProdiNilaiBobot,
                    "totalNilai" => (float)$getNilai->gradeProdiNilaiBobot * (int)$sks->setMatkulKurikulumSks,
                ])]
            );
        }

        foreach ($id as $row) {
            $npmMhs = $row['npm'];
            foreach ($nilaiUbah as $mkNew) {
                if ($npmMhs == $mkNew['npm']) {
                    array_push($nilaiSave, ["npm" => $npmMhs, "nilai" => json_decode($mkNew['nilai'], true)]);
                }
            }
            foreach ($khsLama as $khsL) {
                foreach (json_decode($khsL['nilai'])->data as $mkOld) {
                    if ($npmMhs == $khsL['npm']) {
                        $data = [
                            "gradeId" => (int)$mkOld->gradeId,
                            "matkulId" => (int)$mkOld->matkulId,
                            "status" => $mkOld->status,
                            "nilai" => $mkOld->nilai,
                            "totalNilai" => $mkOld->totalNilai,
                        ];
                        array_push($nilaiSave, ["npm" => $npmMhs, "nilai" => $data]);
                    }
                }
            }
        }

        foreach ($id as $row) {
            $save = [];
            for ($i = 0; $i < count($nilaiSave); $i++) {
                $npmMhs = $row['npm'];
                if ($nilaiSave[$i]['npm'] == $npmMhs) {
                    array_push($save, $nilaiSave[$i]['nilai']);
                }
                $nilaiSaveDb[$row['id']] = $save;
            }
        }

        $dataEksekusi = [];
        foreach ($id as $row) {
            array_push(
                $dataEksekusi,
                [
                    "id" => $row['id'],
                    "data" => json_encode(["data" => unique_key($nilaiSaveDb[$row['id']], 'matkulId')])
                ]
            );
        }

        //eksekusi update
        $jumlahError = 0;
        foreach ($dataEksekusi as $update) {
            if (!$this->khsKelasModel->update($update['id'], ['khsNilaiMatkul' => $update['data']])) {
                $jumlahError++;
            };
        }
        $url = $this->request->getServer('HTTP_REFERER');
        session()->setFlashdata('error', $jumlahError);
        return redirect()->to($url);
    }
}
