<?php

namespace Modules\ManajemenAkun\Models;

use CodeIgniter\Model;

class ManajemenAkunModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash', 'status', 'status_message', 'active', 'force_pass_reset', 'created_at', 'created_update', 'deleted_at'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';

    public function getManajemenAkun()
    {
        $builder = $this->table('users');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'LEFT');
        $builder->join('auth_groups', 'auth_groups.id  = auth_groups_users.group_id', 'LEFT');
        $builder->join('users_role', 'users_role.roleEmail  = users.email', 'LEFT');
        $builder->join('ref_tingkat_users', 'ref_tingkat_users.refTingkatId  = users_role.roleTingkatId', 'LEFT');
        $builder->join('dt_fakultas', 'dt_fakultas.fakultasId  = users_role.roleFakultasId', 'LEFT');
        $builder->orderBy('users.id', 'DESC');
        return $builder;
    }

    public function getManajemenAkunSearch($keyword)
    {
        $builder = $this->table('users');
        $builder->join('auth_groups_users', 'auth_groups_users."user_id" = users."id"', 'LEFT');
        $builder->join('auth_groups', 'auth_groups."id"  = auth_groups_users."group_id"', 'LEFT');
        $builder->join('users_role', 'users_role."roleEmail"  = users."email"', 'LEFT');
        $builder->join('ref_tingkat_users', 'ref_tingkat_users."refTingkatId"  = users_role."roleTingkatId"', 'LEFT');
        $builder->join('dt_fakultas', 'dt_fakultas."fakultasId"  = users_role."roleFakultasId"', 'LEFT');
        $builder->like('LOWER(auth_groups."name")', strtolower($keyword));
        $builder->orlike('LOWER(users."username")', strtolower($keyword));
        $builder->orlike('LOWER(users."email")', strtolower($keyword));
        $builder->orlike('LOWER(ref_tingkat_users."refTingkatNama")', strtolower($keyword));
        $builder->orlike('LOWER(dt_fakultas."fakultasNama")', strtolower($keyword));
        $builder->orderBy('users."id"', 'DESC');
        return $builder;
    }

    public function getUserDetail($where)
    {
        $builder = $this->table('users');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'LEFT');
        $builder->join('auth_groups', 'auth_groups.id  = auth_groups_users.group_id', 'LEFT');
        $builder->join('users_role', 'users_role.roleEmail  = users.email', 'LEFT');
        $builder->join('ref_tingkat_users', 'ref_tingkat_users.refTingkatId  = users_role.roleTingkatId', 'LEFT');
        $builder->join('dt_fakultas', 'dt_fakultas.fakultasId  = users_role.roleFakultasId', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiFakultasId  = dt_fakultas.fakultasId', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function getDosenProdi($where)
    {
        $builder = $this->table('users');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id  = auth_groups_users.group_id');
        $builder->join('users_role', 'users_role.roleEmail  = users.email');
        $builder->join('ref_tingkat_users', 'ref_tingkat_users.refTingkatId  = users_role.roleTingkatId');
        $builder->join('dt_fakultas', 'dt_fakultas.fakultasId  = users_role.roleFakultasId');
        $builder->join('dt_prodi', 'dt_prodi.prodiFakultasId  = dt_fakultas.fakultasId');
        $builder->join('setting_dosen_prodi', 'setting_dosen_prodi.setDosenProdiProdiId  = dt_prodi.prodiId');
        $builder->join('dt_dosen', 'dt_dosen.dosenId  = setting_dosen_prodi.setDosenProdiDosenId');
        $builder->where($where);
        return $builder;
    }
}
