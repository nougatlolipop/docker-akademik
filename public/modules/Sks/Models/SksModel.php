<?php

namespace Modules\Sks\Models;

use CodeIgniter\Model;

class SksModel extends Model
{
    protected $table = 'dt_sks_allow';
    protected $primaryKey = 'sksAllowId';
    protected $allowedFields = ['sksAllowNama', 'sksAllowJson', 'sksDefault', 'sksCreatedBy', 'sksModifiedBy', 'sksModifiedDate', 'sksCreatedDate', 'sksDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'sksCreatedDate';
    protected $updatedField = 'sksModifiedDate';
    protected $deletedField = 'sksDeletedAt';

    public function getSks($keyword = null)
    {
        $builder = $this->table('dt_sks_allow');
        if ($keyword) {
            $builder->like('LOWER(dt_sks_allow."sksAllowNama")', strtolower($keyword))->where('dt_sks_allow.sksDeletedAt', null);
            $builder->orlike('LOWER(dt_sks_allow."sksDefault")', strtolower($keyword))->where('dt_sks_allow.sksDeletedAt', null);
        } else {
            $builder->where('dt_sks_allow.sksDeletedAt', null);
        }
        $builder->orderBy('dt_sks_allow.sksAllowId', 'DESC');
        return $builder;
    }
}
