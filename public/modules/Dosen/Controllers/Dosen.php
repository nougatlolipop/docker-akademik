<?php

/* 
This is Controller Dosen
 */

namespace Modules\Dosen\Controllers;

use App\Controllers\BaseController;
use Modules\Dosen\Models\DosenModel;
use Modules\SetDosenProdi\Models\SetDosenProdiModel;
use App\Models\ReferensiModel;


class Dosen extends BaseController
{
    protected $dosenModel;
    protected $setDosenProdiModel;
    protected $referensiModel;
    protected $validation;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->setDosenProdiModel = new SetDosenProdiModel();
        $this->referensiModel = new ReferensiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_dosen') ? $this->request->getVar('page_dosen') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $dosen = $this->dosenModel->getDosenSearch($keyword);
        } else {
            $dosen = $this->dosenModel->getDosen();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Data Dosen",
            'breadcrumb' => ['Data', 'Data Dosen'],
            'dosen' => $dosen->paginate($this->numberPage, 'dosen'),
            'kelamin' => $this->referensiModel->kelamin()->getResult(),
            'agama' => $this->referensiModel->agama()->getResult(),
            'golDarah' => $this->referensiModel->golDarah()->getResult(),
            'kecamatan' => $this->referensiModel->kecamatan()->getResult(),
            'jenjangPendidikan' => $this->referensiModel->jenjangPendidikan()->getResult(),
            'penghasilan' => $this->referensiModel->penghasilan()->getResult(),
            'statusDosen' => $this->referensiModel->statusDosen()->getResult(),
            'statusAktif' => $this->referensiModel->statusAktif()->getResult(),
            'statusNikah' => $this->referensiModel->statusNikah()->getResult(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->dosenModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Dosen\Views\dosen', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'dosenNama' => rv('required', ['required' => 'Nama lengkap dosen harus diisi!']),
            'dosenUsername' => rv('required', ['required' => 'Username akun harus diisi!']),
            'dosenPassword' => rv('required', ['required' => 'Password akun harus diisi!']),
            // 'dosenNip' => rv('required', ['required' => 'NIP dosen harus diisi!']),
            // 'dosenNIDN' => rv('required', ['required' => 'NIDN dosen harus diisi!']),
            // 'dosenNUPTK' => rv('required', ['required' => 'NUPTK dosen harus diisi!']),
            // 'dosenNoSerdos' => rv('required', ['required' => 'No. serdos harus diisi!']),
            // 'dosenStatusDosen' => rv('required', ['required' => 'Status dosen harus dipilih!']),
            'dosenStatusAktif' => rv('required', ['required' => 'Status aktif dipilih!']),
            'dosenGelarDepan' => rv('required', ['required' => 'Gelar depan dosen harus diisi!']),
            'dosenGelarBelakang' => rv('required', ['required' => 'Gelar Belakang dosen harus diisi!']),
            'dosenJenjangPendidikan' => rv('required', ['required' => 'Jenjang pendidikan dosen harus dipilih!']),
            'dosenTempatLahir' => rv('required', ['required' => 'Tempat lahir dosen harus diisi!']),
            'dosenTanggalLahir' => rv('required', ['required' => 'Tanggal lahir dosen harus diisi!']),
            'dosenJenisKelamin' => rv('required', ['required' => 'Jenis kelamin dosen harus dipilih!']),
            'dosenAgama' => rv('required', ['required' => 'Agama dosen harus dipilih!']),
            'dosenGolDarah' => rv('required', ['required' => 'Gol. darah dosen harus dipilih!']),
            'dosenKecamatan' => rv('required', ['required' => 'Kecamatan dosen harus dipilih!']),
            'dosenAlamat' => rv('required', ['required' => 'Alamat dosen harus diisi!']),
            'dosenStatusNikah' => rv('required', ['required' => 'Status nikah dosen harus dipilih!']),
            'dosenNIK' => rv('required', ['required' => 'NIK dosen harus diisi!']),
            // 'dosenNoNBM' => rv('required', ['required' => 'No. NBM dosen harus diisi!']),
            // 'dosenNoNPWP' => rv('required', ['required' => 'No. NPWP dosen harus diisi!']),
            'dosenEmailCorporate' => rv('required', ['required' => 'Email universitas dosen harus diisi!']),
            'dosenEmailGeneral' => rv('required', ['required' => 'Email pribadi dosen harus diisi!']),
            'dosenNoHandphone' => rv('required', ['required' => 'No. handphone dosen harus diisi!']),
            'dosenFoto' => rv('uploaded[dosenFoto]', ['uploaded' => 'Foto dosen harus dipilih!']),
            'dosenDokumenKTP' => rv('uploaded[dosenDokumenKTP]', ['uploaded' => 'KTP harus dipilih!']),
            // 'dosenDokumenIjazah' => rv('uploaded[dosenDokumenIjazah]', ['uploaded' => 'Ijazah harus dipilih!']),
            // 'dosenDokumenNBM' => rv('uploaded[dosenDokumenNBM]', ['uploaded' => 'Dokumen NBM harus dipilih!']),
            // 'dosenDokumenNPWP' => rv('uploaded[dosenDokumenNPWP]', ['uploaded' => 'Dokumen NPWP harus dipilih!']),
            // 'dosenDokumenSerdos' => rv('uploaded[dosenDokumenSerdos]', ['uploaded' => 'Dokumen serdos harus dipilih!']),
            // 'dosenSertifikatKeahlian' => rv('uploaded[dosenSertifikatKeahlian]', ['uploaded' => 'Sertifikat keahlian dosen harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $file = $this->request->getFile('dosenFoto');
        $file->move('Dokumen/fotoDosen');
        $fotoDosen = $file->getName();

        $file = $this->request->getFile('dosenDokumenKTP');
        $file->move('Dokumen/ktpDosen');
        $ktpDosen = $file->getName();

        $file = $this->request->getFile('dosenDokumenNBM');
        $file->move('Dokumen/nbmDosen');
        $nbmDosen = $file->getName();

        $file = $this->request->getFile('dosenDokumenNPWP');
        $file->move('Dokumen/npwpDosen');
        $npwpDosen = $file->getName();

        $file = $this->request->getFile('dosenDokumenSerdos');
        $file->move('Dokumen/serdosDosen');
        $serdosDosen = $file->getName();

        $file = $this->request->getFile('dosenDokumenIjazah');
        $file->move('Dokumen/ijazahDosen');
        $ijazahDosen = $file->getName();

        $ijazah = [];
        $dataSertifikat = ['ijazah' => $ijazahDosen];
        array_push($ijazah, $dataSertifikat);
        $namaIjazah = json_encode($ijazah);

        $file = $this->request->getFile('dosenSertifikatKeahlian');
        $file->move('Dokumen/sertifikatDosen');
        $sertifikatDosen = $file->getName();

        $sertifikat = [];
        $dataSertifikat = ['sertifikat' => $sertifikatDosen];
        array_push($sertifikat, $dataSertifikat);
        $namaSertifikat = json_encode($sertifikat);
        // dd($namaSertifikat);`

        $data = array(
            'dosenFoto' => $fotoDosen,
            'dosenDokumenKTP' => $ktpDosen,
            // 'dosenDokumenIjazah' => $namaIjazah,
            // 'dosenDokumenNBM' => $nbmDosen,
            // 'dosenDokumenNPWP' => $npwpDosen,
            // 'dosenDokumenSerdos' => $serdosDosen,
            // 'dosenSertifikatKeahlian' => $namaSertifikat,
            'dosenUsername' => $this->request->getVar('dosenUsername'),
            'dosenPassword' => $this->request->getVar('dosenPassword'),
            // 'dosenNip' => $this->request->getVar('dosenNip'),
            'dosenNama' => $this->request->getVar('dosenNama'),
            // 'dosenNIDN' => $this->request->getVar('dosenNIDN'),
            // 'dosenNUPTK' => $this->request->getVar('dosenNUPTK'),
            // 'dosenNoSerdos' => $this->request->getVar('dosenNoSerdos'),
            // 'dosenStatusDosen' => $this->request->getVar('dosenStatusDosen'),
            'dosenStatusAktif' => $this->request->getVar('dosenStatusAktif'),
            'dosenGelarDepan' => $this->request->getVar('dosenGelarDepan'),
            'dosenGelarBelakang' => $this->request->getVar('dosenGelarBelakang'),
            'dosenJenjangPendidikan' => $this->request->getVar('dosenJenjangPendidikan'),
            'dosenTempatLahir' => $this->request->getVar('dosenTempatLahir'),
            'dosenTanggalLahir' => $this->request->getVar('dosenTanggalLahir'),
            'dosenJenisKelamin' => $this->request->getVar('dosenJenisKelamin'),
            'dosenAgama' => $this->request->getVar('dosenAgama'),
            'dosenGolDarah' => $this->request->getVar('dosenGolDarah'),
            'dosenKecamatan' => $this->request->getVar('dosenKecamatan'),
            'dosenAlamat' => $this->request->getVar('dosenAlamat'),
            'dosenStatusNikah' => $this->request->getVar('dosenStatusNikah'),
            'dosenNIK' => $this->request->getVar('dosenNIK'),
            // 'dosenNoNBM' => $this->request->getVar('dosenNoNBM'),
            // 'dosenNoNPWP' => $this->request->getVar('dosenNoNPWP'),
            'dosenEmailCorporate' => $this->request->getVar('dosenEmailCorporate'),
            'dosenEmailGeneral' => $this->request->getVar('dosenEmailGeneral'),
            'dosenNoHandphone' => $this->request->getVar('dosenNoHandphone'),
            'dosenCreatedBy' => user()->email,
        );
        // dd($data);
        if ($this->dosenModel->insert($data)) {
            session()->setFlashdata('success', 'Data Dosen Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'dosenNama' => rv('required', ['required' => 'Nama lengkap dosen harus diisi!']),
            'dosenUsername' => rv('required', ['required' => 'Username akun harus diisi!']),
            'dosenPassword' => rv('required', ['required' => 'Password akun harus diisi!']),
            // 'dosenNip' => rv('required', ['required' => 'NIP dosen harus diisi!']),
            // 'dosenNIDN' => rv('required', ['required' => 'NIDN dosen harus diisi!']),
            // 'dosenNUPTK' => rv('required', ['required' => 'NUPTK dosen harus diisi!']),
            // 'dosenNoSerdos' => rv('required', ['required' => 'No. serdos harus diisi!']),
            // 'dosenStatusDosen' => rv('required', ['required' => 'Status dosen harus dipilih!']),
            'dosenStatusAktif' => rv('required', ['required' => 'Status aktif dipilih!']),
            'dosenGelarDepan' => rv('required', ['required' => 'Gelar depan dosen harus diisi!']),
            'dosenGelarBelakang' => rv('required', ['required' => 'Gelar Belakang dosen harus diisi!']),
            'dosenJenjangPendidikan' => rv('required', ['required' => 'Jenjang pendidikan dosen harus dipilih!']),
            'dosenTempatLahir' => rv('required', ['required' => 'Tempat lahir dosen harus diisi!']),
            'dosenTanggalLahir' => rv('required', ['required' => 'Tanggal lahir dosen harus diisi!']),
            'dosenJenisKelamin' => rv('required', ['required' => 'Jenis kelamin dosen harus dipilih!']),
            'dosenAgama' => rv('required', ['required' => 'Agama dosen harus dipilih!']),
            'dosenGolDarah' => rv('required', ['required' => 'Gol. darah dosen harus dipilih!']),
            'dosenKecamatan' => rv('required', ['required' => 'Kecamatan dosen harus dipilih!']),
            'dosenAlamat' => rv('required', ['required' => 'Alamat dosen harus diisi!']),
            'dosenStatusNikah' => rv('required', ['required' => 'Status nikah dosen harus dipilih!']),
            'dosenNIK' => rv('required', ['required' => 'NIK dosen harus diisi!']),
            // 'dosenNoNBM' => rv('required', ['required' => 'No. NBM dosen harus diisi!']),
            // 'dosenNoNPWP' => rv('required', ['required' => 'No. NPWP dosen harus diisi!']),
            'dosenEmailCorporate' => rv('required', ['required' => 'Email universitas dosen harus diisi!']),
            'dosenEmailGeneral' => rv('required', ['required' => 'Email pribadi dosen harus diisi!']),
            'dosenNoHandphone' => rv('required', ['required' => 'No. handphone dosen harus diisi!']),
            'dosenFoto' => rv('uploaded[dosenFoto]', ['uploaded' => 'Foto dosen harus dipilih!']),
            'dosenDokumenKTP' => rv('uploaded[dosenDokumenKTP]', ['uploaded' => 'KTP harus dipilih!']),
            // 'dosenDokumenIjazah' => rv('uploaded[dosenDokumenIjazah]', ['uploaded' => 'Ijazah harus dipilih!']),
            // 'dosenDokumenNBM' => rv('uploaded[dosenDokumenNBM]', ['uploaded' => 'Dokumen NBM harus dipilih!']),
            // 'dosenDokumenNPWP' => rv('uploaded[dosenDokumenNPWP]', ['uploaded' => 'Dokumen NPWP harus dipilih!']),
            // 'dosenDokumenSerdos' => rv('uploaded[dosenDokumenSerdos]', ['uploaded' => 'Dokumen serdos harus dipilih!']),
            // 'dosenSertifikatKeahlian' => rv('uploaded[dosenSertifikatKeahlian]', ['uploaded' => 'Sertifikat keahlian dosen harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $file = $this->request->getFile('dosenFoto');
        if ($file->getError() == 4) {
            $fotoDosen = $this->request->getVar('dosenFotoLama');
        } else {
            $file->move('Dokumen/fotoDosen');
            $fotoDosen = $file->getName();
            unlink('Dokumen/fotoDosen/' . $this->request->getVar('dosenFotoLama'));
        }

        $file = $this->request->getFile('dosenDokumenKTP');
        if ($file->getError() == 4) {
            $ktpDosen = $this->request->getVar('dosenDokumenKTPLama');
        } else {
            $file->move('Dokumen/ktpDosen');
            $ktpDosen = $file->getName();
            unlink('Dokumen/ktpDosen/' . $this->request->getVar('dosenDokumenKTPLama'));
        }

        $file = $this->request->getFile('dosenDokumenNBM');
        if ($file->getError() == 4) {
            $nbmDosen = $this->request->getVar('dosenDokumenNBMLama');
        } else {
            $file->move('Dokumen/nbmDosen');
            $nbmDosen = $file->getName();
            unlink('Dokumen/nbmDosen/' . $this->request->getVar('dosenDokumenNBMLama'));
        }

        $file = $this->request->getFile('dosenDokumenNPWP');
        if ($file->getError() == 4) {
            $npwpDosen = $this->request->getVar('dosenDokumenNPWPLama');
        } else {
            $file->move('Dokumen/npwpDosen');
            $npwpDosen = $file->getName();
            unlink('Dokumen/npwpDosen/' . $this->request->getVar('dosenDokumenNPWPLama'));
        }

        $file = $this->request->getFile('dosenDokumenSerdos');
        if ($file->getError() == 4) {
            $serdosDosen = $this->request->getVar('dosenDokumenSerdosLama');
        } else {
            $file->move('Dokumen/serdosDosen');
            $serdosDosen = $file->getName();
            unlink('Dokumen/serdosDosen/' . $this->request->getVar('dosenDokumenSerdosLama'));
        }

        // json sampai sini

        // $file = $this->request->getFile('dosenDokumenIjazah');
        // $file->move('Dokumen/ijazahDosen');
        // $ijazahDosen = $file->getName();

        // $ijazah = [];
        // $dataSertifikat = ['ijazah' => $ijazahDosen];
        // array_push($ijazah, $dataSertifikat);
        // $namaIjazah = json_encode($ijazah);

        // $file = $this->request->getFile('dosenSertifikatKeahlian');
        // $file->move('Dokumen/sertifikatDosen');
        // $sertifikatDosen = $file->getName();

        // $sertifikat = [];
        // $dataSertifikat = ['sertifikat' => $sertifikatDosen];
        // array_push($sertifikat, $dataSertifikat);
        // $namaSertifikat = json_encode($sertifikat);
        // dd($namaSertifikat);`

        $data = array(
            'dosenFoto' => $fotoDosen,
            'dosenDokumenKTP' => $ktpDosen,
            // 'dosenDokumenIjazah' => $namaIjazah,
            // 'dosenDokumenNBM' => $nbmDosen,
            // 'dosenDokumenNPWP' => $npwpDosen,
            // 'dosenDokumenSerdos' => $serdosDosen,
            // 'dosenSertifikatKeahlian' => $namaSertifikat,
            'dosenUsername' => $this->request->getVar('dosenUsername'),
            'dosenPassword' => $this->request->getVar('dosenPassword'),
            // 'dosenNip' => $this->request->getVar('dosenNip'),
            'dosenNama' => $this->request->getVar('dosenNama'),
            // 'dosenNIDN' => $this->request->getVar('dosenNIDN'),
            // 'dosenNUPTK' => $this->request->getVar('dosenNUPTK'),
            // 'dosenNoSerdos' => $this->request->getVar('dosenNoSerdos'),
            // 'dosenStatusDosen' => $this->request->getVar('dosenStatusDosen'),
            'dosenStatusAktif' => $this->request->getVar('dosenStatusAktif'),
            'dosenGelarDepan' => $this->request->getVar('dosenGelarDepan'),
            'dosenGelarBelakang' => $this->request->getVar('dosenGelarBelakang'),
            'dosenJenjangPendidikan' => $this->request->getVar('dosenJenjangPendidikan'),
            'dosenTempatLahir' => $this->request->getVar('dosenTempatLahir'),
            'dosenTanggalLahir' => $this->request->getVar('dosenTanggalLahir'),
            'dosenJenisKelamin' => $this->request->getVar('dosenJenisKelamin'),
            'dosenAgama' => $this->request->getVar('dosenAgama'),
            'dosenGolDarah' => $this->request->getVar('dosenGolDarah'),
            'dosenKecamatan' => $this->request->getVar('dosenKecamatan'),
            'dosenAlamat' => $this->request->getVar('dosenAlamat'),
            'dosenStatusNikah' => $this->request->getVar('dosenStatusNikah'),
            'dosenNIK' => $this->request->getVar('dosenNIK'),
            // 'dosenNoNBM' => $this->request->getVar('dosenNoNBM'),
            // 'dosenNoNPWP' => $this->request->getVar('dosenNoNPWP'),
            'dosenEmailCorporate' => $this->request->getVar('dosenEmailCorporate'),
            'dosenEmailGeneral' => $this->request->getVar('dosenEmailGeneral'),
            'dosenNoHandphone' => $this->request->getVar('dosenNoHandphone'),
            'dosenModifiedBy' => user()->email,
        );

        if ($this->dosenModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Dosen Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->dosenModel->delete($id)) {
            session()->setFlashdata('success', 'Data Dosen Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }

    public function search()
    {
        $cariDosen = $this->request->getVar('cariDosen');
        if ($cariDosen == null) {
            $dataDosen = null;
        } else {
            $prodi = [];
            $prodiId = explode(',', $this->request->getVar('prodiId'));
            foreach ($prodiId as $key => $dt) {
                $prodi[] = $dt;
            }
            $dosenExist = [];
            $limit = $this->numberPage;
            $data = $this->setDosenProdiModel->getWhereIn($prodi)->findAll();
            foreach ($data as $dt) {
                $dosenExist[] = $dt->setDosenProdiDosenId;
            }
            $where = [$cariDosen, $dosenExist, $limit];
            $dataDosen = $this->dosenModel->searchDosen($where)->get()->getResult();
        }
        echo json_encode($dataDosen);
    }


    public function searchPimpinan()
    {
        $cariDosen = $this->request->getVar('cariDosen');
        if ($cariDosen == null) {
            $dataDosen = null;
        } else {
            $limit = $this->numberPage;
            $where = [$cariDosen, [], $limit];
            $dataDosen = $this->dosenModel->searchDosen($where)->get()->getResult();
        }
        echo json_encode($dataDosen);
    }
}
