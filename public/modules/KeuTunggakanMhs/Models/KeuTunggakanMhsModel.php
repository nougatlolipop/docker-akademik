<?php


namespace Modules\KeuTunggakanMhs\Models;

use CodeIgniter\Model;

class KeuTunggakanMhsModel extends Model
{

    public function getDataMhs($where = null)
    {
        $builder = $this->db->table('dt_mahasiswa');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = dt_mahasiswa."mahasiswaProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"', 'LEFT');
        $builder->join('dt_fakultas', 'dt_fakultas."fakultasId" = dt_prodi."prodiFakultasId"', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah."waktuId" = setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', 'LEFT');
        $builder->join('dt_rule_keuangan', 'dt_rule_keuangan."ruleKeuanganId" = dt_program_kuliah."programKuliahRuleKeuanganId"', 'LEFT');
        if ($where) {
            $builder->where($where);
        }
        return $builder->get();
    }

    public function getTunggakanMhs($where)
    {
        $builder = $this->db->table("function_tampil_tagihan('" . $where[0] . "','" . $where[1] . "')");
        return $builder->get();
    }
}
