<?php

/* 
This is Controller Krs
 */

namespace Modules\Error\Controllers;

use App\Controllers\BaseController;


class Error extends BaseController
{
    public function index()
    {

        $data = [
            'title' => "Error",
            'breadcrumb' => ['Home', 'Error'],
            'menu' => $this->fetchMenu()
        ];
        return view('Modules\Error\Views\error', $data);
    }
}
