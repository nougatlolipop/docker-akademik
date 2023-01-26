<?php

namespace Modules\Kurikulum\Models;

use CodeIgniter\Model;

class KurikulumModel extends Model
{
    protected $table = 'dt_kurikulum';
    protected $primaryKey = 'kurikulumId';
    protected $allowedFields = ['kurikulumKode', 'kurikulumNama', 'kurikulumKurTypeId', 'kurikulumSksAllowId', 'kurikulumCreatedBy', 'kurikulumModifiedBy', 'kurikulumModifiedDate', 'kurikulumCreatedDate', 'kurikulumDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'kurikulumCreatedDate';
    protected $updatedField = 'kurikulumModifiedDate';
    protected $deletedField = 'kurikulumDeletedAt';

    public function getKurikulum()
    {
        $builder = $this->table('dt_kurikulum');
        $builder->join('dt_kurikulum_type', 'dt_kurikulum_type.kurikulumTypeId = dt_kurikulum.kurikulumKurTypeId', 'LEFT');
        $builder->join('dt_sks_allow', 'dt_sks_allow.sksAllowId = dt_kurikulum.kurikulumSksAllowId', 'LEFT');
        $builder->orderBy('dt_kurikulum.kurikulumId', 'DESC');
        return $builder;
    }

    public function getKurikulumSearch($keyword = null)
    {
        $builder = $this->table('dt_kurikulum');
        $builder->join('dt_kurikulum_type', 'dt_kurikulum_type."kurikulumTypeId" = dt_kurikulum."kurikulumKurTypeId"', 'LEFT');
        $builder->join('dt_sks_allow', 'dt_sks_allow."sksAllowId" = dt_kurikulum."kurikulumSksAllowId"', 'LEFT');
        $builder->like('LOWER(dt_kurikulum."kurikulumNama")', strtolower($keyword))->where('dt_kurikulum."kurikulumDeletedAt"', null);
        $builder->orlike('LOWER(dt_kurikulum."kurikulumKode")', strtolower($keyword))->where('dt_kurikulum."kurikulumDeletedAt"', null);
        $builder->orlike('LOWER(dt_kurikulum_type."kurikulumTypeNama")', strtolower($keyword))->where('dt_kurikulum."kurikulumDeletedAt"', null);
        $builder->orlike('LOWER(dt_sks_allow."sksAllowNama")', strtolower($keyword))->where('dt_kurikulum."kurikulumDeletedAt"', null);
        $builder->orderBy('dt_kurikulum."kurikulumId"', 'DESC');
        return $builder;
    }

    public function getKurikulumType()
    {
        $builder = $this->db->table('dt_kurikulum_type');
        return $builder->get();
    }

    public function getKurikulumDetail($where)
    {
        $builder = $this->table('dt_kurikulum');
        $builder->where($where);
        return $builder;
    }
}
