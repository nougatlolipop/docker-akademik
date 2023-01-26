<?php

namespace Modules\SetDosenProdi\Models;

use CodeIgniter\Model;

class SetDosenProdiModel extends Model
{
    protected $table = 'setting_dosen_prodi';
    protected $primaryKey = 'setDosenProdiId';
    protected $allowedFields = ['setDosenProdiDosenId', 'setDosenProdiProdiId', 'setDosenProdiIsAktif', 'setDosenProdiCreatedBy', 'setDosenProdiCreatedDate', 'setDosenProdiModifiedBy', 'setDosenProdiModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'setDosenProdiCreatedDate';
    protected $updatedField = 'setDosenProdiModifiedDate';

    public function getDosenProdi($where, $fakultas = null)
    {
        $builder = $this->table('setting_dosen_prodi');
        $builder->join('dt_dosen', 'dt_dosen.dosenId = setting_dosen_prodi.setDosenProdiDosenId', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_dosen_prodi.setDosenProdiProdiId', 'LEFT');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if ($where) {
            if (isset($where['prodi'])) {
                $builder->whereIn('setting_dosen_prodi."setDosenProdiProdiId"', $where['prodi']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_dosen."dosenNama")', strtolower($where['keyword']))->whereIn('setting_dosen_prodi."setDosenProdiProdiId"', $where['prodi']);
                }
            }
            if (!isset($where['prodi'])) {
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_dosen."dosenNama")', strtolower($where['keyword']));
                }
            }
        }
        $builder->orderBy('setting_dosen_prodi.setDosenProdiId', 'DESC');
        return $builder;
    }

    public function getDosenProdiWhere($where)
    {
        $builder = $this->table('dt_dosen');
        $builder->join('dt_dosen', 'dt_dosen.dosenId = setting_dosen_prodi.setDosenProdiDosenId', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('setting_dosen_prodi');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }

    public function search($where)
    {
        $builder = $this->table('setting_dosen_prodi');
        $builder->join('dt_dosen', 'dt_dosen."dosenId" = setting_dosen_prodi."setDosenProdiDosenId"', 'LEFT');
        if ($where[1]) {
            $builder->like('LOWER(dt_dosen."dosenNama")', strtolower($where[0]))->where('setting_dosen_prodi.setDosenProdiProdiId', $where[2])->whereNotIn('setting_dosen_prodi.setDosenProdiDosenId', $where[1]);
            $builder->orLike('LOWER(dt_dosen."dosenGelarDepan")', strtolower($where[0]))->where('setting_dosen_prodi.setDosenProdiProdiId', $where[2])->whereNotIn('setting_dosen_prodi.setDosenProdiDosenId', $where[1]);
            $builder->orLike('LOWER(dt_dosen."dosenGelarBelakang")', strtolower($where[0]))->where('setting_dosen_prodi.setDosenProdiProdiId', $where[2])->whereNotIn('setting_dosen_prodi.setDosenProdiDosenId', $where[1]);
        } else {
            $builder->like('LOWER(dt_dosen."dosenNama")', strtolower($where[0]))->where('setting_dosen_prodi.setDosenProdiProdiId', $where[2]);
            $builder->orLike('LOWER(dt_dosen."dosenGelarDepan")', strtolower($where[0]))->where('setting_dosen_prodi.setDosenProdiProdiId', $where[2]);
            $builder->orLike('LOWER(dt_dosen."dosenGelarBelakang")', strtolower($where[0]))->where('setting_dosen_prodi.setDosenProdiProdiId', $where[2]);
        }
        $builder->limit($where[3], 0);
        return $builder;
    }

    public function getWhereIn($where)
    {
        $builder = $this->table('setting_dosen_prodi');
        $builder->whereIn('setting_dosen_prodi."setDosenProdiProdiId"', $where);
        return $builder;
    }
}
