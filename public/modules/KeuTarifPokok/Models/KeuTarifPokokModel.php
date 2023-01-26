<?php

namespace Modules\KeuTarifPokok\Models;

use CodeIgniter\Model;

class KeuTarifPokokModel extends Model
{
    protected $table = 'keu_tarif';
    protected $primaryKey = 'tarifId';
    protected $allowedFields = ['tarifProdiId', 'tarifProgramKuliahId',  'tarifAngkatan', 'tarifKodeBayar', 'tarifDetail', 'tarifCreatedBy', 'tarifCreatedDate', 'tarifModifiedBy', 'tarifModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'tarifCreatedDate';
    protected $updatedField = 'tarifModifiedDate';

    public function getKeuTarifPokok($where)
    {
        $builder = $this->db->table("function_tampil_tarif_detail('" . $where[0] . "','" . $where[1] . "','" . $where[2] . "')");
        return $builder->get();
    }

    public function callHitungTagihan($init)
    {
        $builder = $this->db->query("CALL prosedur_hitung_tagihan_all(" . $init[0] . "," . $init[1] . ",'" . $init[2] . "','" . $init[3] . "')");
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }
}
