<?php

namespace Modules\JadwalWaktu\Models;

use CodeIgniter\Model;

class JadwalWaktuModel extends Model
{
    protected $table = 'dt_jadwal_kuliah';
    protected $primaryKey = 'jadwalKuliahId';
    protected $allowedFields = ['jadwalKuliahKelompokId', 'jadwalKuliahHariId', 'jadwalKuliahMulai', 'jadwalKuliahSelesai', 'jadwalKuliahDeskripsi', 'jadwalKuliahModifiedBy', 'jadwalKuliahModifiedDate', 'jadwalKuliahCreatedBy', 'jadwalKuliahCreatedDate', 'jadwalKuliahDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'jadwalKuliahCreatedDate';
    protected $updatedField = 'jadwalKuliahModifiedDate';
    protected $deletedField = 'jadwalKuliahDeletedAt';

    public function getJadwalWaktu()
    {
        $builder = $this->table('dt_jadwal_kuliah');
        $builder->join('dt_kelompok_kuliah', 'dt_kelompok_kuliah.kelompokKuliahId = dt_jadwal_kuliah.jadwalKuliahKelompokId', 'LEFT');
        $builder->join('ref_hari', 'ref_hari.refHariId = dt_jadwal_kuliah.jadwalKuliahHariId', 'LEFT');
        $builder->orderBy('dt_jadwal_kuliah.jadwalKuliahId', 'DESC');
        return $builder;
    }

    public function getJadwalWaktuSearch($keyword = null)
    {
        $builder = $this->table('dt_jadwal_kuliah');
        $builder->join('dt_kelompok_kuliah', 'dt_kelompok_kuliah."kelompokKuliahId" = dt_jadwal_kuliah.jadwalKuliahKelompokId', 'LEFT');
        $builder->join('ref_hari', 'ref_hari.refHariId = dt_jadwal_kuliah."jadwalKuliahHariId"', 'LEFT');
        $builder->like('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($keyword))->where('dt_jadwal_kuliah.jadwalKuliahDeletedAt', null);
        $builder->orlike('LOWER(ref_hari."refHariNama")', strtolower($keyword))->where('dt_jadwal_kuliah.jadwalKuliahDeletedAt', null);
        $builder->orderBy('dt_jadwal_kuliah."jadwalKuliahId"', 'DESC');
        return $builder;
    }
}
