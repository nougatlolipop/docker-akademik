<?php

/* 
This is Controller UserRole
 */

namespace Modules\UserRole\Controllers;

use App\Controllers\BaseController;
use Modules\ManajemenAkun\Models\ManajemenAkunModel;
use Modules\UserRole\Models\UserRoleModel;
use Modules\Fakultas\Models\FakultasModel;
use App\Models\ReferensiModel;


class UserRole extends BaseController
{
    protected $manajemenAkunModel;
    protected $userRoleModel;
    protected $fakultasModel;
    protected $referensiModel;
    protected $validation;

    public function __construct()
    {
        $this->manajemenAkunModel = new ManajemenAkunModel();
        $this->userRoleModel = new UserRoleModel();
        $this->fakultasModel = new FakultasModel();
        $this->referensiModel = new ReferensiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_userRole') ? $this->request->getVar('page_userRole') : 1;
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $manajemenAkun = $this->manajemenAkunModel->getManajemenAkunSearch($keyword);
        } else {
            $manajemenAkun = $this->manajemenAkunModel->getManajemenAkun();
        }
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Role Pengguna",
            'breadcrumb' => ['User', 'Role Pengguna'],
            'manajemenAkun' => $manajemenAkun->paginate($this->numberPage, 'userRole'),
            'fakultas' =>  $this->fakultasModel->getFakultas()->findAll(),
            'tingkat' =>  $this->referensiModel->getTingkat()->getResult(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->manajemenAkunModel->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\UserRole\Views\userRole', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'roleApp' => rv('required', ['required' => 'Aplikasi harus dipilih!']),
            'roleTingkatId' => rv('required', ['required' => 'Tingkatan harus dipilih!']),
            'roleFakultasId' => rv('required', ['required' => 'Fakultas Harus Dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('/userRole')->withInput();
        };

        $data = array(
            'roleEmail' => trim($this->request->getVar('roleEmail')),
            'roleApp' => trim($this->request->getVar('roleApp')),
            'roleTingkatId' => trim($this->request->getVar('roleTingkatId')),
            'roleFakultasId' => trim($this->request->getVar('roleFakultasId')),
            'roleCreatedBy' => user()->email,
        );

        if ($this->userRoleModel->insert($data)) {
            session()->setFlashdata('success', 'Role Pengguna Berhasil Disetting !');
            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'roleApp' => rv('required', ['required' => 'Aplikasi harus dipilih!']),
            'roleTingkatId' => rv('required', ['required' => 'Tingkatan harus dipilih!']),
            'roleFakultasId' => rv('required', ['required' => 'Fakultas Harus Dipilih!']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('/userRole')->withInput();
        };

        $data = array(
            'roleEmail' => trim($this->request->getVar('roleEmail')),
            'roleApp' => trim($this->request->getVar('roleApp')),
            'roleTingkatId' => trim($this->request->getVar('roleTingkatId')),
            'roleFakultasId' => trim($this->request->getVar('roleFakultasId')),
            'roleModifiedBy' => user()->email,
        );

        if ($this->userRoleModel->update($id, $data)) {
            session()->setFlashdata('success', 'Role Pengguna Berhasil Diupdate !');
            return redirect()->to($url);
        }
    }
}
