<?php

/* 
This is Controller Krs
 */

namespace Modules\SyncMhs\Controllers;

use App\Controllers\BaseController;
use Modules\Mahasiswa\Models\MahasiswaModel;
use Myth\Auth\Entities\User;

class SyncMhs extends BaseController
{
    protected $mahasiswaModel;
    protected $config;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->config = config('Auth');
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Sync Akun Mahasiswa",
            'breadcrumb' => ['User', 'Sync Akun Mahasiswa'],
        ];
        return view('Modules\SyncMhs\Views\syncMhs', $data);
    }

    public function syncAccount()
    {
        $berhasil = 0;
        $gagal = 0;
        $mahasiswa = $this->mahasiswaModel->getMahasiswaAccountExists()->getResult();
        $mahasiswa = array_chunk($mahasiswa, 100);
        foreach ($mahasiswa as $key => $data) {
            foreach ($mahasiswa[$key] as $idx => $value) {
                // Start Save the user
                $users = model(UserModel::class);
                $dataUser = [
                    'password' => trim($value->mahasiswaNpm),
                    'email' => trim($value->mahasiswaNpm . '@umsu.ac.id'),
                    'username' => trim($value->mahasiswaNpm)
                ];
                $user = new User($dataUser);
                $user->activate();
                $users = $users->withGroup('Mahasiswa');

                if (!$users->save($user)) {
                    $gagal++;
                } else {
                    $berhasil++;
                }
            }
            sleep(5);
            flush();
        }
        echo json_encode([
            'status' => true,
            'message' => $mahasiswa
        ]);
    }

}
