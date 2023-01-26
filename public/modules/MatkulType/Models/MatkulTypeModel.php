<?php

namespace Modules\MatkulType\Models;

use CodeIgniter\Model;

class MatkulTypeModel extends Model
{
    protected $table = 'dt_matkul_type';
    protected $primaryKey = 'matkulTypeId';
    protected $allowedFields = ['matkulTypeKode', 'matkulTypeNama', 'matkulTypeShortName', 'matkulTypeCreatedBy', 'matkulTypeCreatedDate', 'matkulTypeModifiedBy', 'matkulTypeModifiedDate', 'matkulTypeDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $dateFormat    = 'date';
    protected $createdField = 'matkulTypeCreatedDate';
    protected $updatedField = 'matkulTypeModifiedDate';
    protected $deletedField = 'matkulTypeDeletedAt';

    public function getMatkulType()
    {
        $builder = $this->table('dt_matkul_type');
        return $builder;
    }

    public function getMatkulTypeSearch($keyword = null)
    {
        $builder = $this->table('dt_matkul_type');
        $builder->like('LOWER(dt_matkul_type."matkulTypeNama")', strtolower($keyword));
        return $builder;
    }
}
