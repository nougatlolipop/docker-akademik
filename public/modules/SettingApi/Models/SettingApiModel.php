<?php

namespace Modules\SettingApi\Models;

use CodeIgniter\Model;

class SettingApiModel extends Model
{
    protected $table = 'setting_api';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user', 'pass', 'token', 'ippublic', 'settingApiModifiedBy', 'settingApiModifiedDate'];
    protected $useTimestamps = 'false';
    protected $updatedField = 'settingApiModifiedDate';
    protected $returnType = 'object';
}
