<?php

namespace Modules\UserRole\Models;

use CodeIgniter\Model;

class UserRoleModel extends Model
{
    protected $table = 'users_role';
    protected $primaryKey = 'roleId';
    protected $allowedFields = ['roleEmail', 'roleApp', 'roleTingkatId', 'roleFakultasId', 'roleCreatedBy', 'roleCreatedDate', 'roleModifiedBy', 'roleModiifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'roleCreatedDate';
    protected $updatedField = 'roleModiifiedDate';

    public function deleteData($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        $builder->delete();
        return $builder;
    }
}
