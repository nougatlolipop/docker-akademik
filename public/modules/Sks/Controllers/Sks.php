<?php

/* 
This is Controller Sks
 */

namespace Modules\Sks\Controllers;

use App\Controllers\BaseController;
use Modules\Sks\Models\SksModel;


class Sks extends BaseController
{
    protected $sksModel;
    protected $validation;

    public function __construct()
    {
        $this->sksModel = new SksModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_sks') ? $this->request->getVar('page_sks') : 1;
        $keyword = $this->request->getVar('keyword');
        $sks = $this->sksModel->getSks($keyword);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "SKS Disetujui",
            'breadcrumb' => ['Data', 'Aturan', 'SKS Disetujui'],
            'sks' => $sks->paginate($this->numberPage, 'sks'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->sksModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Sks\Views\sks', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'sksAllowNama' => rv('required', ['required' => 'Nama aturan harus diisi!']),
            'minIpk' => rv('required', ['required' => 'IPK Minimal harus diisi!']),
            'maxIpk' => rv('required', ['required' => 'IPK Maksimal harus diisi!']),
            'allow' => rv('required', ['required' => 'SKS Maksimal harus diisi!']),
            'sksDefault' => rv('required', ['required' => 'SKS default harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $jml = count($this->request->getVar('minIpk'));
        $minIpk = $this->request->getVar('minIpk');
        $maxIpk = $this->request->getVar('maxIpk');
        $allow = $this->request->getVar('allow');
        $akselerasi = $this->request->getVar('minIpkAkselerasi');
        $data = [];
        $detail = [];
        for ($i = 0; $i < $jml; $i++) {
            $dataSks = [
                'minIpk' => $minIpk[$i],
                'maxIpk' => $maxIpk[$i],
                'allow' => $allow[$i],
            ];
            array_push($detail, $dataSks);
        }

        $dataAkse = [
            'minIpkAkselerasi' => $akselerasi,
            'detail' => $detail,
        ];

        $result = json_encode(['data' => [$dataAkse]]);

        $data = array(
            'sksAllowNama' => $this->request->getVar('sksAllowNama'),
            'sksAllowJson' => $result,
            'sksDefault' => $this->request->getVar('sksDefault'),
            'sksCreatedBy' => user()->email,
        );
        if ($this->sksModel->insert($data)) {
            session()->setFlashdata('success', 'Data Sks Berhasil Ditambahkan!');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'sksAllowNama' => rv('required', ['required' => 'Nama aturan harus diisi!']),
            'minIpk' => rv('required', ['required' => 'IPK Minimal harus diisi!']),
            'maxIpk' => rv('required', ['required' => 'IPK Maksimal harus diisi!']),
            'allow' => rv('required', ['required' => 'SKS Maksimal harus diisi!']),
            'sksDefault' => rv('required', ['required' => 'SKS default harus diisi!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $jml = count($this->request->getVar('minIpk'));
        $minIpk = $this->request->getVar('minIpk');
        $maxIpk = $this->request->getVar('maxIpk');
        $allow = $this->request->getVar('allow');
        $akselerasi = $this->request->getVar('minIpkAkselerasi');
        $data = [];
        $detail = [];
        for ($i = 0; $i < $jml; $i++) {
            $dataSks = [
                'minIpk' => $minIpk[$i],
                'maxIpk' => $maxIpk[$i],
                'allow' => $allow[$i],
            ];
            array_push($detail, $dataSks);
        }

        $dataAkse = [
            'minIpkAkselerasi' => $akselerasi,
            'detail' => $detail,
        ];

        $result = json_encode(['data' => [$dataAkse]]);

        $data = array(
            'sksAllowNama' => $this->request->getVar('sksAllowNama'),
            'sksAllowJson' => $result,
            'sksDefault' => $this->request->getVar('sksDefault'),
            'sksModifiedBy' => user()->email,
        );

        if ($this->sksModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data Sks Berhasil Diubah!');
            return redirect()->to($url);
        }
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->sksModel->delete($id)) {
            session()->setFlashdata('success', 'Data Sks Berhasil Dihapus!');
        };
        return redirect()->to($url);
    }
}
