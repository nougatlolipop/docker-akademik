<?php

/* 
This is Controller SetDosenProdi
 */

namespace Modules\SetDosenProdi\Controllers;

use App\Controllers\BaseController;
use Modules\SetDosenProdi\Models\SetDosenProdiModel;
use Modules\Prodi\Models\ProdiModel;
use App\Models\ReferensiModel;
use Modules\Dosen\Models\DosenModel;
use Modules\Fakultas\Models\FakultasModel;
use Modules\SetProdiProgKuliah\Models\SetProdiProgKuliahModel;

class SetDosenProdi extends BaseController
{
    protected $setDosenProdiModel;
    protected $referensiModel;
    protected $prodiModel;
    protected $fakultasModel;
    protected $dosen;
    protected $setProdiProgKuliahModel;
    protected $validation;

    public function __construct()
    {
        $this->setDosenProdiModel = new SetDosenProdiModel();
        $this->referensiModel = new ReferensiModel();
        $this->prodiModel = new ProdiModel();
        $this->fakultasModel = new FakultasModel();
        $this->dosen = new DosenModel();
        $this->setProdiProgKuliahModel = new SetProdiProgKuliahModel();
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

        $currentPage = $this->request->getVar('page_setDosenProdi') ? $this->request->getVar('page_setDosenProdi') : 1;
        $setDosenProdi = $this->setDosenProdiModel->getDosenProdi($sourceData, $fakultas);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Dosen Prodi",
            'breadcrumb' => ['Setting', 'Dosen Prodi'],
            'dosen' => $setDosenProdi->paginate($this->numberPage, 'setDosenProdi'),
            'dataDosen' => $this->dosen->getDosen()->findAll(),
            'prodi' => $this->prodiModel->getProdi()->findAll(),
            'prodiBiro' => getUserDetail(),
            'fakultas' => $this->fakultasModel->getFakultasForKrs()->findAll(),
            'filter' => $filter,
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->setDosenProdiModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\SetDosenProdi\Views\setDosenProdi', $data);
    }

    public function add()
    {
        $prodi = explode(",", $this->request->getVar('prodiId'));
        $dosen = $this->request->getVar('dosenId');
        $email = $this->request->getVar('email');

        foreach ($prodi as $dataPrd) {
            foreach ($dosen as $dataDsn) {
                $data = [
                    'setDosenProdiDosenId' => $dataDsn,
                    'setDosenProdiProdiId' => $dataPrd,
                    'setDosenProdiCreatedBy' => $email,
                ];
            }
        }
        if ($this->setDosenProdiModel->insert($data)) {
            $response = 1;
        } else {
            $response = 0;
        }
        echo json_encode($response);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->setDosenProdiModel->delete($id)) {
            session()->setFlashdata('success', 'Data Dosen Prodi Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }

    public function search()
    {
        $cariDosen = $this->request->getVar('cariDosen');
        if ($cariDosen == null) {
            $dataDosen = null;
        } else {
            $dosenOld = [];
            $dosenId = ($this->request->getVar('dosenId') == null) ? [] : json_decode($this->request->getVar('dosenId'))->data;
            if ($this->request->getVar('dosenId') != null) {
                foreach ($dosenId as $key => $dsn) {
                    $dosenOld[] = $dsn->id;
                }
            }
            $prodiId = $this->request->getVar('prodiId');
            $limit = $this->numberPage;
            $where = [$cariDosen, $dosenOld, $prodiId, $limit];
            $dataDosen = $this->setDosenProdiModel->search($where)->get()->getResult();
        }
        echo json_encode($dataDosen);
    }

    public function searchDosenPa()
    {
        $cariDosen = $this->request->getVar('cariDosen');
        if ($cariDosen == null) {
            $dataDosen = null;
        } else {
            $prodiId = $this->setProdiProgKuliahModel->getWhere(['setProdiProgramKuliahId' => $this->request->getVar('prodiProgramId')])->getResult()[0]->setProdiProgramKuliahProdiId;
            $limit = $this->numberPage;
            $dosenOld = [$this->request->getVar('dosenOld')];
            $where = [$cariDosen, $dosenOld, $prodiId, $limit];
            $dataDosen = $this->setDosenProdiModel->search($where)->get()->getResult();
        }
        echo json_encode($dataDosen);
    }
}
