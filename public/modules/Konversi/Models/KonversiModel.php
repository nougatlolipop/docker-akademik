<?php


namespace Modules\Konversi\Models;

use CodeIgniter\Model;

class KonversiModel extends Model
{
    protected $table = 'akd_konversi_nilai';
    protected $primaryKey = 'konversiNilaiId';
    protected $allowedFields = ['konversiNilaiMahasiswaNpm', 'konversiNilaiTahunAjaranId', 'konversiNilaiMatkulOld', 'konversiNilaiMatkulNew', 'konversiNilaiJenisKonversiId', 'konversiNilaiKurikulumTawarId', 'konversiNilaiCreatedBy', 'konversiNilaiCreatedDate', 'konversiNilaiModifiedBy', 'konversiNilaiModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'konversiNilaiCreatedDate';
    protected $updatedField = 'konversiNilaiModifiedDate';

    public function cariKonversi($where)
    {
        $builder = $this->table('akd_konversi_nilai');
        $builder->where($where);
        return $builder;
    }
}
