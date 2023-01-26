<?php

namespace Modules\SettingMaja\Models;

use CodeIgniter\Model;

class SettingMajaModel extends Model
{
    protected $table = 'setting_maja';
    protected $primaryKey = 'id';
    protected $allowedFields = ['client_id', 'client_secret', 'username', 'password', 'settingMajaModifiedBy', 'settingMajaModifiedDate'];
    protected $useTimestamps = 'false';
    protected $updatedField = 'settingMajaModifiedDate';
    protected $returnType = 'object';
}
