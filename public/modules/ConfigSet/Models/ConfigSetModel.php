<?php

namespace Modules\ConfigSet\Models;

use CodeIgniter\Model;

class ConfigSetModel extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'configId';
    protected $allowedFields = ['configNama', 'configValue', 'configDeskripsi', 'configModifiedBy', 'configModifiedDate'];
    protected $useTimestamps = 'false';
    protected $updatedField = 'configModifiedDate';
    protected $returnType = 'object';
}
