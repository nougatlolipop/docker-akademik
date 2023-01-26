<?php

namespace Modules\KeuSaving\Models;

use CodeIgniter\Model;

class KeuSavingModel extends Model
{
    protected $table = 'keu_saving';
    protected $primaryKey = 'savingId';
    protected $allowedFields = ['savingNpm', 'savingDetail', 'savingModifiedBy', 'savingModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $updatedField = 'savingModifiedDate';

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

    public function getDataSaving($where)
    {
        $builder = $this->db->table('function_saving_all()');
        $builder->selectSum('savingNominal');
        $builder->where($where);
        return $builder->get();
    }

    public function insertSaving($where)
    {
        $this->db->query("CALL prosedur_saving_menu_admin('" . $where[0] . "','" . $where[1] . "','" . $where[2] . "')");
    }
}
