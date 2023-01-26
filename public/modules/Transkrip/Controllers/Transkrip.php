<?php

/* 
This is Controller Krs
 */

namespace Modules\Transkrip\Controllers;

use App\Controllers\BaseController;
use Modules\KhsMahasiswa\Models\KhsMahasiswaModel;
use Modules\Konversi\Models\KonversiModel;
use Modules\MatkulGroup\Models\MatkulGroupModel;
use Modules\Transkrip\Models\TranskripModel;
use Modules\setMatkulKurikulum\Models\SetMatkulKurikulumModel;

class Transkrip extends BaseController
{
    protected $khsModel;
    protected $transkripModel;
    protected $matkulGroupModel;
    protected $khsMahasiswaModel;
    protected $konversiModel;
    protected $setMatkulKurikulumModel;

    public function __construct()
    {
        $this->khsModel = new KhsMahasiswaModel();
        $this->transkripModel = new TranskripModel();
        $this->setMatkulKurikulumModel = new SetMatkulKurikulumModel();
        $this->matkulGroupModel = new MatkulGroupModel();
        $this->khsMahasiswaModel = new KhsMahasiswaModel();
        $this->konversiModel = new KonversiModel();
    }

    public function index()
    {
        $npm = $this->request->getVar('npm');
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Transkrip Nilai " . $npm,
            'breadcrumb' => ['Akademik', 'Transkrip Nilai'],
            'transkrip' => ($npm == null) ? [] : $this->transkrip($npm),
            'group' => $this->matkulGroupModel->getMatkulGroupAll()->findAll(),
            'nilai' => ($npm == null) ? [] : $this->collectNilai($npm)
        ];
        dd($data['transkrip']);
        return view('Modules\Transkrip\Views\transkrip', $data);
    }

    public function transkrip($npm)
    {
        $where = [
            'dt_mahasiswa."mahasiswaNpm"' => $npm,
        ];
        return $this->setMatkulKurikulumModel->matkulTranskrip($where)->findAll();
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
}
