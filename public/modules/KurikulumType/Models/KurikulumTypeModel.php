<?php

namespace Modules\KurikulumType\Models;

use CodeIgniter\Model;

class KurikulumTypeModel extends Model
{
    protected $table = 'dt_kurikulum_type';
    protected $primaryKey = 'kurikulumTypeId';
    protected $allowedFields = ['kurikulumTypeKode', 'kurikulumTypeNama', 'kurikulumTypeCreatedBy', 'kurikulumTypeCreatedDate', 'kurikulumTypeModifiedBy', 'kurikulumTypeModifiedDate', 'kurikulumTypeDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'kurikulumTypeCreatedDate';
    protected $updatedField = 'kurikulumTypeModifiedDate';
    protected $deletedField = 'kurikulumTypeDeletedAt';

    public function getKurikulumType()
    {
        $builder = $this->table('dt_kurikulum_type');
        return $builder;
    }

    public function getKurikulumTypeSearch($keyword = null)
    {
        $builder = $this->table('dt_kurikulum_type');
        $builder->like('LOWER(dt_kurikulum_type."kurikulumTypeNama")', strtolower($keyword))->where('dt_kurikulum_type."kurikulumTypeDeletedAt"', null);
        $builder->orlike('LOWER(dt_kurikulum_type."kurikulumTypeKode")', strtolower($keyword))->where('dt_kurikulum_type."kurikulumTypeDeletedAt"', null);;
        return $builder;
    }
}
