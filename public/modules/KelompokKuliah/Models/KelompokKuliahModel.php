<?php

namespace Modules\KelompokKuliah\Models;

use CodeIgniter\Model;

class KelompokKuliahModel extends Model
{
    protected $table = 'dt_kelompok_kuliah';
    protected $primaryKey = 'kelompokKuliahId';
    protected $allowedFields = ['kelompokKuliahKode', 'kelompokKuliahNama', 'kelompokKuliahDeskripsi', 'kelompokKuliahCreatedBy', 'kelompokKuliahModifiedBy', 'kelompokKuliahModifiedDate', 'kelompokKuliahCreatedDate', 'kelompokKuliahDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'kelompokKuliahCreatedDate';
    protected $updatedField = 'kelompokKuliahModifiedDate';
    protected $deletedField = 'kelompokKuliahDeletedAt';

    public function getKelompokKuliah($where = null)
    {
        $builder = $this->table('dt_kelompok_kuliah');
        $builder->orderBy('dt_kelompok_kuliah.kelompokKuliahId', 'DESC');
        if ($where) {
            $builder->where($where);
        }
        return $builder;
    }

    public function getKelompokKuliahSearch($keyword = null)
    {
        $builder = $this->table('dt_kelompok_kuliah');
        $builder->like('LOWER(dt_kelompok_kuliah.kelompokKuliahNama)', strtolower($keyword))->where('dt_kelompok_kuliah.kelompokKuliahDeletedAt', null);
        $builder->orlike('LOWER(dt_kelompok_kuliah.kelompokKuliahKode)', strtolower($keyword))->where('dt_kelompok_kuliah.kelompokKuliahDeletedAt', null);
        $builder->orlike('LOWER(dt_kelompok_kuliah.kelompokKuliahDeskripsi)', strtolower($keyword))->where('dt_kelompok_kuliah.kelompokKuliahDeletedAt', null);
        $builder->orderBy('dt_kelompok_kuliah.kelompokKuliahId', 'DESC');
        return $builder;
    }
}
