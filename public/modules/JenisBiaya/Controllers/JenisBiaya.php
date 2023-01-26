<?php

/* 
This is Controller Krs
 */

namespace Modules\JenisBiaya\Controllers;

use App\Controllers\BaseController;


class JenisBiaya extends BaseController
{
    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "JenisBiaya",
            'breadcrumb' => ['Home', 'JenisBiaya'],
        ];
        return view('Modules\JenisBiaya\Views\jenisBiya', $data);
        // echo 'Siapa nama kamu?';
    }
}
