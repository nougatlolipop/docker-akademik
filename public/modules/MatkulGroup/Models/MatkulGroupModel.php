<?php

namespace Modules\MatkulGroup\Models;

use CodeIgniter\Model;

class MatkulGroupModel extends Model
{
    protected $table = 'dt_matkul_group';
    protected $primaryKey = 'matkulGroupId';
    protected $allowedFields = ['matkulGroupKode', 'matkulGroupNama', 'matkulGroupDeskripsi', 'matkulGroupCreatedBy', 'matkulGroupCreatedDate', 'matkulGroupModifiedBy', 'matkulGroupModifiedDate', 'matkulGroupDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'matkulGroupCreatedDate';
    protected $updatedField = 'matkulGroupModifiedDate';
    protected $deletedField = 'matkulGroupDeletedAt';

    public function getMatkulGroup($keyword = null)
    {
        $builder = $this->table('dt_matkul_group');
        if ($keyword) {
            $builder->like('LOWER(dt_matkul_group."matkulGroupKode")', strtolower($keyword))->where('dt_matkul_group.matkulGroupDeletedAt', null);
            $builder->orlike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($keyword))->where('dt_matkul_group.matkulGroupDeletedAt', null);
            $builder->orlike('LOWER(dt_matkul_group."matkulGroupDeskripsi")', strtolower($keyword))->where('dt_matkul_group.matkulGroupDeletedAt', null);
        }
        $builder->orderBy('dt_matkul_group.matkulGroupId', 'DESC');
        return $builder;
    }

    public function getMatkulGroupAll()
    {
        $builder = $this->table('dt_matkul_group');
        $builder->orderBy('dt_matkul_group.matkulGroupOrder', 'Asc');
        return $builder;
    }
}
