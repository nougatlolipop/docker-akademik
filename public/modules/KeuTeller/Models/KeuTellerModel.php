<?php


namespace Modules\KeuTeller\Models;

use CodeIgniter\Model;

class KeuTellerModel extends Model
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

    public function getTagihan($where)
    {
        $builder = $this->db->table("function_tampil_tagihan('" . $where[0] . "','" . $where[1] . "')");
        $builder->orderBy('tahap', 'asc');
        return $builder->get();
    }

    // public function getTagihanHer($where)
    // {
    //     $builder = $this->db->table("function_tampil_tagihan_her('" . $where[0] . "','" . $where[1] . "')");
    //     $builder->orderBy('tahap', 'asc');
    //     return $builder->get();
    // }

    public function callSetUbahMetodeBayar($init)
    {
        $builder = $this->db->query("CALL prosedur_set_lunas_bpp('" . $init[0] . "','" . $init[1] . "','" . $init[2] . "')");
        return $builder;
    }

    public function getJadwalLunas($where)
    {
        $builder = $this->db->table('function_tampil_tagihan_jadwal() jadwal');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahProdiId" = jadwal."jadwalTagihanProdiId" and setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"=jadwal."jadwalTagihanProgramKuliahId"', 'INNER');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa."mahasiswaAngkatan" = jadwal."jadwalTagihanAngkatan" and  dt_mahasiswa."mahasiswaProdiProgramKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahId"', 'LEFT');
        $builder->where($where);
        return $builder->get();
    }

    public function getPaymentMahasiswa($where)
    {
        $builder = $this->db->table("function_tampil_payment_all_mhs_tahun('" . $where[0] . "','" . $where[1] . "')");
        // $builder->where($where);
        return $builder->get();
    }

    public function callSetUbahIsForcePay($init)
    {
        $builder = $this->db->query("CALL prosedur_ubah_force_pay_lunas('" . $init[0] . "','" . $init[1] . "','" . $init[2] . "')");
        return $builder;
    }
}
