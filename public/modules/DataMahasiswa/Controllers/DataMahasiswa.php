<?php

/* 
This is Controller DataMahasiswa
 */

namespace Modules\DataMahasiswa\Controllers;

use App\Controllers\BaseController;
use Modules\DataMahasiswa\Models\DataMahasiswaModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\Prodi\Models\ProdiModel;
use Modules\WaktuKuliah\Models\WaktuKuliahModel;
use Modules\ProgramKuliah\Models\ProgramKuliahModel;
use App\Models\ReferensiModel;


class DataMahasiswa extends BaseController
{

    protected $dataMahasiswaModel;
    protected $fakultasModel;
    protected $prodiModel;
    protected $waktuKuliahModel;
    protected $programKuliahModel;
    protected $referensiModel;
    protected $validation;

    public function __construct()
    {
        $this->dataMahasiswaModel = new DataMahasiswaModel();
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
        $this->programKuliahModel = new ProgramKuliahModel();
        $this->waktuKuliahModel = new WaktuKuliahModel();
        $this->referensiModel = new ReferensiModel();
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

        $userDetail = getUserDetail();
        if (in_groups('Fakultas')) {
            $fakultas = ['dt_prodi."prodiFakultasId"' => $userDetail[0]->fakultasId];
        } else {
            $fakultas = null;
        }

        $currentPage = $this->request->getVar('page_dataMahasiswa') ? $this->request->getVar('page_dataMahasiswa') : 1;
        $dataMahasiswa = $this->dataMahasiswaModel->getDataMahasiswa($sourceData, $fakultas);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Mahasiswa",
            'breadcrumb' => ['Data', 'Mahasiswa'],
            'dataMahasiswa' => $dataMahasiswa->paginate($this->numberPage, 'dataMahasiswa'),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'prodiBiro' => $userDetail,
            'programKuliah' => $this->programKuliahModel->getProgramKuliah()->findAll(),
            'waktuKuliah' => $this->waktuKuliahModel->getWaktuKuliah()->findAll(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'filter' => $filter,
            'pager' => $this->dataMahasiswaModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        // dd($data['dataMahasiswa']);
        return view('Modules\DataMahasiswa\Views\dataMahasiswa', $data);
    }

    // public function add()
    // {
    //     $url = $this->request->getServer('HTTP_REFERER');
    //     $rules = [
    //         'dataMahasiswaNama' => rv('required', ['required' => 'Nama lengkap dataMahasiswa harus diisi!']),
    //         'dataMahasiswaUsername' => rv('required', ['required' => 'Username akun harus diisi!']),
    //         'dataMahasiswaPassword' => rv('required', ['required' => 'Password akun harus diisi!']),
    //         // 'dataMahasiswaNip' => rv('required', ['required' => 'NIP dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNIDN' => rv('required', ['required' => 'NIDN dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNUPTK' => rv('required', ['required' => 'NUPTK dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNoSerdos' => rv('required', ['required' => 'No. serdos harus diisi!']),
    //         // 'dataMahasiswaStatusDataMahasiswa' => rv('required', ['required' => 'Status dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaStatusAktif' => rv('required', ['required' => 'Status aktif dipilih!']),
    //         'dataMahasiswaGelarDepan' => rv('required', ['required' => 'Gelar depan dataMahasiswa harus diisi!']),
    //         'dataMahasiswaGelarBelakang' => rv('required', ['required' => 'Gelar Belakang dataMahasiswa harus diisi!']),
    //         'dataMahasiswaJenjangPendidikan' => rv('required', ['required' => 'Jenjang pendidikan dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaTempatLahir' => rv('required', ['required' => 'Tempat lahir dataMahasiswa harus diisi!']),
    //         'dataMahasiswaTanggalLahir' => rv('required', ['required' => 'Tanggal lahir dataMahasiswa harus diisi!']),
    //         'dataMahasiswaJenisKelamin' => rv('required', ['required' => 'Jenis kelamin dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaAgama' => rv('required', ['required' => 'Agama dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaGolDarah' => rv('required', ['required' => 'Gol. darah dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaKecamatan' => rv('required', ['required' => 'Kecamatan dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaAlamat' => rv('required', ['required' => 'Alamat dataMahasiswa harus diisi!']),
    //         'dataMahasiswaStatusNikah' => rv('required', ['required' => 'Status nikah dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaNIK' => rv('required', ['required' => 'NIK dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNoNBM' => rv('required', ['required' => 'No. NBM dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNoNPWP' => rv('required', ['required' => 'No. NPWP dataMahasiswa harus diisi!']),
    //         'dataMahasiswaEmailCorporate' => rv('required', ['required' => 'Email universitas dataMahasiswa harus diisi!']),
    //         'dataMahasiswaEmailGeneral' => rv('required', ['required' => 'Email pribadi dataMahasiswa harus diisi!']),
    //         'dataMahasiswaNoHandphone' => rv('required', ['required' => 'No. handphone dataMahasiswa harus diisi!']),
    //         'dataMahasiswaFoto' => rv('uploaded[dataMahasiswaFoto]', ['uploaded' => 'Foto dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaDokumenKTP' => rv('uploaded[dataMahasiswaDokumenKTP]', ['uploaded' => 'KTP harus dipilih!']),
    //         // 'dataMahasiswaDokumenIjazah' => rv('uploaded[dataMahasiswaDokumenIjazah]', ['uploaded' => 'Ijazah harus dipilih!']),
    //         // 'dataMahasiswaDokumenNBM' => rv('uploaded[dataMahasiswaDokumenNBM]', ['uploaded' => 'Dokumen NBM harus dipilih!']),
    //         // 'dataMahasiswaDokumenNPWP' => rv('uploaded[dataMahasiswaDokumenNPWP]', ['uploaded' => 'Dokumen NPWP harus dipilih!']),
    //         // 'dataMahasiswaDokumenSerdos' => rv('uploaded[dataMahasiswaDokumenSerdos]', ['uploaded' => 'Dokumen serdos harus dipilih!']),
    //         // 'dataMahasiswaSertifikatKeahlian' => rv('uploaded[dataMahasiswaSertifikatKeahlian]', ['uploaded' => 'Sertifikat keahlian dataMahasiswa harus dipilih!']),
    //     ];
    //     if (!$this->validate($rules)) {
    //         return redirect()->to($url)->withInput();
    //     };

    //     $file = $this->request->getFile('dataMahasiswaFoto');
    //     $file->move('Dokumen/fotoDataMahasiswa');
    //     $fotoDataMahasiswa = $file->getName();

    //     $file = $this->request->getFile('dataMahasiswaDokumenKTP');
    //     $file->move('Dokumen/ktpDataMahasiswa');
    //     $ktpDataMahasiswa = $file->getName();

    //     $file = $this->request->getFile('dataMahasiswaDokumenNBM');
    //     $file->move('Dokumen/nbmDataMahasiswa');
    //     $nbmDataMahasiswa = $file->getName();

    //     $file = $this->request->getFile('dataMahasiswaDokumenNPWP');
    //     $file->move('Dokumen/npwpDataMahasiswa');
    //     $npwpDataMahasiswa = $file->getName();

    //     $file = $this->request->getFile('dataMahasiswaDokumenSerdos');
    //     $file->move('Dokumen/serdosDataMahasiswa');
    //     $serdosDataMahasiswa = $file->getName();

    //     $file = $this->request->getFile('dataMahasiswaDokumenIjazah');
    //     $file->move('Dokumen/ijazahDataMahasiswa');
    //     $ijazahDataMahasiswa = $file->getName();

    //     $ijazah = [];
    //     $dataSertifikat = ['ijazah' => $ijazahDataMahasiswa];
    //     array_push($ijazah, $dataSertifikat);
    //     $namaIjazah = json_encode($ijazah);

    //     $file = $this->request->getFile('dataMahasiswaSertifikatKeahlian');
    //     $file->move('Dokumen/sertifikatDataMahasiswa');
    //     $sertifikatDataMahasiswa = $file->getName();

    //     $sertifikat = [];
    //     $dataSertifikat = ['sertifikat' => $sertifikatDataMahasiswa];
    //     array_push($sertifikat, $dataSertifikat);
    //     $namaSertifikat = json_encode($sertifikat);
    //     // dd($namaSertifikat);`

    //     $data = array(
    //         'dataMahasiswaFoto' => $fotoDataMahasiswa,
    //         'dataMahasiswaDokumenKTP' => $ktpDataMahasiswa,
    //         // 'dataMahasiswaDokumenIjazah' => $namaIjazah,
    //         // 'dataMahasiswaDokumenNBM' => $nbmDataMahasiswa,
    //         // 'dataMahasiswaDokumenNPWP' => $npwpDataMahasiswa,
    //         // 'dataMahasiswaDokumenSerdos' => $serdosDataMahasiswa,
    //         // 'dataMahasiswaSertifikatKeahlian' => $namaSertifikat,
    //         'dataMahasiswaUsername' => $this->request->getVar('dataMahasiswaUsername'),
    //         'dataMahasiswaPassword' => $this->request->getVar('dataMahasiswaPassword'),
    //         // 'dataMahasiswaNip' => $this->request->getVar('dataMahasiswaNip'),
    //         'dataMahasiswaNama' => $this->request->getVar('dataMahasiswaNama'),
    //         // 'dataMahasiswaNIDN' => $this->request->getVar('dataMahasiswaNIDN'),
    //         // 'dataMahasiswaNUPTK' => $this->request->getVar('dataMahasiswaNUPTK'),
    //         // 'dataMahasiswaNoSerdos' => $this->request->getVar('dataMahasiswaNoSerdos'),
    //         // 'dataMahasiswaStatusDataMahasiswa' => $this->request->getVar('dataMahasiswaStatusDataMahasiswa'),
    //         'dataMahasiswaStatusAktif' => $this->request->getVar('dataMahasiswaStatusAktif'),
    //         'dataMahasiswaGelarDepan' => $this->request->getVar('dataMahasiswaGelarDepan'),
    //         'dataMahasiswaGelarBelakang' => $this->request->getVar('dataMahasiswaGelarBelakang'),
    //         'dataMahasiswaJenjangPendidikan' => $this->request->getVar('dataMahasiswaJenjangPendidikan'),
    //         'dataMahasiswaTempatLahir' => $this->request->getVar('dataMahasiswaTempatLahir'),
    //         'dataMahasiswaTanggalLahir' => $this->request->getVar('dataMahasiswaTanggalLahir'),
    //         'dataMahasiswaJenisKelamin' => $this->request->getVar('dataMahasiswaJenisKelamin'),
    //         'dataMahasiswaAgama' => $this->request->getVar('dataMahasiswaAgama'),
    //         'dataMahasiswaGolDarah' => $this->request->getVar('dataMahasiswaGolDarah'),
    //         'dataMahasiswaKecamatan' => $this->request->getVar('dataMahasiswaKecamatan'),
    //         'dataMahasiswaAlamat' => $this->request->getVar('dataMahasiswaAlamat'),
    //         'dataMahasiswaStatusNikah' => $this->request->getVar('dataMahasiswaStatusNikah'),
    //         'dataMahasiswaNIK' => $this->request->getVar('dataMahasiswaNIK'),
    //         // 'dataMahasiswaNoNBM' => $this->request->getVar('dataMahasiswaNoNBM'),
    //         // 'dataMahasiswaNoNPWP' => $this->request->getVar('dataMahasiswaNoNPWP'),
    //         'dataMahasiswaEmailCorporate' => $this->request->getVar('dataMahasiswaEmailCorporate'),
    //         'dataMahasiswaEmailGeneral' => $this->request->getVar('dataMahasiswaEmailGeneral'),
    //         'dataMahasiswaNoHandphone' => $this->request->getVar('dataMahasiswaNoHandphone'),
    //         'dataMahasiswaCreatedBy' => user()->email,
    //     );
    //     // dd($data);
    //     if ($this->dataMahasiswaModel->insert($data)) {
    //         session()->setFlashdata('success', 'Data DataMahasiswa Berhasil Ditambahkan!');
    //         return redirect()->to($url);
    //     }
    // }

    // public function edit($id)
    // {
    //     $url = $this->request->getServer('HTTP_REFERER');
    //     $rules = [
    //         'dataMahasiswaNama' => rv('required', ['required' => 'Nama lengkap dataMahasiswa harus diisi!']),
    //         'dataMahasiswaUsername' => rv('required', ['required' => 'Username akun harus diisi!']),
    //         'dataMahasiswaPassword' => rv('required', ['required' => 'Password akun harus diisi!']),
    //         // 'dataMahasiswaNip' => rv('required', ['required' => 'NIP dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNIDN' => rv('required', ['required' => 'NIDN dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNUPTK' => rv('required', ['required' => 'NUPTK dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNoSerdos' => rv('required', ['required' => 'No. serdos harus diisi!']),
    //         // 'dataMahasiswaStatusDataMahasiswa' => rv('required', ['required' => 'Status dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaStatusAktif' => rv('required', ['required' => 'Status aktif dipilih!']),
    //         'dataMahasiswaGelarDepan' => rv('required', ['required' => 'Gelar depan dataMahasiswa harus diisi!']),
    //         'dataMahasiswaGelarBelakang' => rv('required', ['required' => 'Gelar Belakang dataMahasiswa harus diisi!']),
    //         'dataMahasiswaJenjangPendidikan' => rv('required', ['required' => 'Jenjang pendidikan dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaTempatLahir' => rv('required', ['required' => 'Tempat lahir dataMahasiswa harus diisi!']),
    //         'dataMahasiswaTanggalLahir' => rv('required', ['required' => 'Tanggal lahir dataMahasiswa harus diisi!']),
    //         'dataMahasiswaJenisKelamin' => rv('required', ['required' => 'Jenis kelamin dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaAgama' => rv('required', ['required' => 'Agama dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaGolDarah' => rv('required', ['required' => 'Gol. darah dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaKecamatan' => rv('required', ['required' => 'Kecamatan dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaAlamat' => rv('required', ['required' => 'Alamat dataMahasiswa harus diisi!']),
    //         'dataMahasiswaStatusNikah' => rv('required', ['required' => 'Status nikah dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaNIK' => rv('required', ['required' => 'NIK dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNoNBM' => rv('required', ['required' => 'No. NBM dataMahasiswa harus diisi!']),
    //         // 'dataMahasiswaNoNPWP' => rv('required', ['required' => 'No. NPWP dataMahasiswa harus diisi!']),
    //         'dataMahasiswaEmailCorporate' => rv('required', ['required' => 'Email universitas dataMahasiswa harus diisi!']),
    //         'dataMahasiswaEmailGeneral' => rv('required', ['required' => 'Email pribadi dataMahasiswa harus diisi!']),
    //         'dataMahasiswaNoHandphone' => rv('required', ['required' => 'No. handphone dataMahasiswa harus diisi!']),
    //         'dataMahasiswaFoto' => rv('uploaded[dataMahasiswaFoto]', ['uploaded' => 'Foto dataMahasiswa harus dipilih!']),
    //         'dataMahasiswaDokumenKTP' => rv('uploaded[dataMahasiswaDokumenKTP]', ['uploaded' => 'KTP harus dipilih!']),
    //         // 'dataMahasiswaDokumenIjazah' => rv('uploaded[dataMahasiswaDokumenIjazah]', ['uploaded' => 'Ijazah harus dipilih!']),
    //         // 'dataMahasiswaDokumenNBM' => rv('uploaded[dataMahasiswaDokumenNBM]', ['uploaded' => 'Dokumen NBM harus dipilih!']),
    //         // 'dataMahasiswaDokumenNPWP' => rv('uploaded[dataMahasiswaDokumenNPWP]', ['uploaded' => 'Dokumen NPWP harus dipilih!']),
    //         // 'dataMahasiswaDokumenSerdos' => rv('uploaded[dataMahasiswaDokumenSerdos]', ['uploaded' => 'Dokumen serdos harus dipilih!']),
    //         // 'dataMahasiswaSertifikatKeahlian' => rv('uploaded[dataMahasiswaSertifikatKeahlian]', ['uploaded' => 'Sertifikat keahlian dataMahasiswa harus dipilih!']),
    //     ];
    //     if (!$this->validate($rules)) {
    //         return redirect()->to($url)->withInput();
    //     };

    //     $file = $this->request->getFile('dataMahasiswaFoto');
    //     if ($file->getError() == 4) {
    //         $fotoDataMahasiswa = $this->request->getVar('dataMahasiswaFotoLama');
    //     } else {
    //         $file->move('Dokumen/fotoDataMahasiswa');
    //         $fotoDataMahasiswa = $file->getName();
    //         unlink('Dokumen/fotoDataMahasiswa/' . $this->request->getVar('dataMahasiswaFotoLama'));
    //     }

    //     $file = $this->request->getFile('dataMahasiswaDokumenKTP');
    //     if ($file->getError() == 4) {
    //         $ktpDataMahasiswa = $this->request->getVar('dataMahasiswaDokumenKTPLama');
    //     } else {
    //         $file->move('Dokumen/ktpDataMahasiswa');
    //         $ktpDataMahasiswa = $file->getName();
    //         unlink('Dokumen/ktpDataMahasiswa/' . $this->request->getVar('dataMahasiswaDokumenKTPLama'));
    //     }

    //     $file = $this->request->getFile('dataMahasiswaDokumenNBM');
    //     if ($file->getError() == 4) {
    //         $nbmDataMahasiswa = $this->request->getVar('dataMahasiswaDokumenNBMLama');
    //     } else {
    //         $file->move('Dokumen/nbmDataMahasiswa');
    //         $nbmDataMahasiswa = $file->getName();
    //         unlink('Dokumen/nbmDataMahasiswa/' . $this->request->getVar('dataMahasiswaDokumenNBMLama'));
    //     }

    //     $file = $this->request->getFile('dataMahasiswaDokumenNPWP');
    //     if ($file->getError() == 4) {
    //         $npwpDataMahasiswa = $this->request->getVar('dataMahasiswaDokumenNPWPLama');
    //     } else {
    //         $file->move('Dokumen/npwpDataMahasiswa');
    //         $npwpDataMahasiswa = $file->getName();
    //         unlink('Dokumen/npwpDataMahasiswa/' . $this->request->getVar('dataMahasiswaDokumenNPWPLama'));
    //     }

    //     $file = $this->request->getFile('dataMahasiswaDokumenSerdos');
    //     if ($file->getError() == 4) {
    //         $serdosDataMahasiswa = $this->request->getVar('dataMahasiswaDokumenSerdosLama');
    //     } else {
    //         $file->move('Dokumen/serdosDataMahasiswa');
    //         $serdosDataMahasiswa = $file->getName();
    //         unlink('Dokumen/serdosDataMahasiswa/' . $this->request->getVar('dataMahasiswaDokumenSerdosLama'));
    //     }

    //     // json sampai sini

    //     // $file = $this->request->getFile('dataMahasiswaDokumenIjazah');
    //     // $file->move('Dokumen/ijazahDataMahasiswa');
    //     // $ijazahDataMahasiswa = $file->getName();

    //     // $ijazah = [];
    //     // $dataSertifikat = ['ijazah' => $ijazahDataMahasiswa];
    //     // array_push($ijazah, $dataSertifikat);
    //     // $namaIjazah = json_encode($ijazah);

    //     // $file = $this->request->getFile('dataMahasiswaSertifikatKeahlian');
    //     // $file->move('Dokumen/sertifikatDataMahasiswa');
    //     // $sertifikatDataMahasiswa = $file->getName();

    //     // $sertifikat = [];
    //     // $dataSertifikat = ['sertifikat' => $sertifikatDataMahasiswa];
    //     // array_push($sertifikat, $dataSertifikat);
    //     // $namaSertifikat = json_encode($sertifikat);
    //     // dd($namaSertifikat);`

    //     $data = array(
    //         'dataMahasiswaFoto' => $fotoDataMahasiswa,
    //         'dataMahasiswaDokumenKTP' => $ktpDataMahasiswa,
    //         // 'dataMahasiswaDokumenIjazah' => $namaIjazah,
    //         // 'dataMahasiswaDokumenNBM' => $nbmDataMahasiswa,
    //         // 'dataMahasiswaDokumenNPWP' => $npwpDataMahasiswa,
    //         // 'dataMahasiswaDokumenSerdos' => $serdosDataMahasiswa,
    //         // 'dataMahasiswaSertifikatKeahlian' => $namaSertifikat,
    //         'dataMahasiswaUsername' => $this->request->getVar('dataMahasiswaUsername'),
    //         'dataMahasiswaPassword' => $this->request->getVar('dataMahasiswaPassword'),
    //         // 'dataMahasiswaNip' => $this->request->getVar('dataMahasiswaNip'),
    //         'dataMahasiswaNama' => $this->request->getVar('dataMahasiswaNama'),
    //         // 'dataMahasiswaNIDN' => $this->request->getVar('dataMahasiswaNIDN'),
    //         // 'dataMahasiswaNUPTK' => $this->request->getVar('dataMahasiswaNUPTK'),
    //         // 'dataMahasiswaNoSerdos' => $this->request->getVar('dataMahasiswaNoSerdos'),
    //         // 'dataMahasiswaStatusDataMahasiswa' => $this->request->getVar('dataMahasiswaStatusDataMahasiswa'),
    //         'dataMahasiswaStatusAktif' => $this->request->getVar('dataMahasiswaStatusAktif'),
    //         'dataMahasiswaGelarDepan' => $this->request->getVar('dataMahasiswaGelarDepan'),
    //         'dataMahasiswaGelarBelakang' => $this->request->getVar('dataMahasiswaGelarBelakang'),
    //         'dataMahasiswaJenjangPendidikan' => $this->request->getVar('dataMahasiswaJenjangPendidikan'),
    //         'dataMahasiswaTempatLahir' => $this->request->getVar('dataMahasiswaTempatLahir'),
    //         'dataMahasiswaTanggalLahir' => $this->request->getVar('dataMahasiswaTanggalLahir'),
    //         'dataMahasiswaJenisKelamin' => $this->request->getVar('dataMahasiswaJenisKelamin'),
    //         'dataMahasiswaAgama' => $this->request->getVar('dataMahasiswaAgama'),
    //         'dataMahasiswaGolDarah' => $this->request->getVar('dataMahasiswaGolDarah'),
    //         'dataMahasiswaKecamatan' => $this->request->getVar('dataMahasiswaKecamatan'),
    //         'dataMahasiswaAlamat' => $this->request->getVar('dataMahasiswaAlamat'),
    //         'dataMahasiswaStatusNikah' => $this->request->getVar('dataMahasiswaStatusNikah'),
    //         'dataMahasiswaNIK' => $this->request->getVar('dataMahasiswaNIK'),
    //         // 'dataMahasiswaNoNBM' => $this->request->getVar('dataMahasiswaNoNBM'),
    //         // 'dataMahasiswaNoNPWP' => $this->request->getVar('dataMahasiswaNoNPWP'),
    //         'dataMahasiswaEmailCorporate' => $this->request->getVar('dataMahasiswaEmailCorporate'),
    //         'dataMahasiswaEmailGeneral' => $this->request->getVar('dataMahasiswaEmailGeneral'),
    //         'dataMahasiswaNoHandphone' => $this->request->getVar('dataMahasiswaNoHandphone'),
    //         'dataMahasiswaModifiedBy' => user()->email,
    //     );

    //     if ($this->dataMahasiswaModel->update($id, $data)) {
    //         session()->setFlashdata('success', 'Data DataMahasiswa Berhasil Diubah!');
    //         return redirect()->to($url);
    //     }
    // }

    // public function delete($id)
    // {
    //     $url = $this->request->getServer('HTTP_REFERER');
    //     if ($this->dataMahasiswaModel->delete($id)) {
    //         session()->setFlashdata('success', 'Data DataMahasiswa Berhasil Dihapus!');
    //     };
    //     return redirect()->to($url);
    // }
}
