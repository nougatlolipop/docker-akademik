<?php

namespace Modules\Matkul\Models;

use CodeIgniter\Model;

class MatkulModel extends Model
{
    protected $table = 'dt_matkul';
    protected $primaryKey = 'matkulId';
    protected $allowedFields = ['matkulKode', 'matkulNama', 'matkulNamaEnglish', 'matkulProdiId', 'matkulTypeId', 'matkulCreatedBy', 'matkulCreatedDate', 'matkulModifiedBy', 'matkulModifiedDate', 'matkulDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'matkulCreatedDate';
    protected $updatedField = 'matkulModifiedDate';
    protected $deletedField = 'matkulDeletedAt';

    public function getMatkul($fakultas = null, $keyword = null)
    {
        $builder = $this->table('dt_matkul');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = dt_matkul.matkulProdiId');
        $builder->join('dt_matkul_type', 'dt_matkul_type.matkulTypeId = dt_matkul.matkulTypeId');
        if ($fakultas) {
            if ($keyword) {
                $builder->like('LOWER(dt_matkul."matkulKode")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null)->where($fakultas);
                $builder->orlike('LOWER(dt_matkul."matkulNama")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null)->where($fakultas);
                $builder->orlike('LOWER(dt_matkul."matkulNamaEnglish")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null)->where($fakultas);
                $builder->orlike('LOWER(dt_matkul_type."matkulTypeNama")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null)->where($fakultas);
                $builder->orlike('LOWER(dt_matkul_type."matkulTypeShortName")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null)->where($fakultas);
                $builder->orlike('LOWER(dt_prodi."prodiNama")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null)->where($fakultas);
            } else {
                $builder->where($fakultas);
            }
        } else {
            if ($keyword) {
                $builder->like('LOWER(dt_matkul."matkulKode")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null);
                $builder->orlike('LOWER(dt_matkul."matkulNama")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null);
                $builder->orlike('LOWER(dt_matkul."matkulNamaEnglish")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null);
                $builder->orlike('LOWER(dt_matkul_type."matkulTypeNama")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null);
                $builder->orlike('LOWER(dt_matkul_type."matkulTypeShortName")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null);
                $builder->orlike('LOWER(dt_prodi."prodiNama")', strtolower($keyword))->where('dt_matkul.matkulDeletedAt', null);
            }
        }
        $builder->orderBy('dt_matkul.matkulId', 'DESC');
        return $builder;
    }

    public function matkulProdi($whereIn)
    {
        $builder = $this->table('dt_matkul');
        $builder->whereIn('dt_matkul."matkulProdiId"', $whereIn);
        return $builder;
    }

    public function getMatkulType()
    {
        $builder = $this->db->table('dt_matkul_type');
        return $builder->get()->getResult();
    }

    public function dataExist($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }
}
