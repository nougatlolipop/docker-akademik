<?php

/* 
This is Controller SetRosterKuliah
 */

namespace Modules\SetRosterKuliah\Controllers;

use App\Controllers\BaseController;
use Modules\SetRosterKuliah\Models\SetRosterKuliahModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\WaktuKuliah\Models\WaktuKuliahModel;
use Modules\SetMatkulDitawarkan\Models\SetMatkulDitawarkanModel;
use App\Models\ReferensiModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use Modules\Ruangan\Models\RuanganModel;
use Modules\Fakultas\Models\FakultasModel;


class SetRosterKuliah extends BaseController
{
    protected $setRosterModel;
    protected $referensiModel;
    protected $prodiModel;
    protected $setMatkulDitawarkanModel;
    protected $validation;
    protected $programKuliahModel;
    protected $waktuKuliahModel;
    protected $ruangan;
    protected $fakultasModel;

    public function __construct()
    {
        $this->setRosterModel = new SetRosterKuliahModel();
        $this->referensiModel = new ReferensiModel();
        $this->prodiModel = new ProdiModel();
        $this->setMatkulDitawarkanModel = new SetMatkulDitawarkanModel();
        $this->validation = \Config\Services::validation();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->waktuKuliahModel = new WaktuKuliahModel();
        $this->ruangan = new RuanganModel();
        $this->fakultasModel = new FakultasModel();
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

        $userDetail = getUserDetail();
        if (in_groups('Fakultas')) {
            $fakultas = ['dt_prodi."prodiFakultasId"' => $userDetail[0]->fakultasId];
        } else {
            $fakultas = null;
        }

        $currentPage = $this->request->getVar('page_setRoster') ? $this->request->getVar('page_setRoster') : 1;
        $setRoster = $this->setMatkulDitawarkanModel->getMatkultawar($sourceData, $fakultas);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Roster Kuliah",
            'breadcrumb' => ['Setting', 'Roster Kuliah'],
            'matkulDitawarkan' => $setRoster->paginate($this->numberPage, 'setRoster'),
            'roster' => $this->setRosterModel->getRosterKuliahWhere()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'prodiBiro' => getUserDetail(),
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'waktuKuliah' => $this->waktuKuliahModel->getWaktuKuliah()->findAll(),
            'ruangan' => $this->ruangan->getRuanganGedung()->findAll(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'hari' => $this->referensiModel->getHari()->getResult(),
            'filter' => $filter,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->setMatkulDitawarkanModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\SetRosterKuliah\Views\setRosterKuliah', $data);
    }

    public function add($matkulTawarId)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'jadwalRuanganId' => rv('required', ['required' => 'Gedung ruang kuliah harus dipilih!']),
            'setJadwalKuliahRefHariId' => rv('required', ['required' => 'Hari kuliah harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $tahunAjaran = getTahunAjaranBerjalan()[0]->tahunAjaranId;
        $menit = $this->request->getVar('sksMatkul') * getMenitSks();
        $jamMulai = $this->request->getVar('setJadwalKuliahJamMulai');
        $menitSks = date('H:i', mktime(0, $menit));
        $times = [$jamMulai, $menitSks];
        $jamSelesai = sumTime($times);
        $where = [
            'setting_matkul_tawarkan."setMatkulTawarTahunAjaranId"' => $tahunAjaran,
            'setting_jadwal_kuliah."setJadwalKuliahRuangId"' => $this->request->getVar('jadwalRuanganId'),
            'setting_jadwal_kuliah."setJadwalKuliahRefHariId"' => $this->request->getVar('setJadwalKuliahRefHariId'),
        ];
        $jumlah = $this->setRosterModel->dataExist($where, $jamMulai, $jamSelesai);

        // if ($jumlah == 0) {
        $data = array(
            'setJadwalKuliahMatkulTawarId' => $matkulTawarId,
            'setJadwalKuliahRuangId' => $this->request->getVar('jadwalRuanganId'),
            'setJadwalKuliahRefHariId' => $this->request->getVar('setJadwalKuliahRefHariId'),
            'setJadwalKuliahJamMulai' => $jamMulai,
            'setJadwalKuliahJamSelesai' => $jamSelesai,
            'setJadwalKuliahIsAktif' => 1,
            'setJadwalKuliahCreatedBy' => user()->email,
        );
        if ($this->setRosterModel->insert($data)) {
            session()->setFlashdata('success', 'Data Roster kuliah Berhasil Ditambahkan!');
        }
        // } else {
        //     session()->setFlashdata('failed', 'Ruangan Dan Waktu Kuliah Bentrok!');
        // }
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->setRosterModel->delete($id)) {
            session()->setFlashdata('success', 'Data Roster kuliah Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
