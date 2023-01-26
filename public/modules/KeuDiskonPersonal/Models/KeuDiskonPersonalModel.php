<?php


namespace Modules\KeuDiskonPersonal\Models;

use CodeIgniter\Model;

class KeuDiskonPersonalModel extends Model
{
    protected $table = 'keu_tagihan_personal';
    protected $primaryKey = 'tagihPersonalId';
    protected $allowedFields = ['tagihPersonalMahasiswaNpm', 'tagihPersonalJenisBiayaId', 'tagihPersonalTahun', 'tagihPersonalTahapLunas', 'tagihPersonalDiskonPersentase', 'tagihPersonalKeterangan', 'tagihPersonalCreatedBy', 'tagihPersonalCreatedDate', 'tagihPersonalModifiedBy', 'tagihPersonalModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'tagihPersonalCreatedDate';
    protected $updatedField = 'tagihPersonalModifiedDate';

    public function getDataMhs($where = null)
    {
        $builder = $this->db->table('dt_mahasiswa');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = dt_mahasiswa."mahasiswaProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"', 'LEFT');
        $builder->join('dt_fakultas', 'dt_fakultas."fakultasId" = dt_prodi."prodiFakultasId"', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah."waktuId" = setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', 'LEFT');
        if ($where) {
            $builder->where($where);
        }
        return $builder->get();
    }

    public function getDataTgh($where = null)
    {
        $builder = $this->db->table("function_tampil_tagihan('" . $where[0] . "','" . $where[1] . "')");
        $builder->orderBy('tahap', 'asc');
        return $builder->get();
    }
}
