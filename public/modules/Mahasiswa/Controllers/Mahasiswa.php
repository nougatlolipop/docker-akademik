<?php

/* 
This is Controller Mahasiswa
 */

namespace Modules\Mahasiswa\Controllers;

use Xendit\Xendit;
use App\Controllers\BaseController;
use Modules\KeuTarifTambahan\Models\KeuTarifTambahanModel;
use Modules\Mahasiswa\Models\MahasiswaModel;
use Modules\SetKurikulumDitawarkan\Models\SetKurikulumDitawarkanModel;
use Modules\SetMatkulDitawarkan\Models\SetMatkulDitawarkanModel;
use Modules\KeuTeller\Models\KeuTellerModel;
use Modules\KrsMahasiswa\Models\KrsMahasiswaModel;
use Modules\MatkulGroup\Models\MatkulGroupModel;
use Modules\Konversi\Models\KonversiModel;
use Modules\KhsMahasiswa\Models\KhsMahasiswaModel;
use Modules\NilaiProdi\Models\NilaiProdiModel;
use Modules\Tagihan\Models\TagihanModel;

class Mahasiswa extends BaseController
{

    protected $mahasiswaModel;
    protected $setKurikulumDitawarkanModel;
    protected $setMatkulDitawarkanModel;
    protected $validation;
    protected $keuTellerModel;
    protected $krsMahasiswaModel;
    protected $khsMahasiswaModel;
    protected $konversiModel;
    protected $matkulGroupModel;
    protected $tagihanModel;
    protected $keuTeller;
    protected $keuTarifTambahanModel;
    protected $nilaiModel;
    protected $sksAllow;
    protected $sksDefault;
    protected $sksAllowed;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->setKurikulumDitawarkanModel = new SetKurikulumDitawarkanModel();
        $this->setMatkulDitawarkanModel = new SetMatkulDitawarkanModel();
        $this->keuTellerModel = new KeuTellerModel();
        $this->krsMahasiswaModel = new KrsMahasiswaModel();
        $this->khsMahasiswaModel = new KhsMahasiswaModel();
        $this->konversiModel = new KonversiModel();
        $this->matkulGroupModel = new MatkulGroupModel();
        $this->tagihanModel = new TagihanModel();
        $this->keuTarifTambahanModel = new KeuTarifTambahanModel();
        $this->nilaiModel = new NilaiProdiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $menuMhs = file_get_contents(ROOTPATH . $this->getFile($this->usr->name));
        $menuMhs = json_decode($menuMhs, false);
        $mhs = user()->username;
        // $tahunAjaran = getTahunAjaranAktif($mhs, 'krs');
        $tahunAjaran = getTahunAjaranBerjalan();
        $whereTagihan = [$mhs, $tahunAjaran[0]->tahunAjaranKode];
        $sourceData['npm'] = $mhs;
        $saldoDompet =  getSaldoDompet(['savingMahasiswaNpm' => $mhs])[0]->savingNominal;
        $saldoDompet = ($saldoDompet == null) ? 0 : $saldoDompet;
        $whereLunas = ['tagihMahasiswaNpm' => $mhs, 'tagihTahun' => $tahunAjaran[0]->tahunAjaranKode];
        $mahasiswa = $this->infoMhs($mhs);
        $sourceData['tambahan'] = [2];
        $sourceData['prodi'] = [$mahasiswa[0]->setProdiProgramKuliahProdiId];

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Portal Mahasiswa",
            'menuMhs' => $menuMhs,
            'tagihan' => $this->keuTellerModel->getTagihan($whereTagihan)->getResult(),
            'krs' => $this->krsMahasiswaModel->getKrs($sourceData)->findAll(),
            'khs' => $this->khsMahasiswaModel->getKhs($sourceData)->findAll(),
            'perkembangan' => $this->mahasiswaModel->getPerkembanganAkademik($mhs)->getResult(),
            'dosenPengampu' => $this->mahasiswaModel->getDosenPengampu($mhs)->getResult(),
            'transkrip' => ($mhs == null) ? [] : $this->transkrip($mhs),
            'group' => $this->matkulGroupModel->getMatkulGroupAll()->findAll(),
            'nilai' => ($mhs == null) ? [] : $this->collectNilai($mhs),
            'mahasiswa' => $mahasiswa,
            'jadwalKuliah' => $this->mahasiswaModel->getJadwalKuliah([$mhs, $tahunAjaran[0]->tahunAjaranId])->getResult(),
            'riwayatPembayaran' => $this->mahasiswaModel->getRiwayatPembayaran($mhs)->getResult(),
            'isLunas' => $this->tagihanModel->where($whereLunas)->findAll(),
            'saldoDompet' => $saldoDompet,
            'jadwalLunas' => $this->cekJadwalLunas(),
            'tagihanLain' => $this->keuTarifTambahanModel->getKeuTarifTambahan($sourceData)->findAll(),
            'dosenMk' => $this->mahasiswaModel->getDosenKuliah([$mhs, $tahunAjaran[0]->tahunAjaranId])->getResult(),
            'nilaiAll' => $this->nilaiModel->getNilaiProdiDetail([
                'dt_grade_prodi_nilai.gradeProdiNilaiProdiId' => $sourceData['prodi']
            ])->findAll()
        ];

        return view('Modules\Mahasiswa\Views\mahasiswa', $data);
    }

    public function transkrip($npm)
    {
        $where = [
            'dt_mahasiswa."mahasiswaNpm"' => $npm,
        ];
        return $this->setMatkulDitawarkanModel->maktulTranskrip($where)->findAll();
    }

    public function collectNilai($npm)
    {
        $mkNilai = [];
        $whereKonversi = [
            'akd_konversi_nilai."konversiNilaiMahasiswaNpm"' => $npm,
            'akd_konversi_nilai."konversiNilaiJenisKonversiId"' => 1,
        ];
        $konversi = $this->konversiModel->cariKonversi($whereKonversi)->findAll();
        foreach ($konversi as $nilai) {
            foreach (json_decode($nilai->konversiNilaiMatkulNew)->data as $row) {
                $mk = getMatkul($row->matkulId)[0];
                array_push($mkNilai, ['matkulId' => $mk->matkulId, 'gradeId' => $row->gradeId, 'nilai' => $row->nilai, 'total' => $row->totalNilai, 'status' => $row->status]);
            }
        }

        $where = [
            'akd_khs."khsMahasiswaNpm"' => $npm,
        ];
        $khs = $this->khsMahasiswaModel->cariKhs($where)->findAll();

        foreach ($khs as $nilai) {
            foreach (json_decode($nilai->khsNilaiMatkul)->data as $row) {
                $mk = getMatkul($row->matkulId)[0];
                array_push($mkNilai, ['matkulId' => $mk->matkulId, 'gradeId' => $row->gradeId, 'nilai' => $row->nilai, 'total' => $row->totalNilai, 'status' => $row->status]);
            }
        }

        return unique_key($mkNilai, 'matkulId');
    }

    // public function getTagihan($where)
    // {
    //     $builder = $this->db->table("function_tampil_tagihan('" . $where[0] . "','" . $where[1] . "')");
    //     $builder->orderBy('tahap', 'asc');
    //     return $builder->get();
    // }

    public function infoMhs($npmVar)
    {
        $npm = $npmVar;
        $where = ['dt_mahasiswa.mahasiswaNpm' => $npm];
        $mahasiswa = $this->mahasiswaModel->cariMahasiswa($where)->findAll();
        return $mahasiswa;
    }

    public function cari()
    {
        $npm =  $this->request->getVar('npm');
        $type =  $this->request->getVar('type');
        if ($type == "konversi") {
            $where = ['dt_mahasiswa.mahasiswaNpm' => $npm, 'dt_mahasiswa.mahasiswaIsKonversi' => '1'];
        } else {
            $where = ['dt_mahasiswa.mahasiswaNpm' => $npm];
        }

        $mahasiswa = $this->mahasiswaModel->cariMahasiswa($where)->findAll();
        echo json_encode($mahasiswa);
    }

    public function kurikulum()
    {
        $prodi = $this->request->getVar('prodi');
        $programKuliah = $this->request->getVar('programKuliah');
        $where = [
            'prodi' => $prodi,
            'program_kuliah' => $programKuliah
        ];
        $kurikulum = $this->setKurikulumDitawarkanModel->getSetKurikulumDitawarkan($where)->findAll();
        echo json_encode($kurikulum);
    }

    public function matkul()
    {
        $prodi = $this->request->getVar('prodi');
        $programKuliah = $this->request->getVar('programKuliah');
        $kurikulum = $this->request->getVar('kurikulum');
        $kelas = $this->request->getVar('kelas');
        $waktuKuliah = $this->request->getVar('waktuKuliah');

        $where = [
            'setting_kurikulum_tawarkan."setKurikulumTawarProdiId"' => $prodi,
            'setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"' => $programKuliah,
            'setting_kurikulum_tawarkan."setKurikulumTawarId"' => $kurikulum,
            'setting_matkul_tawarkan."setMatkulTawarKelasId"' => $kelas,
            'setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"' => $waktuKuliah,
        ];
        $matkul = $this->setMatkulDitawarkanModel->getSetMatkulDitawarkanKonversi($where)->findAll();
        echo json_encode($matkul);
    }

    public function add()
    {
        // dd($_POST);
        $npm = user()->username;
        $mk = [];
        $khs = [];
        $jumlahSks = 0;
        $sisaKuota = 0;
        $msgError = [];
        $thAjar = getTahunAjaranAktif($npm, 'krs')[0]->setJadwalAkademikTahunAjaranId;
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
            'krsMahasiswaNpm' => $npm,
            'krsTahunAjaranId' => $thAjar,
        );

        $dataCariKhs = array(
            'khsMahasiswaNpm' => $npm,
            'khsTahunAjaranId' => $thAjar,
        );

        //jumlah sks yang baru diambil
        foreach ($mk as $matkul) {
            $jumlahSks = $jumlahSks + getMatkul($matkul)[0]->setMatkulKurikulumSks;
        }

        //get ipk
        $data = [];
        $khsNilai = getSksAllowed(['akd_khs.khsMahasiswaNpm' => $npm]);

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
            foreach (json_decode($this->sksAllowed)->data[0]->detail as $sa) {
                if ($ipk >= $sa->minIpk && $ipk <= $sa->maxIpk) {
                    $this->sksAllow = $sa->allow;
                }
            }
        }

        // cek jumlah sks diambil dan sks yang diperbolehkan
        if ((int)$this->sksAllow >= $jumlahSks) {
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
                // dd(json_encode(unique_key($khs2, 'matkulId')));
                if ($this->krsMahasiswaModel->update($krsExists[0]->krsId, ['krsMatkulTawarkan' => json_encode(["data" => $mkFix])]) && $this->khsMahasiswaModel->update($khsExists[0]->khsId, ['khsNilaiMatkul' => json_encode(["data" => $khsfix])])) {
                    session()->setFlashdata('success', 'Data KRS Mendapat Perubahan!');
                    return redirect()->to('/mahasiswa');
                }
            } else {
                if (count($mk) > 0) {
                    $dataInsert = array(
                        'krsMahasiswaNpm' => $npm,
                        'krsTahunAjaranId' => $thAjar,
                        'krsMatkulTawarkan' => json_encode(["data" => $mk]),
                        'krsCreatedBy' => user()->email,
                    );
                    $dataInsertKhs = array(
                        'khsMahasiswaNpm' => $npm,
                        'khsTahunAjaranId' => $thAjar,
                        'khsNilaiMatkul' => json_encode(["data" => $khs]),
                        'khsCreatedBy' => 'Sistem',
                    );

                    if ($this->krsMahasiswaModel->insert($dataInsert) && $this->khsMahasiswaModel->insert($dataInsertKhs)) {
                        session()->setFlashdata('success', 'Data KRS Berhasil Ditambahkan!');
                        return redirect()->to('/mahasiswa');
                    }
                } else {
                    return redirect()->to('/mahasiswa');
                }
            }
        } else {
            session()->setFlashdata('danger', 'Jumlah krs yang dizinkan hanya ' . $this->sksAllow . ' SKS, sedangkan inputan ' . $jumlahSks . ' SKS');
            return redirect()->to('/mahasiswa');
        }
    }

    public function createInvoice()
    {
        Xendit::setApiKey($this->apiKey);

        $npm = $this->request->getVar('npm');
        $tahunAjaran = getTahunAjaranAktif($npm, 'krs');
        $whereTagihan = [$npm, $tahunAjaran[0]->tahunAjaranKode];
        $mahasiswa = $this->infoMhs($npm);
        $tagihan = $this->keuTellerModel->getTagihan($whereTagihan)->getResult();
        $totalTagihan = 0;

        $saldoDompet =  getSaldoDompet(['savingMahasiswaNpm' => $npm])[0]->savingNominal;
        $saldoDompet = ($saldoDompet == null) ? 0 : $saldoDompet;

        $dataTagihan = [];
        $jlhItem = 0;
        foreach ($tagihan as $tagih) {
            $jlhItem++;
            if ($tagih->forceToPay == 1) {
                $totalTagihan = $totalTagihan + $tagih->nominal;
                $ket = ($saldoDompet > 0 && $jlhItem == 1) ? '(-' . $saldoDompet . ')' : '';
                // array_push($dataTagihan, [
                //     'name' => $tagih->jenisBiayaKode . ' ' . $tagih->tahap . ' ' . $ket,
                //     'quantity' => 1,
                //     'price' => ($saldoDompet > 0 && $jlhItem == 1) ? $tagih->nominal - $saldoDompet : $tagih->nominal,
                //     'category' => $tagih->jenisBiayaNama,
                //     'url' => 'https=>//yourcompany.com/example_item'
                // ]);
                array_push($dataTagihan, [
                    'description' => $tagih->jenisBiayaKode . ' ' . $tagih->tahap . ' ' . $ket,
                    'unitPrice' => (int)$tagih->nominal,
                    'qty' => 1,
                    'amount' => ($saldoDompet > 0 && $jlhItem == 1) ? (int)($tagih->nominal - $saldoDompet) : (int)$tagih->nominal,
                ]);
            }
        }
        if ($saldoDompet > $totalTagihan) {
            dd('Saldo Dompet Lebih Besar dari Tagihan');
        } else {
            $totalTagihan = $totalTagihan - $saldoDompet;

            // $params = [
            //     'external_id' => 'umsu_1475801962607',
            //     'amount' =>  $totalTagihan,
            //     'description' => 'Invoice UMSU #123',
            //     'invoice_duration' => 86400,
            //     'customer' => [
            //         'given_names' => $mahasiswa[0]->mahasiswaNamaLengkap,
            //         'surname' => $mahasiswa[0]->mahasiswaNpm,
            //         'email' =>  $mahasiswa[0]->mahasiswaEmail,
            //         'mobile_number' => $mahasiswa[0]->mahasiswaNoHp,
            //         'address' => [
            //             [
            //                 'city' => 'Jakarta Selatan',
            //                 'country' => 'Indonesia',
            //                 'postal_code' => $mahasiswa[0]->mahasiswaKodePos,
            //                 'state' => 'Daerah Khusus Ibukota Jakarta',
            //                 'street_line1' => $mahasiswa[0]->mahasiswaAlamat,
            //                 'street_line2' => $mahasiswa[0]->mahasiswaAlamatOrtu
            //             ]
            //         ]
            //     ],
            //     'customer_notification_preference' => [
            //         'invoice_created' => [
            //             'whatsapp',
            //             'sms',
            //             'email'
            //         ],
            //         'invoice_reminder' => [
            //             'whatsapp',
            //             'sms',
            //             'email'
            //         ],
            //         'invoice_paid' => [
            //             'whatsapp',
            //             'sms',
            //             'email'
            //         ],
            //         'invoice_expired' => [
            //             'whatsapp',
            //             'sms',
            //             'email'
            //         ]
            //     ],
            //     'success_redirect_url' => 'localhost:8080/keuTeller',
            //     'failure_redirect_url' => 'https=>//www.google.com',
            //     'currency' => 'IDR',
            //     'items' => $dataTagihan,
            //     'fees' => [
            //         [
            //             'type' => 'ADMIN',
            //             'value' => 0
            //         ]
            //     ]
            // ];

            // $createInvoice = \Xendit\Invoice::create($params);
            // return redirect()->to($createInvoice['invoice_url']);

            $params = [
                'date' => date('Y-m-d'),
                'amount' => $totalTagihan,
                'name' => $mahasiswa[0]->mahasiswaNamaLengkap,
                'email' => $mahasiswa[0]->mahasiswaEmail,
                'address' => $mahasiswa[0]->mahasiswaAlamat,
                'va' => $mahasiswa[0]->mahasiswaNpm,
                'number' => 'umsu_' . $mahasiswa[0]->mahasiswaNpm,
                'attribute1' => $mahasiswa[0]->prodiNama,
                'attribute2' => 'Kelas ' . $mahasiswa[0]->kelasKode,
                'items' => $dataTagihan,
                'openPayment' => false,
                'attributes' => []
            ];

            $exe = akses_maja(getMajaInfo()[0]->billing_host . '/api/v2/register', json_encode($params));
            if (json_decode($exe, true)['success']) {
                session()->setFlashdata('success', json_decode($exe, true)['message']);
            } else {
                session()->setFlashdata('danger', json_decode($exe, true)['message']);
            }
            return redirect()->to('/mahasiswa');
        }
    }

    public function cekJadwalLunas()
    {
        $npm = user()->username;
        // $tahunAjaran = getTahunAjaranAktif($npm, 'krs');
        $tahunAjaran = getTahunAjaranBerjalan();
        $tahun =  $tahunAjaran[0]->tahunAjaranKode;
        $where = [
            'tahap' => 0,
            '"jadwalTagihanTahun"' => $tahun,
            'dt_mahasiswa."mahasiswaNpm"' => $npm
        ];
        $response = $this->keuTellerModel->getJadwalLunas($where)->getResult();
        return $response;
    }
}
