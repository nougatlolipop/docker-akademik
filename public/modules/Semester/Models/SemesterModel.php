<?php

namespace Modules\Semester\Models;

use CodeIgniter\Model;

class SemesterModel extends Model
{
    protected $table = 'dt_semester';
    protected $primaryKey = 'semesterId';
    protected $allowedFields = ['semesterKode', 'semesterNama', 'semesterCreatedBy', 'semesterCreatedDate', 'semesterModifiedBy', 'semesterModifiedDate', 'semesterDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'semesterCreatedDate';
    protected $updatedField = 'semesterModifiedDate';
    protected $deletedField = 'semesterDeletedAt';

    public function getSemester()
    {
        $builder = $this->table('dt_semester');
        $builder->orderBy('dt_semester.semesterId', 'DESC');
        return $builder;
    }

    public function getSemesterSearch($keyword = null)
    {
        $builder = $this->table('dt_semester');
        $builder->like('LOWER(dt_semester."semesterNama")', strtolower($keyword))->where('dt_semester.semesterDeletedAt', null);
        $builder->orlike('LOWER(dt_semester."semesterKode")', strtolower($keyword))->where('dt_semester.semesterDeletedAt', null);
        $builder->orderBy('dt_semester.semesterId', 'DESC');
        return $builder;
    }
}
