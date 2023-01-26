<?php

namespace Modules\Token\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table = 'api_token';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'token'];

    public function getToken($id)
    {
        $builder = $this->table($this->table);
        $data = $builder->where('id', $id)->first();
        return $data['token'];
    }
}
