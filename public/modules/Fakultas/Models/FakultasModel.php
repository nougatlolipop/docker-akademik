<?php

namespace Modules\Fakultas\Models;

use CodeIgniter\Model;

class FakultasModel extends Model
{
    protected $table = 'dt_fakultas';
    protected $primaryKey = 'fakultasId';
    protected $allowedFields = ['fakultasKode', 'fakultasNama', 'fakultasAcronym', 'fakultasNamaAsing', 'fakultasDekan', 'fakultasWD1', 'fakultasWD2', 'fakultasWD3', 'fakultasIsAktif', 'fakultasCreateBy', 'fakultasCreateDate', 'fakultasModifiedBy', 'fakultasModifiedDate', 'fakultasDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';
    protected $useTimestamps = 'true';
    protected $createdField = 'fakultasCreateDate';
    protected $updatedField = 'fakultasModifiedDate';
    protected $deletedField = 'fakultasDeletedAt';

    public function getFakultas()
    {
        $builder = $this->table('dt_fakultas');
        $builder->whereNotIn('dt_fakultas."fakultasKode"', ['99']);
        $builder->orderBy('dt_fakultas."fakultasId"', 'DESC');
        return $builder;
    }

    public function getFakultasForKrs()
    {
        $builder = $this->table('dt_fakultas');
        $builder->whereNotIn('dt_fakultas."fakultasKode"', ['99', '12']);
        return $builder;
    }

    public function getFakultasSearch($keyword = null)
    {
        $builder = $this->table('dt_fakultas');
        $builder->whereNotIn('dt_fakultas."fakultasKode"', ['99', '12']);
        $builder->like('LOWER(dt_fakultas."fakultasKode")', strtolower($keyword))->where('dt_fakultas.fakultasDeletedAt', null);
        $builder->orlike('LOWER(dt_fakultas."fakultasNama")', strtolower($keyword))->where('dt_fakultas.fakultasDeletedAt', null);
        $builder->orlike('LOWER(dt_fakultas."fakultasAcronym")', strtolower($keyword))->where('dt_fakultas.fakultasDeletedAt', null);
        $builder->orlike('LOWER(dt_fakultas."fakultasNamaAsing")', strtolower($keyword))->where('dt_fakultas.fakultasDeletedAt', null);
        $builder->orlike('LOWER(dt_fakultas."fakultasDekan")', strtolower($keyword))->where('dt_fakultas.fakultasDeletedAt', null);
        $builder->orlike('LOWER(dt_fakultas."fakultasWD1")', strtolower($keyword))->where('dt_fakultas.fakultasDeletedAt', null);
        $builder->orlike('LOWER(dt_fakultas."fakultasWD2")', strtolower($keyword))->where('dt_fakultas.fakultasDeletedAt', null);
        $builder->orlike('LOWER(dt_fakultas."fakultasWD3")', strtolower($keyword))->where('dt_fakultas.fakultasDeletedAt', null);
        $builder->orderBy('dt_fakultas."fakultasId"', 'DESC');
        return $builder;
    }
}
