<?php

/* 
This is Controller Krs
 */

namespace Modules\TagihanLain\Controllers;

use App\Controllers\BaseController;
use App\Models\ReferensiModel;
use Modules\KeuTarifTambahan\Models\KeuTarifTambahanModel;
use Modules\KeuTeller\Models\KeuTellerModel;
use Modules\TagihanLain\Models\TagihanLainModel;

class TagihanLain extends BaseController
{

    protected $tagihanLainModel;
    protected $validation;
    protected $referensiModel;
    protected $keuTeller;
    public function __construct()
    {
        $this->tagihanLainModel = new TagihanLainModel();
        $this->keuTarifTambahanModel = new KeuTarifTambahanModel();
        $this->referensiModel = new ReferensiModel();
        $this->keuTeller = new KeuTellerModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Tagihan Tambahan",
            'breadcrumb' => ['Keuangan', 'Tagihan Tambahan'],
            'validation' => \Config\Services::validation(),

        ];
        return view('Modules\TagihanLain\Views\tagihanLain', $data);
    }

    public function add()
    {
        $npm = $this->request->getVar('npm');
        $id = $this->request->getVar('id');
        $jumlah = $this->request->getVar('jumlah');

        $tahunAjaran = getTahunAjaranAktif($npm, 'krs');
        $whereTagihan = [$npm, $tahunAjaran[0]->tahunAjaranKode];
        $tagihanLainInfo = $this->keuTarifTambahanModel->getInfoTarifTambahan(['tarifLainId' => $id])->findAll();
        $infoTanggal = $this->referensiModel->getJadwalBayarInfo($whereTagihan, ['tahap' => $tagihanLainInfo[0]->tarifLainIncludeTahap])->getResult();

        $data = [
            'tagihLainKodeBayar' => 9,
            'tagihLainMahasiswaNpm' => $npm,
            'tagihLainVaNumber' => (int)'824100' . $npm,
            'tagihLainTahunAjaran' => $tahunAjaran[0]->tahunAjaranId,
            'tagihLainTahapBayar' => 1,
            'tagihLainJenisBiayaId' => $id,
            'tagihLainNominal' => ((int)$jumlah * $tagihanLainInfo[0]->tarifLainNominal),
            'tagihLainDiskon' => 0,
            'tagihLainJumlah' => (int)$jumlah,
            'tagihLainChannelKode' => '',
            'tagihLainTerminalKode' => '',
            'tagihLainTanggalMulai' => $infoTanggal[0]->mulai,
            'tagihLainTanggalSelesai' => $infoTanggal[0]->selesai,
            'tagihLainIsForceToPay' => '1',
            'tagihLainIsPaid' => '0',
            'tagihLainCreatedBy' => $npm,
        ];

        $saldoDompet =  getSaldoDompet(['savingMahasiswaNpm' => $npm])[0]->savingNominal;

        $response = [];
        if ($this->tagihanLainModel->insert($data)) {
            $tagihanLainInfo = $this->tagihanLainModel->getInfo(['tagihLainId' => $this->tagihanLainModel->insertID()])->findAll();
            $tagihan = $this->keuTeller->getTagihan($whereTagihan)->getResult();
            $total = 0;
            foreach ($tagihan as $row) {
                if ($row->forceToPay == '1') {
                    $total = $total + $row->nominal;
                }
            }

            $response = ['status' => true, 'message' => 'berhasil', 'dataInsert' => $data, 'infoTagihan' => $tagihanLainInfo[0], "total" => $total, "saldoDompet" => $saldoDompet];
        } else {
            $response = ['status' => false, 'message' => 'gagal'];
        }

        echo json_encode($response);
    }
}
