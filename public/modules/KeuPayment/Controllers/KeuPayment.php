<?php

/* 
This is Controller Krs
 */

namespace Modules\KeuPayment\Controllers;

use App\Controllers\BaseController;
use Modules\KeuPayment\Models\KeuPaymentModel;

class KeuPayment extends BaseController
{

    protected $keuPaymentModel;
    protected $validation;

    public function __construct()
    {
        $this->keuPaymentModel = new KeuPaymentModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "KeuPayment",
            'breadcrumb' => ['Home', 'KeuPayment'],
        ];
        return view('Modules\KeuPayment\Views\keuPayment', $data);
    }
}
