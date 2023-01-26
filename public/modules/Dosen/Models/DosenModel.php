<?php

namespace Modules\Dosen\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'dt_dosen';
    protected $primaryKey = 'dosenId';
    protected $allowedFields = [
        'dosenNip', 'dosenNIDN', 'dosenNama', 'dosenEmailGeneral', 'dosenNoHandphone', 'dosenAlamat', 'dosenSignature', 'dosenGelar', 'dosenTempatLahir', 'dosenTanggalLahir',
        'dosenJenisKelamin', 'dosenAgama', 'dosenGolDarah', 'dosenEmailCorporate', 'dosenNoNBM', 'dosenNoNPWP', 'dosenUsername', 'dosenPassword', 'dosenNUPTK', 'dosenNoSerdos',
        'dosenDokumenSerdos', 'dosenKecamatan', 'dosenProdiId', 'dosenNIK', 'dosenDokumenNBM', 'dosenDokumenNPWP', 'dosenDokumenKTP', 'dosenJenjangPendidikan', 'dosenPenghasilan',
        'dosenDokumenIjazah', 'dosenStatusDosen', 'dosenStatusNikah', 'dosenStatusAktif', 'dosenSertifikatKeahlian', 'dosenFoto', 'dosenCreatedBy', 'dosenCreatedDate', 'dosenModifiedBy',
        'dosenModifiedDate', 'dosenDeletedAt'
    ];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'dosenCreatedDate';
    protected $updatedField = 'dosenModifiedDate';
    protected $deletedField = 'dosenDeletedAt';

    public function getDosen()
    {
        $builder = $this->table('dt_dosen');
        $builder->orderBy('dt_dosen."dosenId"', 'DESC');
        return $builder;
    }

    public function getDosenSearch($keyword = null)
    {
        $builder = $this->table('dt_dosen');
        $builder->like('LOWER(dt_dosen."dosenNama")', strtolower($keyword))->where('dt_dosen.dosenDeletedAt', null);
        $builder->orderBy('dt_dosen."dosenId"', 'DESC');
        return $builder;
    }

    public function search($dosenId, $cariDosen)
    {
        $builder = $this->table('dt_dosen');
        $builder->like('LOWER(dt_dosen."dosenNama")', strtolower($cariDosen))->whereNotIn('dt_dosen.dosenId', $dosenId);
        $builder->orderBy('dt_dosen."dosenId"', 'DESC');
    }

    public function getWhereIn($where)
    {
        $builder = $this->table('dt_dosen');
        $builder->whereIn('dosenId', $where);
        return $builder;
    }

    public function searchDosen($where)
    {
        $builder = $this->table('dt_dosen');
        if ($where[1]) {
            $builder->like('LOWER(dt_dosen."dosenNama")', strtolower($where[0]))->whereNotIn('dt_dosen.dosenId', $where[1]);
            $builder->orLike('LOWER(dt_dosen."dosenGelarDepan")', strtolower($where[0]))->whereNotIn('dt_dosen.dosenId', $where[1]);
            $builder->orLike('LOWER(dt_dosen."dosenGelarBelakang")', strtolower($where[0]))->whereNotIn('dt_dosen.dosenId', $where[1]);
        } else {
            $builder->like('LOWER(dt_dosen."dosenNama")', strtolower($where[0]));
            $builder->orLike('LOWER(dt_dosen."dosenGelarDepan")', strtolower($where[0]));
            $builder->orLike('LOWER(dt_dosen."dosenGelarBelakang")', strtolower($where[0]));
        }
        $builder->limit($where[2], 0);
        return $builder;
    }
}
