<?php

namespace Modules\KeuBayarDetail\Models;

use CodeIgniter\Model;

class KeuBayarDetailModel extends Model
{
    public function getBayarDetail($where)
    {
        $builder = $this->db->table("function_tampil_payment_all()");
        $builder->where($where);
        return $builder->get();
    }
}
