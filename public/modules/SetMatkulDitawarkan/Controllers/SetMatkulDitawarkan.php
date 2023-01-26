<?php

/* 
This is Controller SetMatkulDitawarkan
 */

namespace Modules\SetMatkulDitawarkan\Controllers;

use App\Controllers\BaseController;
use Modules\SetMatkulDitawarkan\Models\SetMatkulDitawarkanModel;
use Modules\SetMatkulKurikulum\Models\SetMatkulKurikulumModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\WaktuKuliah\Models\WaktuKuliahModel;
use Modules\SetProdiProgKuliah\Models\SetProdiProgKuliahModel;
use Modules\Tagihan\Models\TagihanModel;
use Modules\Kelas\Models\KelasModel;
use Modules\Fakultas\Models\FakultasModel;


class SetMatkulDitawarkan extends BaseController
{

    protected $setMatkulDitawarkanModel;
    protected $setMatkulKurikulumModel;
    protected $prodiModel;
    protected $programKuliahModel;
    protected $waktuKuliahModel;
    protected $setProdiProgKuliahModel;
    protected $kelasModel;
    protected $fakultasModel;
    protected $tahunAjaranModel;
    protected $validation;
    protected $tagihanModel;
    public function __construct()
    {
        $this->setMatkulDitawarkanModel = new SetMatkulDitawarkanModel();
        $this->setMatkulKurikulumModel = new SetMatkulKurikulumModel();
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->waktuKuliahModel = new WaktuKuliahModel();
        $this->setProdiProgKuliahModel = new SetProdiProgKuliahModel();
        $this->kelasModel = new KelasModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
        $this->tagihanModel = new TagihanModel();
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
        if ($this->request->getVar('wktKuliah')) {
            $waktu = explode(',', $this->request->getVar('wktKuliah'));
            $sourceData['waktuKuliah'] = $waktu;
            foreach ($waktu as $wkt) {
                array_push($filter, ['type' => 'wktKuliah', 'value' => getWaktuKuliahDetail($wkt)[0]->waktuNama, 'id' => $wkt]);
            }
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

        $currentPage = $this->request->getVar('page_setMatkulDitawarkan') ? $this->request->getVar('page_setMatkulDitawarkan') : 1;
        $setMatkulDitawarkan = $this->setMatkulDitawarkanModel->getMatkultawar($sourceData, $fakultas);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Mata Kuliah Ditawarkan",
            'breadcrumb' => ['Setting', 'Penawaran Akademik', 'Mata Kuliah Ditawarkan'],
            'setMatkulDitawarkan' => $setMatkulDitawarkan->paginate($this->numberPage, 'setMatkulDitawarkan'),
            'setMatkulKurikulum' => $this->setMatkulKurikulumModel->getSetMatkulKurikulum()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'prodiBiro' => $userDetail,
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'waktuKuliah' => $this->waktuKuliahModel->getWaktuKuliah()->findAll(),
            'prodiProgramKuliah' => $this->setProdiProgKuliahModel->getSetProdiProgKuliah()->findAll(),
            'kelas' => $this->kelasModel->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'filter' => $filter,
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->setMatkulDitawarkanModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\SetMatkulDitawarkan\Views\setMatkulDitawarkan', $data);
    }

    public function matkulKurikulum()
    {
        $whereIn = explode(',', $this->request->getVar('prodiAkademik'));
        $programKuliah = $this->request->getVar('programKuliahAkademik');
        $where = ['setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"' => $programKuliah];
        $matkulKurikulumAkademik = $this->setMatkulKurikulumModel->matkulKurikulumAkademik($where, $whereIn)->get()->getResult();
        $lists = "";
        foreach ($matkulKurikulumAkademik  as $data) {
            $lists .= "<option value='" . $data->setMatkulKurikulumId . "'>" . $data->matkulKode . " - " . $data->matkulNama . " (" . $data->matkulGroupKode . ") " . " / " . $data->kurikulumNama . " - " . $data->studiLevelNama . "</option>";
        }
        $callback = array('list_matkul_kurikulum' => $lists);
        echo json_encode($callback);
    }

    public function pratikum()
    {
        $whereIn = explode(',', $this->request->getVar('prodiAkademik'));
        $programKuliah = $this->request->getVar('programKuliahAkademik');
        $where = ['setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"' => $programKuliah, 'dt_matkul_type."matkulTypeKode"' => 2];
        $matkulKurikulumPratikum = $this->setMatkulKurikulumModel->matkulKurikulumPratikum($where, $whereIn)->get()->getResult();
        $lists = "";
        foreach ($matkulKurikulumPratikum  as $data) {
            $lists .= "<option value='" . $data->setMatkulKurikulumId . "'>" . $data->matkulKode . " - " . $data->matkulNama . " (" . $data->matkulGroupKode . ") " . " / " . $data->kurikulumNama . " - " . $data->studiLevelNama . "</option>";
        }
        $callback = array('list_matkul_kurikulum' => $lists);
        echo json_encode($callback);
    }

    public function prodiProgramKuliah()
    {
        $whereIn = explode(',', $this->request->getVar('prodiAkademik'));
        $programKuliah = $this->request->getVar('programKuliahAkademik');
        $where = ['setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"' => $programKuliah];
        $prodiProgramKuliahAkademik = $this->setProdiProgKuliahModel->prodiProgramKuliahAkademik($where, $whereIn)->get()->getResult();
        $lists = "";
        foreach ($prodiProgramKuliahAkademik  as $data) {
            $lists .= "<option value='" . $data->setProdiProgramKuliahId . "'>" . $data->prodiNama . " / " . $data->programKuliahNama . " - " . $data->waktuNama . "</option>";
        }
        $callback = array('list_prodi_program_kuliah' => $lists);
        echo json_encode($callback);
    }

    public function prodiProgramKuliahEdit()
    {
        $prodi = $this->request->getVar('prodiAkademik');
        $programKuliah = $this->request->getVar('programKuliahAkademik');
        $where = ['setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"' => $prodi, 'setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"' => $programKuliah];
        $prodiProgramKuliahAkademik = $this->setProdiProgKuliahModel->prodiProgramKuliahAkademik($where)->get()->getResult();
        $lists = "";
        foreach ($prodiProgramKuliahAkademik  as $data) {
            $lists .= "<option value='" . $data->setProdiProgramKuliahId . "'>" . $data->prodiNama . " / " . $data->programKuliahNama . " - " . $data->waktuNama . "</option>";
        }
        $callback = array('list_prodi_program_kuliah' => $lists);
        echo json_encode($callback);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'setMatkulTawarMatkulKurikulumId' => rv('required', ['required' => 'Mata kuliah kurikulum harus dipilih!']),
            'setMatkulTawarProdiProgramKuliahId' => rv('required', ['required' => 'Prodi program kuliah harus dipilih!']),
            'setMatkulTawarKuotaKelas' => rv('required', ['required' => 'Kuota kelas harus diisi!']),
            'setMatkulTawarKelasId' => rv('required', ['required' => 'Kelas harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $tahunAjaran = getTahunAjaranBerjalan()[0]->tahunAjaranId;
        $user = user()->email;
        $kelas = $this->request->getVar('setMatkulTawarKelasId');

        foreach ($kelas as $kelasId) {
            $jumlah = $this->setMatkulDitawarkanModel->dataExist([
                'setMatkulTawarTahunAjaranId' => $tahunAjaran,
                'setMatkulTawarMatkulKurikulumId' => $this->request->getVar('setMatkulTawarMatkulKurikulumId'),
                'setMatkulTawarProdiProgramKuliahId' => $this->request->getVar('setMatkulTawarProdiProgramKuliahId'),
                'setMatkulTawarKelasId' =>  $kelasId,
            ]);
            if ($jumlah == 0) {
                $data = array(
                    'setMatkulTawarTahunAjaranId' => $tahunAjaran,
                    'setMatkulTawarMatkulKurikulumId' => $this->request->getVar('setMatkulTawarMatkulKurikulumId'),
                    'setMatkulTawarProdiProgramKuliahId' => $this->request->getVar('setMatkulTawarProdiProgramKuliahId'),
                    'setMatkulTawarKelasId' =>  $kelasId,
                    'setMatkulTawarSemuaKelas' => ($this->request->getVar('setMatkulTawarSemuaKelas') == 'on') ? "1" : "0",
                    'setMatkulTawarKuotaKelas' => $this->request->getVar('setMatkulTawarKuotaKelas'),
                    'setMatkulTawarCreatedBy' => $user,
                );
                if ($this->setMatkulDitawarkanModel->insert($data)) {
                    session()->setFlashdata('success', 'Data Mata Kuliah Ditawarkan Berhasil Ditambahkan!');
                }
            } else {
                session()->setFlashdata('failed', 'Data Mata Kuliah Ditawarkan Sudah Disetting!');
            }
        }
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'prodi' => rv('required', ['required' => 'Prodi harus dipilih!']),
            'programKuliah' => rv('required', ['required' => 'Program kuliah harus dipilih!']),
            'setMatkulTawarMatkulKurikulumId' => rv('required', ['required' => 'Mata kuliah kurikulum harus dipilih!']),
            'setMatkulTawarProdiProgramKuliahId' => rv('required', ['required' => 'Prodi program kuliah harus dipilih!']),
            'setMatkulTawarKelasId' => rv('required', ['required' => 'Kelas harus dipilih!']),
            'setMatkulTawarKuotaKelas' => rv('required', ['required' => 'Kuota kelas harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $tahunAjaran = $this->request->getVar('setMatkulTawarTahunAjaranId');
        $setMatkulTawarMatkulKurikulumId = $this->request->getVar('setMatkulTawarMatkulKurikulumId');
        $oldSetMatkulTawarMatkulKurikulumId = $this->request->getVar('oldSetMatkulTawarMatkulKurikulumId');
        $setMatkulTawarKelasId = $this->request->getVar('setMatkulTawarKelasId');
        $oldSetMatkulTawarKelasId = $this->request->getVar('oldSetMatkulTawarKelasId');
        $setMatkulTawarProdiProgramKuliahId = $this->request->getVar('setMatkulTawarProdiProgramKuliahId');
        $oldSetMatkulTawarProdiProgramKuliahId = $this->request->getVar('oldSetMatkulTawarProdiProgramKuliahId');
        $user = user()->email;

        $cek = ($setMatkulTawarMatkulKurikulumId == $oldSetMatkulTawarMatkulKurikulumId && $setMatkulTawarProdiProgramKuliahId == $oldSetMatkulTawarProdiProgramKuliahId && $setMatkulTawarKelasId == $oldSetMatkulTawarKelasId) ? 0 : 1;

        if ($cek == 0) {
            $data = array(
                'setMatkulTawarTahunAjaranId' => $tahunAjaran,
                'setMatkulTawarMatkulKurikulumId' =>  $setMatkulTawarMatkulKurikulumId,
                'setMatkulTawarProdiProgramKuliahId' => $setMatkulTawarProdiProgramKuliahId,
                'setMatkulTawarKelasId' => $setMatkulTawarKelasId,
                'setMatkulTawarSemuaKelas' => ($this->request->getVar('setMatkulTawarSemuaKelas') == 'on') ? "1" : "0",
                'setMatkulTawarKuotaKelas' => $this->request->getVar('setMatkulTawarKuotaKelas'),
                'setMatkulTawarModifiedBy' =>  $user,
            );
            if ($this->setMatkulDitawarkanModel->update($id, $data)) {
                session()->setFlashdata('success', 'Data Mata Kuliah Ditawarkan Berhasil Diupdate!');
            }
        } else {
            $jumlah = $this->setMatkulDitawarkanModel->dataExist([
                'setMatkulTawarTahunAjaranId' => $tahunAjaran,
                'setMatkulTawarMatkulKurikulumId' =>  $setMatkulTawarMatkulKurikulumId,
                'setMatkulTawarProdiProgramKuliahId' => $setMatkulTawarProdiProgramKuliahId,
                'setMatkulTawarKelasId' => $setMatkulTawarKelasId,
            ]);
            if ($jumlah == 0) {
                $data = array(
                    'setMatkulTawarTahunAjaranId' => $tahunAjaran,
                    'setMatkulTawarMatkulKurikulumId' =>  $setMatkulTawarMatkulKurikulumId,
                    'setMatkulTawarProdiProgramKuliahId' => $setMatkulTawarProdiProgramKuliahId,
                    'setMatkulTawarKelasId' => $setMatkulTawarKelasId,
                    'setMatkulTawarSemuaKelas' => ($this->request->getVar('setMatkulTawarSemuaKelas') == 'on') ? "1" : "0",
                    'setMatkulTawarKuotaKelas' => $this->request->getVar('setMatkulTawarKuotaKelas'),
                    'setMatkulTawarModifiedBy' =>  $user,
                );
                if ($this->setMatkulDitawarkanModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Data Mata Kuliah Ditawarkan Berhasil Diupdate!');
                }
            } else {
                session()->setFlashdata('failed', 'Gagal Mengubah Data Mata Kuliah Ditawarkan, Data Sudah Disetting!');
            }
        }
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->setMatkulDitawarkanModel->delete($id)) {
            session()->setFlashdata('success', 'Data Mata Kuliah Ditawarkan Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }

    public function cari()
    {
        $npm = $this->request->getVar('npm');
        $kelas = $this->request->getVar('kelas');
        $ta = getTahunAjaranAktif($npm, 'krs');
        if ($ta == null) {
            $response = ['status' => null, 'message' => 'Jadwal Akademik belum disetting oleh Admin'];
        } else {
            $tahunAjar = $ta[0]->setJadwalAkademikTahunAjaranId;
            $tahun = $ta[0]->tahunAjaranKode;
            $semester = $ta[0]->semesterKode;

            $initInfo = [$npm, $kelas, $tahunAjar];
            $allowAkselarasi = $this->setMatkulDitawarkanModel->getAllowAkselarasi($npm)->getResult()[0];
            if ($allowAkselarasi->studyLevel > 2 && $allowAkselarasi->status == "1") {
                $allow = true;
            } else {
                $allow = false;
            }
            $mkDitawarkan = $this->setMatkulDitawarkanModel->cariMatkulDitawarkan($initInfo, $allow)->findAll();

            $dataCek = [
                $npm,
                $ta[0]->setJadwalAkademikTahunAjaranId
            ];

            if ($ta[0]->semesterKode == 'Ganjil') {
                $krsInit = 'krsGanjil'; //constant
            } else {
                $krsInit = 'krsGenap'; //constant
            }

            $tunggakan = $this->tagihanModel->cekTunggakan($dataCek)->getResult();

            if (count($tunggakan) > 0) {
                $response = ['status' => false, 'message' => 'Mahasiswa Masih Memiliki Tunggakan pra-syarat', 'data' => $tunggakan, 'tahunAjaran' => $tahun, 'semester' => $semester, 'noReg' => $npm];
            } else {
                if (count($mkDitawarkan) > 0) {
                    $response = ['status' => true, 'message' => 'Data ditemukan', 'data' => $mkDitawarkan, 'tahunAjaran' => $tahun, 'semester' => $semester, 'noReg' => $npm];
                } else {
                    $response = ['status' => false, 'message' => 'Tidak ada data', 'data' => [], 'tahunAjaran' => $tahun, 'semester' => $semester, 'noReg' => $npm];
                }
            }
        }
        echo json_encode($response);
    }

    public function cariMahasiswaDitawarkan()
    {
        $matkulTawarId = $this->request->getVar('matkulTawarId');
        $where = array('setting_matkul_tawarkan."setMatkulTawarId"' => $matkulTawarId,);
        $response = $this->setMatkulDitawarkanModel->cariMahasiswaDitawarkan($where)->findAll();
        echo json_encode($response);
    }

    public function addDosen($id)
    {
        $dosenOld = ($this->request->getVar('dosenOld') == null) ? [] : json_decode($this->request->getVar('dosenOld'))->data;
        $dosenNew = array_map('intval', $this->request->getVar('dosenNew'));
        $email = $this->request->getVar('email');
        $dtOld = [];
        $dtNew = [];
        if ($this->request->getVar('dosenOld') != null) {
            foreach ($dosenOld as $key => $dsn) {
                $dtOld[] = ["id" => $dsn->id];
            }
        }
        foreach ($dosenNew as $key => $dsn) {
            $dtNew[] = ["id" => $dsn];
        }
        $dtInsert = json_encode(["data" => array_merge($dtOld, $dtNew)]);

        $data = [
            'setMatkulTawarDosen' => $dtInsert,
            'setMatkulTawarModifiedBy' => $email
        ];
        if ($this->setMatkulDitawarkanModel->update($id, $data)) {
            $response = 1;
        } else {
            $response = 0;
        }
        echo json_encode($response);
    }

    public function deleteDosen($id)
    {
        $dosenOld = json_decode($this->request->getVar('dosenOld'))->data;
        $dosenNew = array_map('intval', $this->request->getVar('dosenNew'));
        $email = $this->request->getVar('email');
        $dtOld = [];
        $dtNew = [];
        $dtInsert = [];
        foreach ($dosenOld as $key => $dsn) {
            $dtOld[] = $dsn->id;
        }
        foreach ($dosenNew as $key => $dsn) {
            $dtNew[] = $dsn;
        }
        $dtSave =  array_diff($dtOld, $dtNew);
        foreach ($dtSave as $key => $dsn) {
            $dtInsert[] = ["id" => $dsn];
        }
        $data = [
            'setMatkulTawarDosen' => json_encode(["data" => $dtInsert]),
            'setMatkulTawarModifiedBy' => $email
        ];
        if ($this->setMatkulDitawarkanModel->update($id, $data)) {
            $response = 1;
        } else {
            $response = 0;
        }
        echo json_encode($response);
    }
}
