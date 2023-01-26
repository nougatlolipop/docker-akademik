<?php

namespace Modules\KeuTunggakanDetail\Models;

use CodeIgniter\Model;

class KeuTunggakanDetailModel extends Model
{
    public function getTagihan($where)
    {
        $builder = $this->db->table("function_tagihan_all_angkatan('" . $where[0] . "','" . $where[1] . "','" . $where[2] . "','" . $where[3] . "')");
        return $builder->get();
    }
}
