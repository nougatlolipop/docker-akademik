<?php

namespace Modules\Kelas\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table = 'dt_kelas';
    protected $primaryKey = 'kelasId';
    protected $allowedFields = ['kelasKode', 'kelasNama', 'kelasCreatedBy', 'kelasModifiedBy', 'kelasModifiedDate', 'kelasCreatedDate', 'kelasDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'kelasCreatedDate';
    protected $updatedField = 'kelasModifiedDate';
    protected $deletedField = 'kelasDeletedAt';

    public function getKelas()
    {
        $builder = $this->table('dt_kelas');
        $builder->orderBy('dt_kelas.kelasId', 'DESC');
        return $builder;
    }

    public function getKelasSearch($keyword = null)
    {
        $builder = $this->table('dt_kelas');
        $builder->like('LOWER(dt_kelas."kelasNama")', strtolower($keyword))->where('dt_kelas.kelasDeletedAt', null);
        $builder->orlike('LOWER(dt_kelas."kelasKode")', strtolower($keyword))->where('dt_kelas.kelasDeletedAt', null);
        $builder->orderBy('dt_kelas."kelasId"', 'DESC');
        return $builder;
    }
}
