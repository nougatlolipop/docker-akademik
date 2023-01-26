<?php

namespace Modules\SetJabatanStruktural\Models;

use CodeIgniter\Model;

class SetJabatanStrukturalModel extends Model
{
    protected $table = 'setting_jabatan_struktural';
    protected $primaryKey = 'setJabatanId';
    protected $allowedFields = ['setJabatanDosenId', 'setJabatanStukturalId', 'setJabatanFakultasId', 'setJabatanNoSK', 'setJabatanTanggalSK', 'setJabatanStartDate', 'setJabatanEndDate', 'setJabatanSKDokumen',  'setJabatanCreatedBy', 'setJabatanCreatedDate', 'setJabatanModifiedBy',  'setJabatanModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'setJabatanCreatedDate';
    protected $updatedField = 'setJabatanModifiedDate';

    public function getJabatanStrukturalSearch($keyword = null)
    {
        $builder = $this->table('setting_jabatan_struktural');
        $builder->join('dt_dosen', 'dt_dosen."dosenId" = setting_jabatan_struktural."setJabatanDosenId"', 'left');
        $builder->join('ref_jabatan_struktural', 'ref_jabatan_struktural."refJabatanStrukturalId" = setting_jabatan_struktural."setJabatanStukturalId"', 'left');
        $builder->join('dt_fakultas', 'dt_fakultas."fakultasId" = setting_jabatan_struktural."setJabatanFakultasId"', 'left');
        $builder->like('LOWER(dt_fakultas."fakultasNama")', strtolower($keyword));
        $builder->orLike('LOWER(ref_jabatan_struktural."refJabatanStrukturalNama")', strtolower($keyword));
        $builder->orLike('LOWER(setting_jabatan_struktural."setJabatanNoSK")', strtolower($keyword));
        $builder->orderBy('setting_jabatan_struktural."setJabatanId"', 'DESC');
        return $builder;
    }

    public function getJabatanStruktural()
    {
        $builder = $this->table('setting_jabatan_struktural');
        $builder->join('dt_dosen', 'dt_dosen.dosenId = setting_jabatan_struktural.setJabatanDosenId', 'left');
        $builder->join('ref_jabatan_struktural', 'ref_jabatan_struktural."refJabatanStrukturalId" = setting_jabatan_struktural."setJabatanStukturalId"', 'left');
        $builder->join('dt_fakultas', 'dt_fakultas."fakultasId" = setting_jabatan_struktural."setJabatanFakultasId"', 'left');
        $builder->orderBy('setting_jabatan_struktural."setJabatanId"', 'DESC');
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }
}
