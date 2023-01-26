<?php

namespace Modules\JenisBiaya\Models;

use CodeIgniter\Model;

class JenisBiayaModel extends Model
{
    protected $table = 'ref_jenis_biaya';
    protected $primaryKey = 'refJenisBiayaId';
    protected $allowedFields = ['refJenisBiayaKode', 'refJenisBiayaNama', 'refJenisBiayaTagihanTypeId'];
    protected $returnType = 'object';

    public function jenisTagihan($type)
    {
        $builder = $this->table('ref_jenis_biaya');
        $builder->join('ref_type_tagihan', 'ref_type_tagihan."refTagihanTypeId" = ref_jenis_biaya."refJenisBiayaTagihanTypeId"', 'Left');
        if ($type == 'pokok') {
            $builder->where(['ref_jenis_biaya."refJenisBiayaTagihanTypeId"' => 1]);
        } else {
            $builder->where(['ref_jenis_biaya."refJenisBiayaTagihanTypeId"' => 2]);
        }
        $builder->orderBy('ref_jenis_biaya."refJenisBiayaId"', 'DESC');
        return $builder;
    }

    public function getJenisBiaya($where)
    {
        $builder = $this->table('ref_jenis_biaya');
        $builder->where($where);
        return $builder;
    }
}
