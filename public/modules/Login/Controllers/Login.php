<?php

/* 
This is Controller Krs
 */

namespace Modules\Dashboard\Controllers;

use App\Controllers\BaseController;


class Dashboard extends BaseController
{
    public function index($nama = null)
    {
        $data = [
            // 'menu' => $this->fetchMenu()
            'title' => "Dashboard",
            'appName' => "UMSU Academy",
            'breadcrumb' => ['Home', 'Dashboard'],
        ];
        return view('Modules\Dashboard\Views\dashboard', $data);
        // echo 'Siapa nama kamu?';
    }
}
