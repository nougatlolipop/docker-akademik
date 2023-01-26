<?php

namespace Modules\Ruangan\Models;

use CodeIgniter\Model;

class RuanganModel extends Model
{
    protected $table = 'dt_ruangan';
    protected $primaryKey = 'ruangId';
    protected $allowedFields = ['ruangKode', 'ruangNama', 'ruangGedungId', 'ruangKelompokId', 'ruangDeskripsi', 'ruangKapasitas', 'ruangAkronim', 'ruangIsAktif', 'ruangCreatedBy', 'ruangCreatedDate', 'ruangModifiedBy', 'ruangModifiedDate', 'ruangDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'ruangCreatedDate';
    protected $updatedField = 'ruangModifiedDate';
    protected $deletedField = 'ruangDeletedAt';

    public function getRuangan()
    {
        $builder = $this->table('dt_ruangan');
        $builder->join('ref_gedung', 'ref_gedung.refGedungId = dt_ruangan.ruangGedungId');
        $builder->join('dt_kelompok_kuliah', 'dt_kelompok_kuliah.kelompokKuliahId = dt_ruangan.ruangKelompokId');
        $builder->orderBy('dt_ruangan.ruangId', 'DESC');
        return $builder;
    }

    public function getRuanganSearch($keyword = null)
    {
        $builder = $this->table('dt_ruangan');
        $builder->join('ref_gedung', 'ref_gedung.refGedungId = dt_ruangan.ruangGedungId');
        $builder->join('dt_kelompok_kuliah', 'dt_kelompok_kuliah.kelompokKuliahId = dt_ruangan.ruangKelompokId');
        $builder->like('LOWER(dt_ruangan."ruanganKode")', strtolower($keyword))->where('dt_ruangan.ruangDeletedAt', null);
        $builder->orlike('LOWER(ref_gedung."refGedungNama")', strtolower($keyword))->where('dt_ruangan.ruangDeletedAt', null);
        $builder->orlike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($keyword))->where('dt_ruangan.ruangDeletedAt', null);
        $builder->orlike('LOWER(dt_ruangan."ruangNama")', strtolower($keyword))->where('dt_ruangan.ruangDeletedAt', null);
        $builder->orlike('LOWER(dt_ruangan."ruangDeskripsi")', strtolower($keyword))->where('dt_ruangan.ruangDeletedAt', null);
        $builder->orderBy('dt_ruangan.ruangId', 'DESC');
        return $builder;
    }

    public function getRuanganGedung()
    {
        $builder = $this->table('dt_ruangan');
        $builder->join('ref_gedung', 'ref_gedung.refGedungId = dt_ruangan.ruangGedungId');
        return $builder;
    }

    public function getGedung()
    {
        $builder = $this->db->table('ref_gedung');
        return $builder->get()->getResult();
    }
}
