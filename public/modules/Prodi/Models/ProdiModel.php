<?php

namespace Modules\Prodi\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table = 'dt_prodi';
    protected $primaryKey = 'prodiId';
    protected $allowedFields = ['prodiKode', 'prodiNama', 'prodiAcronym', 'prodiFakultasId', 'prodiWebsite', 'prodiEmail', 'prodiNoTelp', 'prodiNomorSKDikti', 'prodiStartDateSKDikti', 'prodiEndDateSKDikti', 'prodiGelarLulus', 'prodiIsAktif', 'prodiKaprodi', 'prodiWaKaprodi', 'prodiSekretaris', 'prodiBendahara', 'prodiGedungId', 'prodiCreatedBy', 'prodiCreatedDate', 'prodiModifiedBy', 'prodiModifiedDate', 'prodiDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';
    protected $useTimestamps = 'true';
    protected $createdField = 'prodiCreatedDate';
    protected $updatedField = 'prodiModifiedDate';
    protected $deletedField = 'prodiDeletedAt';

    public function getProdiForKrs()
    {
        $builder = $this->table('dt_prodi');
        $builder->join('dt_fakultas', 'dt_fakultas.fakultasId = dt_prodi.prodiFakultasId', 'LEFT');
        $builder->join('ref_gedung', 'ref_gedung.refGedungId = dt_prodi.prodiGedungId', 'LEFT');
        $builder->join('ref_jenjang_pendidikan', 'ref_jenjang_pendidikan.refJenjangId = dt_prodi.prodiJenjangId', 'LEFT');
        $builder->whereNotIn('dt_fakultas.fakultasKode', ['99', '12']);
        $builder->whereNotIn('dt_prodi.prodiKode', ['999', '100', '101', '102', '103', '104', '105']);
        return $builder;
    }

    public function getProdi($fakultas = null, $keyword = null)
    {
        $builder = $this->table('dt_prodi');
        $builder->join('dt_fakultas', 'dt_fakultas.fakultasId = dt_prodi.prodiFakultasId', 'LEFT');
        $builder->join('ref_gedung', 'ref_gedung.refGedungId = dt_prodi.prodiGedungId', 'LEFT');
        $builder->join('ref_jenjang_pendidikan', 'ref_jenjang_pendidikan.refJenjangId = dt_prodi.prodiJenjangId', 'LEFT');
        $builder->whereNotIn('dt_prodi.prodiKode', ['999', '100', '101', '102', '103', '104', '105']);
        if ($fakultas) {
            if ($keyword) {
                $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null)->where($fakultas);
                $builder->orlike('LOWER(dt_prodi."prodiKode")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null)->where($fakultas);
                $builder->orlike('LOWER(dt_prodi."prodiAcronym")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null)->where($fakultas);
                $builder->orlike('LOWER(dt_fakultas."fakultasNama")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null)->where($fakultas);
                $builder->orlike('LOWER(ref_jenjang_pendidikan."refJenjangNama")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null)->where($fakultas);
            } else {
                $builder->where($fakultas);
            }
        } else {
            if ($keyword) {
                $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null);
                $builder->orlike('LOWER(dt_prodi."prodiKode")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null);
                $builder->orlike('LOWER(dt_prodi."prodiAcronym")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null);
                $builder->orlike('LOWER(dt_fakultas."fakultasNama")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null);
                $builder->orlike('LOWER(ref_jenjang_pendidikan."refJenjangNama")', strtolower($keyword))->where('dt_prodi.prodiDeletedAt', null);
            }
        }
        $builder->orderBy('dt_fakultas.fakultasId');
        return $builder;
    }

    public function getProdiDetail($where)
    {
        $builder = $this->table('dt_prodi');
        $builder->where($where);
        return $builder;
    }
}
