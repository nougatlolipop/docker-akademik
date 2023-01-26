<?php

namespace Modules\TahunAjaran\Models;

use CodeIgniter\Model;

class TahunAjaranModel extends Model
{
    protected $table = 'dt_tahun_ajaran';
    protected $primaryKey = 'tahunAjaranId';
    protected $allowedFields = ['tahunAjaranKode', 'tahunAjaranSemesterId', 'tahunAjaranNama', 'tahunAjaranStartDate', 'tahunAjaranEndDate', 'tahunAjaranCreatedBy', 'tahunAjaranModifiedBy', 'tahunAjaranModifiedDate', 'tahunAjaranCreatedDate', 'tahunAjaranDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'tahunAjaranCreatedDate';
    protected $updatedField = 'tahunAjaranModifiedDate';
    protected $deletedField = 'tahunAjaranDeletedAt';

    public function getTahunAjaran()
    {
        $builder = $this->table('dt_tahun_ajaran');
        $builder->join('dt_semester', 'dt_semester.semesterId=dt_tahun_ajaran.tahunAjaranSemesterId', 'LEFT');
        $builder->orderBy('dt_tahun_ajaran.tahunAjaranId', 'DESC');
        return $builder;
    }

    public function getTahunAjaranSearch($keyword = null)
    {
        $builder = $this->table('dt_tahun_ajaran');
        $builder->join('dt_semester', 'dt_semester.semesterId=dt_tahun_ajaran.tahunAjaranSemesterId', 'LEFT');
        $builder->like('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($keyword))->where('dt_tahun_ajaran.tahunAjaranDeletedAt', null);
        $builder->orlike('LOWER(dt_tahun_ajaran."tahunAjaranKode")', strtolower($keyword))->where('dt_tahun_ajaran.tahunAjaranDeletedAt', null);
        $builder->orlike('LOWER(dt_semester."semesterKode")', strtolower($keyword))->where('dt_tahun_ajaran.tahunAjaranDeletedAt', null);
        $builder->orlike('LOWER(dt_semester."semesterNama")', strtolower($keyword))->where('dt_tahun_ajaran.tahunAjaranDeletedAt', null);
        $builder->orderBy('dt_tahun_ajaran.tahunAjaranId', 'DESC');
        return $builder;
    }

    public function getSemester()
    {
        $builder = $this->db->table('dt_semester');
        return $builder->get();
    }

    public function getTahunAjaranBerjalan()
    {
        $builder = $this->table('dt_tahun_ajaran');
        $builder->where(['dt_tahun_ajaran."tahunAjaranStartDate" <=' => date('Y-m-d H:i:s'), 'dt_tahun_ajaran."tahunAjaranEndDate" >=' => date('Y-m-d H:i:s')]);
        return $builder;
    }
}
