<?php

namespace Modules\KeuBayarTotal\Models;

use CodeIgniter\Model;

class KeuBayarTotalModel extends Model
{
    public function getBayarTotal($where)
    {
        $builder = $this->db->table("function_laporan_total_pembayaran('" . $where[0] . "','" . $where[1] . "','" . $where[2] . "')");
        return $builder->get();
    }
}
