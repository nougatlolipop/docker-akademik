<?php

namespace Modules\Nilai\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table = 'dt_grade_nilai';
    protected $primaryKey = 'gradeNilaiId';
    protected $allowedFields = ['gradeNilaiKode', 'gradeNilaiNama', 'gradeNilaiCreatedBy', 'gradeNilaiModifiedBy', 'gradeNilaiModifiedDate', 'gradeNilaiCreatedDate', 'gradeNilaiDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'gradeNilaiCreatedDate';
    protected $updatedField = 'gradeNilaiModifiedDate';
    protected $deletedField = 'gradeNilaiDeletedAt';

    public function getNilai()
    {
        $builder = $this->table('dt_grade_nilai');
        $builder->orderBy('dt_grade_nilai.gradeNilaiId', 'DESC');
        return $builder;
    }

    public function getNilaiSearch($keyword = null)
    {
        $builder = $this->table('dt_grade_nilai');
        $builder->like('LOWER(dt_grade_nilai."gradeNilaiNama")', strtolower($keyword))->where('dt_grade_nilai.gradeNilaiDeletedAt', null);
        $builder->orlike('LOWER(dt_grade_nilai."gradeNilaiKode")', strtolower($keyword))->where('dt_grade_nilai.gradeNilaiDeletedAt', null);
        $builder->orderBy('dt_grade_nilai.gradeNilaiId', 'DESC');
        return $builder;
    }
}
