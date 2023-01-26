<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuTeller\Controllers;

use Xendit\Xendit;
use App\Controllers\BaseController;
use Modules\KeuTeller\Models\KeuTellerModel;
use Modules\Tagihan\Models\TagihanModel;
use Modules\KeuPayment\Models\KeuPaymentModel;

// require 'vendor/autoload.php';


class KeuTeller extends BaseController
{

    protected $validation;
    protected $keuTeller;
    protected $tagihanModel;
    protected $payment;

    public function __construct()
    {
        $this->keuTeller = new KeuTellerModel();
        $this->tagihanModel = new TagihanModel();
        $this->payment = new KeuPaymentModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Teller",
            'breadcrumb' => ['Keuangan', 'Teller'],
            'mhs' => [],
            'tagihan' => [],
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\KeuTeller\Views\keuTeller', $data);
    }

    public function loadData()
    {
        $mhs = $this->request->getVar('npm');
        $where = ['dt_mahasiswa."mahasiswaNpm"' => $mhs];
        $mahasiswa = $this->keuTeller->getDataMhs($where)->getResult();
        if (count($mahasiswa) < 1) {
            $msgError = ($mhs == null || $mhs == "") ? 'Npm masih kosong, silahkan isi lalu klik cari' : 'Mahasiswa dengan Npm <strong>' . $mhs . '</strong> tidak ditemukan';
            session()->setFlashdata('error', $msgError);
            return redirect()->to('/keuTeller');
        } else {
            $tahunAjaran = getTahunAjaranBerjalan();
            $whereTagihan = [$mhs, $tahunAjaran[0]->tahunAjaranKode];

            $whereLunas = ['tagihMahasiswaNpm' => $mhs, 'tagihTahun' => $tahunAjaran[0]->tahunAjaranKode];

            $data = [
                'menu' => $this->fetchMenu(),
                'title' => "Teller",
                'breadcrumb' => ['Keuangan', 'Teller'],
                'mhs' => $mahasiswa,
                'tagihan' => $this->keuTeller->getTagihan($whereTagihan)->getResult(),
                'jadwalLunas' => $this->cekJadwalLunas(),
                'isLunas' => $this->tagihanModel->where($whereLunas)->findAll(),
                'validation' => \Config\Services::validation(),
            ];
            // dd($data['jadwalLunas']);
            return view('Modules\KeuTeller\Views\keuTeller', $data);
        }
    }

    public function createInvoice()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $npm = $this->request->getVar('npm');
        $tahunAjaran = getTahunAjaranAktif($npm, 'krs');
        $whereTagihan = [$npm, $tahunAjaran[0]->tahunAjaranKode];
        $tagihan = $this->keuTeller->getTagihan($whereTagihan)->getResult();
        $totalTagihan = 0;
        $saldoDompet =  getSaldoDompet(['savingMahasiswaNpm' => $npm])[0]->savingNominal;
        $saldoDompet = ($saldoDompet == null) ? 0 : $saldoDompet;

        $dataTagihan = [];
        foreach ($tagihan as $tagih) {
            if ($tagih->forceToPay == 1) {
                $totalTagihan = $totalTagihan + $tagih->nominal;
                array_push($dataTagihan, [
                    'id' => $tagih->idTagihan,
                    'tahap' => $tagih->tahap,
                    'item' => $tagih->jenisBiayaId,
                    'isPaid' => 1,
                    'nominal' => $tagih->nominal,
                    'tahunAjar' => $tagih->tahunAjarId
                ]);
            }
        }

        $data = json_decode(json_encode($dataTagihan), true);
        $out = [];
        $tahap = [];
        $tagihId = [];
        foreach ($data as $element) {
            $tahap[] = (int)$element['tahap'];
            $tagihId[] = (int)$element['id'];
            $out[] = [
                'tahap' => (int)$element['tahap'],
                'tagihId' => (int)$element['id'],
                'tahunAjar' => (int)$element['tahunAjar'],
                'detail' => [
                    'item' => (int)$element['item'],
                    'isPaid' => $element['isPaid'],
                    'nominal' => (int)$element['nominal']
                ]
            ];
        }
        // dd($out);
        $genDetail = [];
        $d = [];
        foreach ($tagihId as $index => $initTahap) {
            $d['tahap'] = $tahap[$index];
            $d['paymentTagihId'] = $initTahap;
            $d['detail'] = [];
            foreach ($out as $o) {
                if ($initTahap == $o['tagihId'] && $tahap[$index] == $o['tahap']) {
                    $d['detail'][] = $o['detail'];
                }
            }
            $genDetail[] = $d;
        }
        // dd([$out, $genDetail]);
        // dd(json_encode(['data' => $genDetail]));
        $dataInsert = [
            'paymentDetail' => json_encode(['data' => $genDetail]),
            'paymentBankId' => '999',
            'paymentChannelKode' => 'UMSU',
            'paymentTerminalKode' => 'Keuangan',
            'paymentTanggalBayar' => date('Y-m-d h:i:s'),
            'paymentKeteranganBayar' => 'Terbayar',
            'paymentIsPaid' => '1',
            'paymentCreatedBy' => user()->username,
        ];
        if ($this->payment->insert($dataInsert)) {
            session()->setFlashdata('success', 'Data Pembayaran Berhasil Disimpan!');
            return redirect()->to($url);
        } else {
            session()->setFlashdata('danger', 'Data Pembayaran Gagal Disimpan!');
            return redirect()->to($url);
        }

        // if ($saldoDompet > $totalTagihan) {
        //     dd('Saldo Dompet Lebih Besar dari Tagihan');
        // } else {
        //     dd(json_encode(['data' => $out]));
        //     $data=[];
        //     // $exe = $this->payment->insert();
        // }
    }

    public function getInvoice()
    {
        Xendit::setApiKey('xnd_development_Ei5XAfgqElWW4tuZt6IqpAR5LMPfK8tJ0S2Y0LrzheA2dgf5xAWISMfwqSA');
        $id = '62c4002beae62b1c0612921b';
        $getInvoice = \Xendit\Invoice::retrieve($id);
        d($getInvoice);
    }

    public function setLunas()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        // dd($url);
        $jadwalLunas = $this->cekJadwalLunas();
        $npm = $this->request->getVar('npm');
        $tahun = getTahunAjaranAktif($npm, 'krs')[0]->tahunAjaranKode;
        $cekPayment = cekPaymentExist($npm, $tahun);

        if (count($cekPayment) >= 1) {
            if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) {
                $ket = 'lunas';
                $dataExecute = [$npm, $tahun, $ket];
                $this->keuTeller->callSetUbahMetodeBayar($dataExecute);
            } else {
                $ket = 'lunas';
                $dataExecute = [$npm, $tahun, $ket];
                $this->keuTeller->callSetUbahIsForcePay($dataExecute);
            }
        } else {
            if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) {
                $ket = 'lunas';
                $dataExecute = [$npm, $tahun, $ket];
                $this->keuTeller->callSetUbahMetodeBayar($dataExecute);
            } else {
                $ket = 'lunas';
                $dataExecute = [$npm, $tahun, $ket];
                $this->keuTeller->callSetUbahIsForcePay($dataExecute);
            }
        }

        return redirect()->to($url);
    }

    public function setTahap()
    {

        $url = $this->request->getServer('HTTP_REFERER');
        $jadwalLunas = $this->cekJadwalLunas();
        $npm = $this->request->getVar('npm');
        $tahun = getTahunAjaranAktif($npm, 'krs')[0]->tahunAjaranKode;
        if (count(cekPaymentExist($npm, $tahun)) >= 1) {
            if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) {
                $ket = 'tahap';
                $dataExecute = [$npm, $tahun, $ket];
                $this->keuTeller->callSetUbahIsForcePay($dataExecute);
            } else {
                $ket = 'tahap';
                $dataExecute = [$npm, $tahun, $ket];
                $this->keuTeller->callSetUbahIsForcePay($dataExecute);
            }
        } else {
            if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) {
                $ket = 'tahap';
                $dataExecute = [$npm, $tahun, $ket];
                $this->keuTeller->callSetUbahIsForcePay($dataExecute);
            } else {
                $ket = 'tahap';
                $dataExecute = [$npm, $tahun, $ket];
                $this->keuTeller->callSetUbahIsForcePay($dataExecute);
            }
        }

        return redirect()->to($url);
    }

    public function cekJadwalLunas()
    {
        $npm = $this->request->getVar('npm');
        $tahunAjaran = getTahunAjaranBerjalan();
        $tahun =  $tahunAjaran[0]->tahunAjaranKode;
        $where = [
            'tahap' => 0,
            'jadwalTagihanTahun' => $tahun,
            'dt_mahasiswa."mahasiswaNpm"' => $npm
        ];
        $response = $this->keuTeller->getJadwalLunas($where)->getResult();
        return $response;
    }
}
