<?php

namespace Modules\StudiLevel\Models;

use CodeIgniter\Model;

class StudiLevelModel extends Model
{
    protected $table = 'dt_studi_level';
    protected $primaryKey = 'studiLevelId';
    protected $allowedFields = ['studiLevelKode', 'studiLevelNama', 'studiLevelCreatedBy', 'studiLevelCreatedDate', 'studiLevelModifiedBy', 'studiLevelModifiedDate', 'studiLevelDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'studiLevelCreatedDate';
    protected $updatedField = 'studiLevelModifiedDate';
    protected $deletedField = 'studiLevelDeletedAt';

    public function getStudiLevel()
    {
        $builder = $this->table('dt_studi_level');
        $builder->orderBy('dt_studi_level.studiLevelId', 'DESC');
        return $builder;
    }

    public function getStudiLevelSearch($keyword = null)
    {
        $builder = $this->table('dt_studi_level');
        $builder->like('LOWER(dt_studi_level."studiLevelNama")', strtolower($keyword))->where('dt_studi_level.studiLevelDeletedAt', null);
        $builder->orlike('LOWER(dt_studi_level."studiLevelKode")', strtolower($keyword))->where('dt_studi_level.studiLevelDeletedAt', null);
        $builder->orderBy('dt_studi_level.studiLevelId', 'DESC');
        return $builder;
    }
}
