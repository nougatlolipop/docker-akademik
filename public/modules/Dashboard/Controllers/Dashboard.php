<?php

/* 
This is Controller Krs
 */

namespace Modules\Dashboard\Controllers;

use App\Controllers\BaseController;


class Dashboard extends BaseController
{
    public function index()
    {
        // dd(requestToken());
        // dd(akses_maja(getMajaInfo()[0]->billing_host . '/api/v2/cancel', json_encode([
        //     'va' => '90182205160032',
        //     'invoiceNumber' => 'umsu_2205160032',
        //     'amount' => 7350000
        // ])));
        if ($this->usr->name != 'Mahasiswa') {
            $data = [
                'menu' => $this->fetchMenu(),
                'title' => "Dashboard",
                'breadcrumb' => ['Home', 'Dashboard'],
            ];
            return view('Modules\Dashboard\Views\dashboard', $data);
        } else {
            return redirect()->to('/mahasiswa');
        }
    }

    public function regen()
    {
        return redirect()->to('/');
    }
}
