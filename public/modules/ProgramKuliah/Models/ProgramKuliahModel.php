<?php

namespace Modules\ProgramKuliah\Models;

use CodeIgniter\Model;

class ProgramKuliahModel extends Model
{
    protected $table = 'dt_program_kuliah';
    protected $primaryKey = 'programKuliahId';
    protected $allowedFields = ['programKuliahKode', 'programKuliahNama', 'programKuliahCreatedBy', 'programKuliahCreatedDate', 'programKuliahModifiedBy', 'programKuliahModifiedDate', 'programKuliahDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';
    protected $useTimestamps = 'true';
    protected $createdField = 'programKuliahCreatedDate';
    protected $updatedField = 'programKuliahModifiedDate';
    protected $deletedField = 'programKuliahDeletedAt';

    public function getProgramKuliah()
    {
        $builder = $this->table('dt_program_kuliah');
        $builder->orderBy('dt_program_kuliah.programKuliahId', 'DESC');
        return $builder;
    }

    public function getProgramKuliahSearch($keyword = null)
    {
        $builder = $this->table('dt_program_kuliah');
        $builder->like('LOWER(dt_program_kuliah."programKuliahKode")', strtolower($keyword))->where('dt_program_kuliah.programKuliahDeletedAt', null);
        $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($keyword))->where('dt_program_kuliah.programKuliahDeletedAt', null);
        $builder->orderBy('dt_program_kuliah.programKuliahId', 'DESC');
        return $builder;
    }

    public function programKuliahAkademik($where)
    {
        $builder = $this->table('dt_program_kuliah');
        $builder->select('dt_program_kuliah."programKuliahId", dt_program_kuliah."programKuliahNama"');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId" = dt_program_kuliah."programKuliahId"', 'LEFT');
        $builder->where($where);
        $builder->groupBy('dt_program_kuliah."programKuliahId"');
        return $builder;
    }

    public function getProgramKuliahDetail($where)
    {
        $builder = $this->table('dt_program_kuliah');
        $builder->where($where);
        return $builder;
    }
}
