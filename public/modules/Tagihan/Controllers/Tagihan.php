<?php

/* 
This is Controller Tagihan
 */

namespace Modules\Tagihan\Controllers;

use App\Controllers\BaseController;
use Modules\KeuTeller\Models\KeuTellerModel;
use Modules\Tagihan\Models\TagihanModel;


class Tagihan extends BaseController
{
    protected $tagihanModel;
    protected $validation;
    protected $keuTeller;

    public function __construct()
    {
        $this->tagihanModel = new TagihanModel();
        $this->keuTeller = new KeuTellerModel();
        $this->validation = \Config\Services::validation();
    }

    public function ubahMetodeTagihan()
    {
        $jadwalLunas = $this->cekJadwalLunas();
        $npm = $this->request->getVar('npm');
        $id = $this->request->getVar('id');
        $ket = $this->request->getVar('ket');
        $tahun = getTahunAjaranAktif($npm, 'krs')[0]->tahunAjaranKode;
        $cekPayment = cekPaymentExist($npm, $tahun);
        if ($this->tagihanModel->update($id, ['tagihMetodeLunas' => $ket])) {
            if ($ket == '1') {
                if (count($cekPayment) >= 1) {
                    if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) {
                        $ket = 'lunas';
                        $dataExecute = [$npm, $tahun, $ket];
                        $this->keuTeller->callSetUbahMetodeBayar($dataExecute);
                        $status = true;
                        $message = 'berhasil';
                    } else {
                        $ket = 'lunas';
                        $dataExecute = [$npm, $tahun, $ket];
                        $this->keuTeller->callSetUbahIsForcePay($dataExecute);
                        $status = true;
                        $message = 'berhasil';
                    }
                } else {
                    if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) {
                        $ket = 'lunas';
                        $dataExecute = [$npm, $tahun, $ket];
                        $this->keuTeller->callSetUbahMetodeBayar($dataExecute);
                        $status = true;
                        $message = 'berhasil';
                    } else {
                        $ket = 'lunas';
                        $dataExecute = [$npm, $tahun, $ket];
                        $this->keuTeller->callSetUbahIsForcePay($dataExecute);
                        $status = true;
                        $message = 'berhasil';
                    }
                }
            } else if ($ket == '0') {
                if (count(cekPaymentExist($npm, $tahun)) >= 1) {
                    if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) {
                        $ket = 'tahap';
                        $dataExecute = [$npm, $tahun, $ket];
                        $this->keuTeller->callSetUbahIsForcePay($dataExecute);
                        $status = true;
                        $message = 'berhasil';
                    } else {
                        $ket = 'tahap';
                        $dataExecute = [$npm, $tahun, $ket];
                        $this->keuTeller->callSetUbahIsForcePay($dataExecute);
                        $status = true;
                        $message = 'berhasil';
                    }
                } else {
                    if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) {
                        $ket = 'tahap';
                        $dataExecute = [$npm, $tahun, $ket];
                        $this->keuTeller->callSetUbahIsForcePay($dataExecute);
                        $status = true;
                        $message = 'berhasil';
                    } else {
                        $ket = 'tahap';
                        $dataExecute = [$npm, $tahun, $ket];
                        $this->keuTeller->callSetUbahIsForcePay($dataExecute);
                        $status = true;
                        $message = 'berhasil';
                    }
                }
            }
        }

        $whereTagihan = [$npm, $tahun];
        $tagihan = $this->keuTeller->getTagihan($whereTagihan)->getResult();
        $total = 0;
        foreach ($tagihan as $row) {
            if ($row->forceToPay == '1') {
                $total = $total + $row->nominal;
            }
        }

        $data = [
            "status" => $status,
            "message" => $message,
            "data" => $ket,
            "total" => $total,
            "detail" => $tagihan,
        ];
        $saldoDompet =  getSaldoDompet(['savingMahasiswaNpm' => $npm])[0]->savingNominal;
        $saldoDompet = ($saldoDompet == null) ? 0 : $saldoDompet;
        $data['dompet'] = $saldoDompet;
        echo json_encode($data);
    }


    public function cekJadwalLunas()
    {
        $npm = $this->request->getVar('npm');
        $tahunAjaran = getTahunAjaranAktif($npm, 'krs');
        $tahun =  $tahunAjaran[0]->tahunAjaranKode;
        $where = [
            'tahap' => 0,
            '"jadwalTagihanTahun"' => $tahun,
            'dt_mahasiswa."mahasiswaNpm"' => $npm
        ];
        $response = $this->keuTeller->getJadwalLunas($where)->getResult();
        return $response;
    }

    public function ubahTagihan()
    {
        $id = $this->request->getVar('id');
        $tahap = $this->request->getVar('tahap');
        $ket = $this->request->getVar('ket');
        $from = $this->request->getVar('from');

        if ($this->tagihanModel->updateTagihan([$id, $tahap, $ket])) {
            $status = true;
            $msg = 'Berhasil';
        } else {
            $status = false;
            $msg = 'Gagal';
        };

        if ($from == 'mahasiswa') {
            $mhs = user()->username;
        } elseif ($from == 'teller') {
            $mhs = $this->request->getVar('npm');
        }

        $tahunAjaran = getTahunAjaranAktif($mhs, 'krs');
        $whereTagihan = [$mhs, $tahunAjaran[0]->tahunAjaranKode];
        $tagihan = $this->keuTeller->getTagihan($whereTagihan)->getResult();
        $total = 0;
        foreach ($tagihan as $row) {
            if ($row->forceToPay == '1') {
                $total = $total + $row->nominal;
            }
        }

        $data = [
            "status" => $status,
            "message" => $msg,
            "data" => $ket,
            "total" => $total,
        ];
        $saldoDompet =  getSaldoDompet(['savingMahasiswaNpm' => $mhs])[0]->savingNominal;
        $saldoDompet = ($saldoDompet == null) ? 0 : $saldoDompet;
        $data['dompet'] = $saldoDompet;
        echo json_encode($data);
    }

    public function ubahTagihanHer()
    {
        $id = $this->request->getVar('id');
        $tahap = $this->request->getVar('tahap');
        $ket = $this->request->getVar('ket');
        $from = $this->request->getVar('from');

        if ($this->tagihanModel->updateTagihanHer([$id, $tahap, $ket])) {
            $status = true;
            $msg = 'Berhasil';
        } else {
            $status = false;
            $msg = 'Gagal';
        };

        if ($from == 'mahasiswa') {
            $mhs = $this->request->getVar('npm');
        } elseif ($from == 'teller') {
            $mhs = $this->request->getVar('npm');
        }

        $tahunAjaran = getTahunAjaranAktif($mhs, 'krs');
        $whereTagihan = [$mhs, $tahunAjaran[0]->tahunAjaranKode];
        $tagihan = $this->keuTeller->getTagihan($whereTagihan)->getResult();
        $total = 0;
        foreach ($tagihan as $row) {
            if ($row->forceToPay == '1') {
                $total = $total + $row->nominal;
            }
        }

        $data = [
            "status" => $status,
            "message" => $msg,
            "data" => $ket,
            "total" => $total,
        ];
        $saldoDompet =  getSaldoDompet(['savingMahasiswaNpm' => $mhs])[0]->savingNominal;
        $saldoDompet = ($saldoDompet == null) ? 0 : $saldoDompet;
        $data['dompet'] = $saldoDompet;
        echo json_encode($data);
    }

    public function ubahTagihanLain()
    {
        $id = $this->request->getVar('id');
        $ket = $this->request->getVar('ket');
        $from = $this->request->getVar('from');

        if ($this->tagihanModel->updateTagihanLain([$id, $ket])) {
            $status = true;
            $msg = 'Berhasil';
        } else {
            $status = false;
            $msg = 'Gagal';
        };

        if ($from == 'mahasiswa') {
            $mhs = user()->username;
        } elseif ($from == 'teller') {
            $mhs = $this->request->getVar('npm');
        }

        $tahunAjaran = getTahunAjaranAktif($mhs, 'krs');
        $whereTagihan = [$mhs, $tahunAjaran[0]->tahunAjaranKode];
        $tagihan = $this->keuTeller->getTagihan($whereTagihan)->getResult();
        $total = 0;
        foreach ($tagihan as $row) {
            if ($row->forceToPay == '1') {
                $total = $total + $row->nominal;
            }
        }

        $data = [
            "status" => $status,
            "message" => $msg,
            "data" => $ket,
            "total" => $total,
        ];
        echo json_encode($data);
    }
}
