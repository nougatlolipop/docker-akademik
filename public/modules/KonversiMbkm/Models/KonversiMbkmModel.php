<?php


namespace Modules\KonversiMbkm\Models;

use CodeIgniter\Model;

class KonversiMbkmModel extends Model
{
    protected $table = 'akd_konversi_nilai';
    protected $primaryKey = 'konversiNilaiId';
    protected $allowedFields = ['konversiNilaiMahasiswaNpm', 'konversiNilaiTahunAjaranId', 'konversiNilaiMatkulOld', 'konversiNilaiMatkulNew', 'konversiNilaiKurikulumTawarId', 'konversiNilaiCreatedBy', 'konversiNilaiCreatedDate', 'konversiNilaiModifiedBy', 'konversiNilaiModifiedDate', 'konversiNilaiJenisKonversiId'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'konversiNilaiCreatedDate';
    protected $updatedField = 'konversiNilaiModifiedDate';
}
