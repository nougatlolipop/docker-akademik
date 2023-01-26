<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuTarifPokok\Controllers;

use App\Controllers\BaseController;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\WaktuKuliah\Models\WaktuKuliahModel;
use Modules\KelompokKuliah\Models\KelompokKuliahModel;
use Modules\JenisBiaya\Models\JenisBiayaModel;
use Modules\SetKurikulumDitawarkan\Models\SetKurikulumDitawarkanModel;
use Modules\TagihanJadwal\Models\TagihanJadwalModel;
use Modules\KeuTarifPokok\Models\KeuTarifPokokModel;
use Modules\KeuTahap\Models\KeuTahapModel;

class KeuTarifPokok extends BaseController
{
    protected $setKurikulumDitawarkanModel;
    protected $prodiModel;
    protected $fakultasModel;
    protected $programKuliahModel;
    protected $waktuKuliahModel;
    protected $kelompokKuliahModel;
    protected $jenisBiayaModel;
    protected $validation;
    protected $keuTarifPokokModel;
    protected $tagihanJadwalModel;
    protected $keuTahapModel;
    public function __construct()
    {
        $this->setKurikulumDitawarkanModel = new SetKurikulumDitawarkanModel();
        $this->prodiModel = new ProdiModel();
        $this->fakultasModel = new FakultasModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->waktuKuliahModel = new WaktuKuliahModel();
        $this->kelompokKuliahModel = new KelompokKuliahModel();
        $this->jenisBiayaModel = new JenisBiayaModel();
        $this->keuTarifPokokModel = new KeuTarifPokokModel();
        $this->tagihanJadwalModel = new TagihanJadwalModel();
        $this->keuTahapModel = new KeuTahapModel();
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
        $currentPage = $this->request->getVar('page_keuTarifPokok') ? $this->request->getVar('page_keuTarifPokok') : 1;
        $setKurikulumDitawarkan = $this->setKurikulumDitawarkanModel->getKurikulumTawarTarif($sourceData, $fakultas);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Tarif Pokok",
            'breadcrumb' => ['Keuangan', 'Tarif ', 'Biaya Pokok'],
            'setKurikulumDitawarkan' => $setKurikulumDitawarkan->paginate($this->numberPage, 'keuTarifPokok'),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'prodiBiro' => $userDetail,
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'waktuKuliah' => $this->waktuKuliahModel->getWaktuKuliah()->findAll(),
            'kelompokKuliah' => $this->kelompokKuliahModel->getKelompokKuliah()->findAll(),
            'currentPage' => $currentPage,
            'tagihan' => $this->jenisBiayaModel->jenisTagihan('pokok')->findAll(),
            'filter' => $filter,
            'numberPage' => $this->numberPage,
            'pager' => $this->setKurikulumDitawarkanModel->pager,
            'validation' => \Config\Services::validation()
        ];

        return view('Modules\KeuTarifPokok\Views\keuTarifPokok', $data);
    }

    public function add()
    {
        // dd($_POST);
        $tahap = $this->request->getVar('tahap');
        $tahapher = $this->request->getVar('tahapher');
        $itemSave = $this->request->getVar('itemSave');
        $nominalTahapSave = $this->request->getVar('nominalTahapSave');
        $prodiId = $this->request->getVar('prodiId');
        $programKuliahId = $this->request->getVar('programKuliahId');
        $angkatan = $this->request->getVar('angkatan');
        $smtr = $this->request->getVar('smtr');
        $dataDetailSave = [];
        foreach (array_unique($smtr) as $key => $value) {
            $itemId = explode(",", $itemSave[0]);
            $nom = explode(",", $nominalTahapSave[0]);

            $detail = [];
            for ($j = 0; $j < count($itemId); $j++) {
                array_push($detail, [
                    'item' => (int)$itemId[$j],
                    'nominal' => (int)$nom[$j]
                ]);
            }

            $data = [
                'tahap' => (int)$tahap[0],
                'semester' => (int)$smtr[$key],
                'detail' => $detail
            ];
            array_push($dataDetailSave, $data);
        }

        for ($i = 1; $i < count($itemSave); $i++) {
            $itemId = explode(",", $itemSave[$i]);
            $nom = explode(",", $nominalTahapSave[$i]);

            $detail = [];
            for ($j = 0; $j < count($itemId); $j++) {
                array_push($detail, [
                    'item' => (int)$itemId[$j],
                    'nominal' => (int)$nom[$j]
                ]);
            }

            $data = [
                'tahap' => (int)$tahap[$i],
                'semester' => (int)$smtr[$i - 1],
                'detail' => $detail
            ];
            array_push($dataDetailSave, $data);
        }

        $jumlah = $this->keuTarifPokokModel->dataExist(['tarifProdiId' => $prodiId, 'tarifProgramKuliahId' => $programKuliahId, 'tarifAngkatan' => $angkatan]);

        if ($jumlah == 0) {
            $data = [
                "tarifProdiId" => $prodiId,
                "tarifProgramKuliahId" => $programKuliahId,
                "tarifAngkatan" => $angkatan,
                "tarifKodeBayar" => 4,
                "tarifDetail" => json_encode(array('data' => $dataDetailSave)),
                "tarifCreatedBy" => user()->email
            ];
            $gagalSave = [];
            if (!$this->keuTarifPokokModel->insert($data)) {
                array_push($gagalSave, "Gagal Simpan");
            }
            session()->setFlashdata('gagalSave', $gagalSave);
        } else {
            $denyInsert = [];
            array_push($denyInsert, "Tarif Pokok Sudah Disetting!");
            session()->setFlashdata('denyInsert', $denyInsert);
        }

        $url = $this->request->getVar('url');
        return redirect()->to($url);
    }

    public function hitung()
    {
        $tahun = $this->request->getVar('tahun');
        $her = ($this->request->getVar('her') == null) ? null : $this->request->getVar('her');
        $tglmulaiHer = ($this->request->getVar('tglmulaiHer') == null) ? null : $this->request->getVar('tglmulaiHer');
        $tglselesaiHer = ($this->request->getVar('tglselesaiHer') == null) ? null : $this->request->getVar('tglselesaiHer');
        $tahap = $this->request->getVar('tahap');
        $tglmulai = $this->request->getVar('tglmulai');
        $tglselesai = $this->request->getVar('tglselesai');
        $datappk = $this->request->getVar('datappk');

        $tanggalHer = [];
        if ($her != null) {
            for ($i = 0; $i < count($her); $i++) {
                $data = [
                    "tahap" => (int)$her[$i],
                    "mulai" => $tglmulaiHer[$i] . " 00:00:00",
                    "selesai" => $tglselesaiHer[$i] . " 23:59:00",
                ];
                array_push($tanggalHer, $data);
            }
        }

        $tanggalTahap = [];
        for ($i = 0; $i < count($tahap); $i++) {
            $data = [
                "tahap" => (int)$tahap[$i],
                "mulai" => $tglmulai[$i] . " 00:00:00",
                "selesai" => $tglselesai[$i] . " 23:59:00",
            ];
            array_push($tanggalTahap, $data);
        }

        $datappk = json_decode($datappk);
        $errorJadwal = 0;
        $errorFunction = 0;
        foreach ($datappk as $key) {
            $prodi = $key[0];
            $programKuliah = $key[1];
            $angkatan = $key[2];
            $jadwalTagihanCek = [
                "jadwalTagihanProdiId" =>  (int)$prodi,
                "jadwalTagihanProgramKuliahId" => (int)$programKuliah,
                "jadwalTagihanAngkatan" => (string)$angkatan,
                "jadwalTagihanTahun" => (string)$tahun,
            ];

            $jadwalTagihan = [
                "jadwalTagihanProdiId" => (int)$prodi,
                "jadwalTagihanProgramKuliahId" => (int)$programKuliah,
                "jadwalTagihanAngkatan" => (string)$angkatan,
                "jadwalTagihanTahun" => (string)$tahun,
                "jadwalTagihanDeskripsi" => json_encode(array('data' => $tanggalTahap)),
                "jadwalTagihanDeskripsiHer" => (count($tanggalHer) > 0) ? json_encode(array('data' => $tanggalHer)) : null,
            ];

            if (count($this->tagihanJadwalModel->where($jadwalTagihanCek)->findAll()) == 0) {
                if (!$this->tagihanJadwalModel->insert($jadwalTagihan)) {
                    $errorJadwal++;
                }
            } else {
                if (!$this->tagihanJadwalModel->set($jadwalTagihan)->where($jadwalTagihanCek)->update()) {
                    $errorJadwal++;
                }
            }

            $dataExecute = [$prodi, $programKuliah, $angkatan, $tahun];
            if (!$this->keuTarifPokokModel->callHitungTagihan($dataExecute)) {
                $errorFunction++;
            }
        }

        $url = $this->request->getVar('url');
        session()->setFlashdata('errorSave', [$errorJadwal, $errorFunction]);
        return redirect()->to($url);
    }

    public function edit()
    {
        $prodi = $this->request->getVar('prodi');
        $programKuliah = $this->request->getVar('programKuliah');
        $angkatan = $this->request->getVar('angkatan');
        $tahap = $this->request->getVar('tahap');
        $semester = $this->request->getVar('semester');
        $item = $this->request->getVar('item');
        $nominal = $this->request->getVar('nominal');
        $thpSem = [];
        foreach ($tahap as $thkey => $dtTahap) {
            $thpSem[] = $dtTahap . $semester[$thkey];
        }

        $jmlThp = array_values(array_unique($thpSem));

        $dataSave = [];
        foreach ($tahap as $key => $value) {
            array_push($dataSave, [
                'tahap' => $tahap[$key],
                'semester' => $semester[$key],
                'item' => $item[$key],
                'nominal' => $nominal[$key]
            ]);
        };

        $dataInsert = [];
        for ($i = 0; $i < count($jmlThp); $i++) {
            $filterBy = $jmlThp[$i];
            $hasil = array_values(array_filter($dataSave, function ($var) use ($filterBy) {
                return ($var['tahap'] . $var['semester'] == $filterBy);
            }));

            $detail = [];
            for ($d = 0; $d < count($hasil); $d++) {
                array_push($detail, [
                    'item' => (int)$hasil[$d]['item'],
                    'nominal' => (int)$hasil[$d]['nominal']
                ]);
            }

            $dataDetail = [
                'tahap' => (int)substr($jmlThp[$i], 0, 1),
                'semester' => (int)substr($jmlThp[$i], 1),
                'detail' => $detail,
            ];
            array_push($dataInsert, $dataDetail);
        }
        $id = $this->keuTarifPokokModel->getWhere(['tarifProdiId' => $prodi, 'tarifProgramKuliahId' => $programKuliah, 'tarifAngkatan' => $angkatan])->getResult()[0]->tarifId;
        $data = [
            "tarifDetail" => json_encode(array('data' => $dataInsert)),
            "tarifModifiedBy" => user()->email
        ];

        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->keuTarifPokokModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Nominal Tarif Biaya Pokok Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $prodi = $this->request->getVar('prodi');
        $programKuliah = $this->request->getVar('programKuliah');
        $angkatan = $this->request->getVar('angkatan');
        $id = $this->keuTarifPokokModel->getWhere(['tarifProdiId' => $prodi, 'tarifProgramKuliahId' => $programKuliah, 'tarifAngkatan' => $angkatan])->getResult()[0]->tarifId;
        // dd([$prodi, $programKuliah, $angkatan, $id]);
        if ($this->keuTarifPokokModel->delete($id)) {
            session()->setFlashdata('success', 'Data Tarif Biaya Pokok Berhasil Dihapus!');
            return redirect()->to($url);
        }
    }
}
