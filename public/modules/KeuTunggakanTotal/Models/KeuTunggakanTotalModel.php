<?php

namespace Modules\KeuTunggakanTotal\Models;

use CodeIgniter\Model;

class KeuTunggakanTotalModel extends Model
{
    public function getTagihanTotal($where)
    {
        $builder = $this->db->table("function_laporan_total_tunggakan('" . $where[0] . "','" . $where[1] . "')");
        return $builder->get();
    }
}
