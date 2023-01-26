<?php

namespace Modules\NilaiProdi\Models;

use CodeIgniter\Model;

class NilaiProdiModel extends Model
{
    protected $table = 'dt_grade_prodi_nilai';
    protected $primaryKey = 'gradeProdiNilaiId';
    protected $allowedFields = ['gradeProdiNilaiProdiId', 'gradeProdiNilaiGradeId', 'gradeProdiNilaiBobot', 'gradeProdiNilaiPredikat', 'gradeProdiNilaiPredikatEng', 'gradeProdiNilaiSkalaMin', 'gradeProdiNilaiSkalaMax', 'gradeProdiNilaiCreatedBy', 'gradeProdiNilaiModifiedBy', 'gradeProdiNilaiModifiedDate', 'gradeProdiNilaiCreatedDate', 'gradeProdiNilaiDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'gradeProdiNilaiCreatedDate';
    protected $updatedField = 'gradeProdiNilaiModifiedDate';
    protected $deletedField = 'gradeProdiNilaiDeletedAt';

    public function getNilaiProdi()
    {
        $builder = $this->table('dt_grade_prodi_nilai');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = dt_grade_prodi_nilai.gradeProdiNilaiProdiId', 'left');
        $builder->join('dt_grade_nilai', 'dt_grade_nilai.gradeNilaiId = dt_grade_prodi_nilai.gradeProdiNilaiGradeId', 'left');
        return $builder;
    }

    public function getNilaiProdiDetail($where)
    {
        $builder = $this->table('dt_grade_prodi_nilai');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = dt_grade_prodi_nilai.gradeProdiNilaiProdiId', 'left');
        $builder->join('dt_grade_nilai', 'dt_grade_nilai.gradeNilaiId = dt_grade_prodi_nilai.gradeProdiNilaiGradeId', 'left');
        $builder->where($where);
        return $builder;
    }

    public function getNilaiProdiDetailByNpm($where)
    {
        $builder = $this->table('dt_grade_prodi_nilai');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = dt_grade_prodi_nilai."gradeProdiNilaiProdiId"', 'left');
        $builder->join('dt_grade_nilai', 'dt_grade_nilai."gradeNilaiId" = dt_grade_prodi_nilai."gradeProdiNilaiGradeId"', 'left');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahProdiId" = dt_prodi."prodiId"', 'left');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"', 'left');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa."mahasiswaProdiProgramKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahId"', 'left');
        $builder->where($where);
        return $builder;
    }
}
