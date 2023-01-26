<?php

/* 
This is Controller Prodi
 */

namespace Modules\Prodi\Controllers;

use App\Controllers\BaseController;
use Modules\Prodi\Models\ProdiModel;
use Modules\Fakultas\Models\FakultasModel;
use App\Models\ReferensiModel;

class Prodi extends BaseController
{
    protected $prodiModel;
    protected $fakultasModel;
    protected $referensiModel;
    protected $validation;
    public function __construct()
    {
        $this->prodiModel = new ProdiModel();
        $this->fakultasModel = new FakultasModel();
        $this->referensiModel = new ReferensiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_prodi') ? $this->request->getVar('page_prodi') : 1;
        $keyword = $this->request->getVar('keyword');
        if (in_groups('Fakultas')) {
            $fakultas = ['dt_fakultas."fakultasId"' => getUserDetail()[0]->fakultasId];
        } else {
            $fakultas = null;
        }
        $prodi = $this->prodiModel->getProdi($fakultas, $keyword);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Prodi",
            'breadcrumb' => ['Data', 'Prodi'],
            'prodi' => $prodi->paginate($this->numberPage, 'prodi'),
            'fakultas' => $this->fakultasModel->getFakultas()->findAll(),
            'gedung' => $this->referensiModel->getGedung()->getResult(),
            'jenjang' => $this->referensiModel->jenjangPendidikan()->getResult(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->prodiModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Prodi\Views\prodi', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'prodiKode' => rv('required', ['required' => 'Kode prodi harus diisi!']),
            'prodiNama' => rv('required', ['required' => 'Nama prodi harus diisi!']),
            'prodiAcronym' => rv('required', ['required' => 'Akronim prodi harus diisi!']),
            'prodiFakultasId' => rv('required', ['required' => 'Fakultas prodi harus dipilih!']),
            'prodiGedungId' => rv('required', ['required' => 'Gedung prodi harus dipilih!']),
            'prodiGelarLulus' => rv('required', ['required' => 'Gelar lulusan prodi harus diisi!']),
            'prodiJenjang' => rv('required', ['required' => 'Jenjang harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'prodiKode' => $this->request->getVar('prodiKode'),
            'prodiNama' => $this->request->getVar('prodiNama'),
            'prodiAcronym' => $this->request->getVar('prodiAcronym'),
            'prodiFakultasId' => getUserDetail()[0]->fakultasId,
            'prodiGedungId' => $this->request->getVar('prodiGedungId'),
            'prodiWebsite' => $this->request->getVar('prodiWebsite'),
            'prodiEmail' => $this->request->getVar('prodiEmail'),
            'prodiNoTelp' => $this->request->getVar('prodiNoTelp'),
            'prodiNomorSKDikti' => $this->request->getVar('prodiNomorSKDikti'),
            'prodiStartDateSKDikti' => $this->request->getVar('prodiStartDateSKDikti'),
            'prodiEndDateSKDikti' => $this->request->getVar('prodiEndDateSKDikti'),
            'prodiGelarLulus' => $this->request->getVar('prodiGelarLulus'),
            'prodiIsAktif' => $this->request->getVar('prodiIsAktif') == null ? '0' : '1',
            'prodiJenjangId' => $this->request->getVar('prodiJenjangId'),
            'prodiCreatedBy' => user()->email,
        );
        if ($this->prodiModel->insert($data)) {
            session()->setFlashdata('success', 'Data Prodi Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'prodiKode' => rv('required', ['required' => 'Kode prodi harus diisi!']),
            'prodiNama' => rv('required', ['required' => 'Nama prodi harus diisi!']),
            'prodiAcronym' => rv('required', ['required' => 'Akronim prodi harus diisi!']),
            'prodiFakultasId' => rv('required', ['required' => 'Fakultas prodi harus dipilih!']),
            'prodiGedungId' => rv('required', ['required' => 'Gedung prodi harus dipilih!']),
            'prodiGelarLulus' => rv('required', ['required' => 'Gelar lulusan prodi harus diisi!']),
            'prodiJenjang' => rv('required', ['required' => 'Jenjang harus dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'prodiKode' => $this->request->getVar('prodiKode'),
            'prodiNama' => $this->request->getVar('prodiNama'),
            'prodiAcronym' => $this->request->getVar('prodiAcronym'),
            'prodiFakultasId' => getUserDetail()[0]->fakultasId,
            'prodiGedungId' => $this->request->getVar('prodiGedungId'),
            'prodiWebsite' => $this->request->getVar('prodiWebsite'),
            'prodiEmail' => $this->request->getVar('prodiEmail'),
            'prodiNoTelp' => $this->request->getVar('prodiNoTelp'),
            'prodiNomorSKDikti' => $this->request->getVar('prodiNomorSKDikti'),
            'prodiStartDateSKDikti' => $this->request->getVar('prodiStartDateSKDikti'),
            'prodiEndDateSKDikti' => $this->request->getVar('prodiEndDateSKDikti'),
            'prodiGelarLulus' => $this->request->getVar('prodiGelarLulus'),
            'prodiIsAktif' => $this->request->getVar('prodiIsAktif') == null ? '0' : '1',
            'prodiJenjangId' => $this->request->getVar('prodiJenjangId'),
            'prodiModifiedBy' => user()->email,
        );
        if ($this->prodiModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Prodi Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->prodiModel->delete($id)) {
            session()->setFlashdata('success', 'Data Prodi Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }

    public function updateDosen($id)
    {
        $email = $this->request->getVar('email');
        $dosenId = $this->request->getVar('dosenId');
        $jabatan = $this->request->getVar('jabatan');

        if ($jabatan == 'ketua') {
            $data = [
                'prodiKaprodi' =>  $dosenId,
                'prodiModifiedBy' => $email
            ];
        } else {
            $data = [
                'prodiSekretaris' =>  $dosenId,
                'prodiModifiedBy' => $email
            ];
        }

        if ($this->prodiModel->update($id, $data)) {
            $response = 1;
        } else {
            $response = 0;
        }
        echo json_encode($response);
    }
}
