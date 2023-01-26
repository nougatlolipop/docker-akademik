<?php

namespace Modules\Maja\Models;

use CodeIgniter\Model;

class MajaModel extends Model
{
    protected $table = 'maja_token';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'access_token', 'refresh_token'];

    public function getToken($id)
    {
        $builder = $this->table($this->table);
        $data = $builder->where('id', $id)->first();
        return [$data['access_token'], $data['refresh_token']];
    }
}
