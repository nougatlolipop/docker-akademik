<?php

namespace Modules\WaktuKuliah\Models;

use CodeIgniter\Model;

class WaktuKuliahModel extends Model
{
    protected $table = 'dt_waktu_kuliah';
    protected $primaryKey = 'waktuId';
    protected $allowedFields = ['waktuNama', 'waktuCreatedBy', 'waktuModifiedBy', 'waktuModifiedDate', 'waktuCreatedDate', 'waktuDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'waktuCreatedDate';
    protected $updatedField = 'waktuModifiedDate';
    protected $deletedField = 'waktuDeletedAt';

    public function getWaktuKuliah()
    {
        $builder = $this->table('dt_waktu_kuliah');
        $builder->orderBy('dt_waktu_kuliah.waktuId', 'DESC');
        return $builder;
    }

    public function getWaktuKuliahSearch($keyword = null)
    {
        $builder = $this->table('dt_waktu_kuliah');
        $builder->like('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($keyword))->where('dt_waktu_kuliah.waktuDeletedAt', null);
        $builder->orlike('LOWER(dt_waktu_kuliah."waktuKode")', strtolower($keyword))->where('dt_waktu_kuliah.waktuDeletedAt', null);
        $builder->orderBy('dt_waktu_kuliah.waktuId', 'DESC');
        return $builder;
    }

    public function getWaktuKuliahDetail($where)
    {
        $builder = $this->table('dt_waktu_kuliah');
        $builder->where($where);
        return $builder;
    }
}
