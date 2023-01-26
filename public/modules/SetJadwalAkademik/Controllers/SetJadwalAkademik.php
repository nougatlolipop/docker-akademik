<?php

/* 
This is Controller SetJadwalAkademik
 */

namespace Modules\SetJadwalAkademik\Controllers;

use App\Controllers\BaseController;
use Modules\SetJadwalAkademik\Models\SetJadwalAkademikModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\TahunAjaran\Models\TahunAjaranModel;
use Modules\Fakultas\Models\FakultasModel;


class SetJadwalAkademik extends BaseController
{
    protected $jadwalAkademikModel;
    protected $prodiModel;
    protected $validation;
    protected $tahunAjaran;
    protected $fakultasModel;
    public function __construct()
    {
        $this->jadwalAkademikModel = new SetJadwalAkademikModel();
        $this->prodiModel = new ProdiModel();
        $this->tahunAjaran = new TahunAjaranModel();
        $this->fakultasModel = new FakultasModel();
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

        $currentPage = $this->request->getVar('page_jadwalAkademik') ? $this->request->getVar('page_jadwalAkademik') : 1;

        $jadwalAkademik = $this->jadwalAkademikModel->getJadwalAkademik($sourceData, $fakultas);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jadwal Akademik",
            'breadcrumb' => ['Setting', 'Jadwal Akademik'],
            'jadwal' => $jadwalAkademik->paginate($this->numberPage, 'jadwalAkademik'),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodiBiro' => $userDetail,
            'tahunAjaran' => $this->tahunAjaran->getTahunAjaran()->findAll(),
            'filter' => $filter,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->jadwalAkademikModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\SetJadwalAkademik\Views\setJadwalAkademik', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'setJadwalAkademikTahunAjaranId' => rv('required', ['required' => 'Tahun Ajaran harus dipilih!']),
            'jadwalMulaiPengisianKRS' => rv('required', ['required' => 'Jadwal Mulai Pengisian KRS harus diisi!']),
            'jadwalAkhirPengisianKRS' => rv('required', ['required' => 'Jadwal Akhir Pengisian KRS harus diisi!']),
            'jadwalMulaiInputNilaiUTS' => rv('required', ['required' => 'Jadwal Mulai Penginputan Nilai UTS harus diisi!']),
            'jadwalAkhirInputNilaiUTS' => rv('required', ['required' => 'Jadwal Akhir Penginputan Nilai UTS harus dipilih!']),
            'jadwalMulaiInputNilaiUAS' => rv('required', ['required' => 'Jadwal Mulai Penginputan Nilai UAS harus diisi!']),
            'jadwalAkhirInputNilaiUAS' => rv('required', ['required' => 'Jadwal Akhir Penginputan Nilai UAS harus dipilih!']),
        ];

        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        }

        $prodi = explode(",", $this->request->getVar('setJadwalAkademikProdiId'));

        foreach ($prodi as $dataProdi) {
            $jumlah = $this->jadwalAkademikModel->dataExist([
                'setJadwalAkademikProdiId' => $dataProdi,
                'setJadwalAkademikTahunAjaranId' => $this->request->getVar('setJadwalAkademikTahunAjaranId'),
            ]);
            if ($jumlah == 0) {
                $data = [
                    'setJadwalAkademikProdiId' => $dataProdi,
                    'setJadwalAkademikTahunAjaranId' => $this->request->getVar('setJadwalAkademikTahunAjaranId'),
                    'setJadwalAkademikKrsStartDate' => $this->request->getVar('jadwalMulaiPengisianKRS'),
                    'setJadwalAkademikKrsEndDate' => $this->request->getVar('jadwalAkhirPengisianKRS'),
                    'setJadwalAkademikUtsStartDate' => $this->request->getVar('jadwalMulaiInputNilaiUTS'),
                    'setJadwalAkademikUtsEndDate' => $this->request->getVar('jadwalAkhirInputNilaiUTS'),
                    'setJadwalAkademikUasStartDate' => $this->request->getVar('jadwalMulaiInputNilaiUAS'),
                    'setJadwalAkademikUasEndDate' => $this->request->getVar('jadwalAkhirInputNilaiUAS'),
                    'setJadwalAkademikCreatedBy' => user()->email,
                    'setJadwalAkademikKrsForceAktif' => '0',
                    'setJadwalAkademikUtsForceAktif' => '0',
                    'setJadwalAkademikUasForceAktif' => '0',
                ];
                if ($this->jadwalAkademikModel->insert($data)) {
                    session()->setFlashdata('success', 'Data Jadwal Akademik Berhasil Ditambahkan!');
                }
            } else {
                session()->setFlashdata('failed', 'Data Jadwal Akademik Sudah Disetting!');
            }
        }
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'jadwalMulaiPengisianKRS' => rv('required', ['required' => 'Jadwal Mulai Pengisian KRS harus diisi!']),
            'jadwalAkhirPengisianKRS' => rv('required', ['required' => 'Jadwal Akhir Pengisian KRS harus diisi!']),
            'jadwalMulaiInputNilaiUTS' => rv('required', ['required' => 'Jadwal Mulai Penginputan Nilai UTS harus diisi!']),
            'jadwalAkhirInputNilaiUTS' => rv('required', ['required' => 'Jadwal Akhir Penginputan Nilai UTS harus dipilih!']),
            'jadwalMulaiInputNilaiUAS' => rv('required', ['required' => 'Jadwal Mulai Penginputan Nilai UAS harus diisi!']),
            'jadwalAkhirInputNilaiUAS' => rv('required', ['required' => 'Jadwal Akhir Penginputan Nilai UAS harus dipilih!']),
        ];

        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        }

        $data = [
            'setJadwalAkademikProdiId' => $this->request->getVar('setJadwalAkademikProdiId'),
            'setJadwalAkademikTahunAjaranId' => $this->request->getVar('setJadwalAkademikTahunAjaranId'),
            'setJadwalAkademikKrsStartDate' => $this->request->getVar('jadwalMulaiPengisianKRS'),
            'setJadwalAkademikKrsEndDate' => $this->request->getVar('jadwalAkhirPengisianKRS'),
            'setJadwalAkademikUtsStartDate' => $this->request->getVar('jadwalMulaiInputNilaiUTS'),
            'setJadwalAkademikUtsEndDate' => $this->request->getVar('jadwalAkhirInputNilaiUTS'),
            'setJadwalAkademikUasStartDate' => $this->request->getVar('jadwalMulaiInputNilaiUAS'),
            'setJadwalAkademikUasEndDate' => $this->request->getVar('jadwalAkhirInputNilaiUAS'),
            'setJadwalAkademikCreatedBy' => user()->email,
            'setJadwalAkademikKrsForceAktif' => ($this->request->getVar('pengisianKRSAktif') == null) ? '0' : '1',
            'setJadwalAkademikUtsForceAktif' => ($this->request->getVar('peninputanNilaiUTSAktif') == null) ? '0' : '1',
            'setJadwalAkademikUasForceAktif' => ($this->request->getVar('penginputanNilaiUASAKtif') == null) ? '0' : '1',
        ];
        if ($this->jadwalAkademikModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Jadwal Akademik Berhasil Diubah!');
        }
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->jadwalAkademikModel->delete($id)) {
            session()->setFlashdata('success', 'Data Jadwal Akademik Berhasil Di Hapus!');
            return redirect()->to($url);
        }
    }
}
