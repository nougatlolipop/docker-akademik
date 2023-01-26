<?php

/* 
This is Controller KrsMahasiswa
 */

namespace Modules\KrsMahasiswa\Controllers;

use App\Controllers\BaseController;
use Modules\KrsMahasiswa\Models\KrsMahasiswaModel;
use Modules\KhsMahasiswa\Models\KhsMahasiswaModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\Tagihan\Models\TagihanModel;
use Modules\WaktuKuliah\Models\WaktuKuliahModel;
use Modules\Mahasiswa\Models\MahasiswaModel;
use Modules\SetMatkulDitawarkan\Models\SetMatkulDitawarkanModel;

class KrsMahasiswa extends BaseController
{
    protected $krsMahasiswaModel;
    protected $fakultasModel;
    protected $prodiModel;
    protected $programKuliahModel;
    protected $tahunAjaranModel;
    protected $waktuKuliahModel;
    protected $validation;
    protected $khsMahasiswaModel;
    protected $sksDefault;
    protected $sksAllowed;
    protected $sksAllow;
    protected $tagihanModel;
    protected $mahasiswaModel;
    protected $setMatkulDitawarkanModel;

    public function __construct()
    {
        $this->krsMahasiswaModel = new KrsMahasiswaModel();
        $this->khsMahasiswaModel = new KhsMahasiswaModel();
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
        $this->tahunAjaranModel = new TahunAjaranModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->waktuKuliahModel = new WaktuKuliahModel();
        $this->tagihanModel = new TagihanModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->setMatkulDitawarkanModel = new SetMatkulDitawarkanModel();
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

        $currentPage = $this->request->getVar('page_krs') ? $this->request->getVar('page_krs') : 1;
        $krs = $this->krsMahasiswaModel->getKrs($sourceData, $fakultas);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "KRS",
            'breadcrumb' => ['Akademik', 'KRS'],
            'numberPage' => $this->numberPage,
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdiForKrs()->findAll(),
            'prodiBiro' => $userDetail,
            'tahunAjaran' => $this->tahunAjaranModel->getTahunAjaran()->findAll(),
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'waktuKuliah' => $this->waktuKuliahModel->getWaktuKuliah()->findAll(),
            'validation' => \Config\Services::validation(),
            'filter' => $filter,
            'krs' => $krs->paginate($this->numberPage, 'krs'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->krsMahasiswaModel->pager,
        ];
        return view('Modules\KrsMahasiswa\Views\krsMahasiswa', $data);
    }

    public function getKrs()
    {
        $npm = $this->request->getVar('npm');
        $sourceData['npm'] = $npm;
        $sourceData['tahun_ajar'] = getTahunAjaranAktif($npm, 'krs')[0]->setJadwalAkademikTahunAjaranId;
        $krs = $this->krsMahasiswaModel->getKrs($sourceData)->findAll();

        if (count($krs) > 0) {
            $result = $krs[0]->krsMatkulTawarkan;
        } else {
            $result = '[]';
        }
        $matkul = [];
        foreach (json_decode($result)->data as $row) {
            $mk = getMatkul($row->matkulId)[0];
            array_push($matkul, ['matkulId' => $row->matkulId, 'kode' => $mk->matkulKode, 'nama' => $mk->matkulNama, 'sks' => $mk->setMatkulKurikulumSks]);
        }

        echo json_encode($matkul);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $mk = [];
        $khs = [];
        $jumlahSks = 0;
        $sisaKuota = 0;
        $msgError = [];
        $thAjar = getTahunAjaranAktif($this->request->getVar('npmKrs'), 'krs')[0]->setJadwalAkademikTahunAjaranId;
        foreach ($this->request->getVar('matkul') as $matkul) {
            //cek apakah matkul sudah penuh kelasnya
            $getMk = getMatkul($matkul)[0];
            $sisaKuota = $getMk->setMatkulTawarKuotaKelas - $getMk->setMatkulTawarKelasTerpakai;
            if ($sisaKuota > 0) {
                array_push($mk, ['matkulId' => $matkul]);
                array_push($khs, ['matkulId' => $matkul, 'nilai' => 0, 'totalNilai' => 0, 'gradeId' => 28, 'status' => 0]);
            } else {
                array_push($msgError, 'Quota matakuliah <strong>' . $getMk->matkulNama . '</strong> di kelas anda penuh');
            }
        }

        if (count($msgError) > 0) {
            session()->setFlashdata('mktersedia', $msgError);
        }

        $dataCari = array(
            'krsMahasiswaNpm' => $this->request->getVar('npmKrs'),
            'krsTahunAjaranId' => $thAjar,
        );

        $dataCariKhs = array(
            'khsMahasiswaNpm' => $this->request->getVar('npmKrs'),
            'khsTahunAjaranId' => $thAjar,
        );

        //jumlah sks yang baru diambil
        foreach ($mk as $matkul) {
            $jumlahSks = $jumlahSks + getMatkul($matkul)[0]->setMatkulKurikulumSks;
        }

        //get ipk
        $data = [];

        $khsNilai = getSksAllowed(['akd_khs.khsMahasiswaNpm' => $this->request->getVar('npmKrs')]);

        if (count($khsNilai) == 0) {
            $this->sksAllow = 24;
        } else {
            // dd($khsNilai);
            foreach ($khsNilai as $knilai) {
                foreach (json_decode($knilai->khsNilaiMatkul)->data as $nilai) {
                    array_push($data, $nilai);
                }
                $this->sksAllowed = $knilai->sksAllowJson;
                $this->sksDefault = $knilai->sksDefault;
            }
            $n = 0;
            $s = 0;
            // dd($data);
            foreach ($data as $res) {
                $n = $n + $res->totalNilai;
                if ($res->totalNilai == 0 && $res->nilai == 0) {
                    $s = $s + 0;
                } else {
                    $s = $s + ($res->totalNilai / $res->nilai);
                }
            };
            if ($s == 0 && $n == 0) {
                $ipk = 0;
            } else {
                $ipk = round($n / $s, 2);
            }

            //get sks allowed
            $this->sksAllow = $this->sksDefault;
            // dd(json_decode($this->sksAllowed)->data[0]->detail);
            foreach (json_decode($this->sksAllowed)->data[0]->detail as $sa) {
                if ($ipk >= $sa->minIpk && $ipk <= $sa->maxIpk) {
                    $this->sksAllow = $sa->allow;
                }
            }
        }
        // dd(((int)$this->sksAllow >= $jumlahSks));
        // cek jumlah sks diambil dan sks yang diperbolehkan
        if ((int)$this->sksAllow > $jumlahSks) {
            $krsExists = $this->krsMahasiswaModel->cekKrsExist($dataCari)->findAll();
            $khsExists = $this->khsMahasiswaModel->cariKhs($dataCariKhs)->findAll();

            if (count($krsExists) > 0) {
                $mk2 = [];
                $khs2 = [];
                $dataMk = json_decode($krsExists[0]->krsMatkulTawarkan)->data;
                $dataKhs = json_decode($khsExists[0]->khsNilaiMatkul)->data;

                foreach ($dataMk as $map) {
                    array_push($mk2, ['matkulId' => $map->matkulId]);
                }

                foreach ($mk as $map) {
                    array_push($mk2, ['matkulId' => $map['matkulId']]);
                }

                ///initial edit khs
                foreach ($dataKhs as $map) {
                    array_push($khs2, ['matkulId' => $map->matkulId, 'nilai' => $map->nilai, 'totalNilai' => $map->totalNilai, 'gradeId' => 28, 'status' => 0]);
                }

                foreach ($khs as $map) {
                    array_push($khs2, ['matkulId' => $map['matkulId'], 'nilai' => $map['nilai'], 'totalNilai' => $map['totalNilai'], 'gradeId' => $map['gradeId'], 'status' => $map['status']]);
                }

                $khsfix = unique_key($khs2, 'matkulId');
                $mkFix = unique_key($mk2, 'matkulId');
                // dd(json_encode(["data" => $mkFix]), json_encode(["data" => $khsfix]));
                if ($this->krsMahasiswaModel->update($krsExists[0]->krsId, ['krsMatkulTawarkan' => json_encode(["data" => $mkFix]), 'krsModifiedBy' => user()->email]) && $this->khsMahasiswaModel->update($khsExists[0]->khsId, ['khsNilaiMatkul' => json_encode(["data" => $khsfix]), 'khsModifiedBy' => user()->email])) {
                    session()->setFlashdata('success', 'Data KRS Mendapat Perubahan!');
                    return redirect()->to($url);
                }
            } else {
                if (count($mk) > 0) {
                    $dataInsert = array(
                        'krsMahasiswaNpm' => $this->request->getVar('npmKrs'),
                        'krsTahunAjaranId' => $thAjar,
                        'krsMatkulTawarkan' => json_encode(["data" => $mk]),
                        'krsCreatedBy' => user()->email,
                    );
                    $dataInsertKhs = array(
                        'khsMahasiswaNpm' => $this->request->getVar('npmKrs'),
                        'khsTahunAjaranId' => $thAjar,
                        'khsNilaiMatkul' => json_encode(["data" => $khs]),
                        'khsCreatedBy' => 'Sistem',
                    );
                    // dd($dataInsert);
                    if ($this->krsMahasiswaModel->insert($dataInsert) && $this->khsMahasiswaModel->insert($dataInsertKhs)) {
                        session()->setFlashdata('success', 'Data KRS Berhasil Ditambahkan!');
                        return redirect()->to($url);
                    }
                } else {
                    return redirect()->to($url);
                }
            }
        } else {
            session()->setFlashdata('danger', 'Jumlah krs yang dizinkan hanya ' . $this->sksAllow . ' SKS, sedangkan inputan ' . $jumlahSks . ' SKS');
            return redirect()->to($url);
        }
    }

    public function hapusKrs()
    {
        $mk2 = [];
        $khs = [];
        $khs2 = [];
        $npm = $this->request->getVar('npm');
        $matkulId = $this->request->getVar('matkulId');


        $dataCari = array(
            'krsMahasiswaNpm' => $npm,
            'krsTahunAjaranId' => getTahunAjaranAktif($npm, 'krs')[0]->setJadwalAkademikTahunAjaranId,
        );

        $dataCariKhs = array(
            'khsMahasiswaNpm' => $npm,
            'khsTahunAjaranId' => getTahunAjaranAktif($npm, 'krs')[0]->setJadwalAkademikTahunAjaranId,
        );

        $krsId = $this->krsMahasiswaModel->cekKrsExist($dataCari)->findAll()[0]->krsId;
        $khsId = $this->khsMahasiswaModel->cariKhs($dataCariKhs)->findAll()[0]->khsId;

        $dataKhs = json_decode($this->khsMahasiswaModel->cariKhs($dataCariKhs)->findAll()[0]->khsNilaiMatkul)->data;
        foreach ($dataKhs as $map) {
            array_push($khs, ['nilai' => $map->nilai, 'matkulId' => $map->matkulId,  'totalNilai' => $map->totalNilai, 'gradeId' => $map->gradeId, 'status' => $map->status]);
        }

        foreach ($dataKhs as $map) {
            if ($map->matkulId != $matkulId && $map->nilai == 0 || $map->matkulId == $matkulId && $map->nilai != 0) {
                array_push($mk2, ['matkulId' => $map->matkulId]);
                array_push($khs2, ['nilai' => $map->nilai, 'matkulId' => $map->matkulId,  'totalNilai' => $map->totalNilai, 'gradeId' => $map->gradeId, 'status' => $map->status]);
            }
        }
        if ($khs === $khs2) {
            echo json_encode(['status' => false, 'message' => 'Periksa kembali data yang akan dihapus,Kemungkinan data yang akan dihapus sudah diberi nilai']);
        } else {
            if ($this->krsMahasiswaModel->update($krsId, ['krsMatkulTawarkan' => json_encode(["data" => $mk2])]) && $this->khsMahasiswaModel->update($khsId, ['khsNilaiMatkul' => json_encode(["data" => $khs2])])) {
                echo json_encode(['status' => true, 'message' => 'Data KRS Berhasil Dihapus']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Data KRS Gagal Dihapus']);
            }
        }
    }

    public function print()
    {
        $npm = $_GET['n'];
        $taId = $_GET['t'];
        $dtMhs = $this->mahasiswaModel->getDataMhs(['dt_mahasiswa."mahasiswaNpm"' => $npm])->findAll();
        $taNama = $this->tahunAjaranModel->getWhere(['tahunAjaranId' => $taId])->getResult()[0]->tahunAjaranNama;
        $krs = $this->krsMahasiswaModel->getWhere(['krsMahasiswaNpm' => $npm, 'krsTahunAjaranId' => $taId])->getResult()[0]->krsMatkulTawarkan;
        $sourceData[] = '';
        $matkul = [];
        foreach (json_decode($krs)->data as $key => $mk) {
            $sourceData['matkul_tawar_id'] = $mk->matkulId;
            $matkul[] = $this->setMatkulDitawarkanModel->getMatkultawar($sourceData, null)->get()->getResult()[0];
        }
        $dataCetak = ['tahunAjaran' => $taNama, 'mahasiswa' => $dtMhs, 'matkul' => $matkul];
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'orientation' => 'L']);
        $mpdf->WriteHTML(view('Modules\KrsMahasiswa\Views\cetakKrsMahasiswa', $dataCetak));
        return redirect()->to($mpdf->Output('KartuRencanaStudi_' . $npm . '_' . $taNama . 'pdf', 'I'));
    }

    // public function cekTunggakan()
    // {
    //     $thAjar = getTahunAjaranAktifByNoReg('1799001')[0];
    //     $dataCek = [
    //         'keu_tagihan."tagihNoDaftar"' => '1799001',
    //         'keu_tagihan."tagihTahunAjaran"' => $thAjar->setJadwalAkademikTahunAjaranId,
    //         'keu_tagihan."tagihIsPaid"' => '0'
    //     ];

    //     if ($thAjar->semesterKode == 'Ganjil') {
    //         $krsInit = 'krsGanjil'; //constant
    //     } else {
    //         $krsInit = 'krsGenap'; //constant
    //     }

    //     dd(count($this->tagihanModel->cekTunggakan($dataCek, $krsInit)->findAll()));
    // }
}
