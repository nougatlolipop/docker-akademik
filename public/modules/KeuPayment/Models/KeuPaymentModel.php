<?php

namespace Modules\KeuPayment\Models;

use CodeIgniter\Model;

class KeuPaymentModel extends Model
{
    protected $table = 'keu_payment';
    protected $primaryKey = 'paymentId';
    protected $allowedFields = ['paymentDetail', 'paymentBankId', 'paymentChannelKode', 'paymentTerminalKode', 'paymentTanggalBayar', 'paymentKeteranganBayar', 'paymentIsPaid', 'paymentCreatedBy', 'paymentCreatedDate', 'paymentModifiedBy', 'paymentModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'paymentCreatedDate';
    protected $updatedField = 'paymentModifiedDate';
}
