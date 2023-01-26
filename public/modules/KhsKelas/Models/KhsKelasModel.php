<?php

namespace Modules\KhsKelas\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder;

class KhsKelasModel extends Model
{
    protected $table = 'akd_khs';
    protected $primaryKey = 'khsId';
    protected $allowedFields = ['khsMahasiswaNpm', 'khsTahunAjaranId', 'khsNilaiMatkul', 'khsCreatedBy', 'khsCreatedDate', 'khsModifiedBy', 'khsModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'khsCreatedDate';
    protected $updatedField = 'khsModifiedDate';

    public function getTakenKrs($where)
    {
        $builder = $this->table('akd_khs');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa.mahasiswaNpm = akd_khs.khsMahasiswaNpm', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah.setProdiProgramKuliahId = dt_mahasiswa.mahasiswaProdiProgramKuliahId', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah.programKuliahId = setting_prodi_program_kuliah.setProdiProgramKuliahProgramKuliahId', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_prodi_program_kuliah.setProdiProgramKuliahProdiId', 'LEFT');
        $builder->where($where);
        return $builder;
    }
}
