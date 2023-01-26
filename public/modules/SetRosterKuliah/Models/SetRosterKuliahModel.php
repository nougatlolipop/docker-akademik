<?php

namespace Modules\SetRosterKuliah\Models;

use CodeIgniter\Model;

class SetRosterKuliahModel extends Model
{
    protected $table = 'setting_jadwal_kuliah';
    protected $primaryKey = 'setJadwalKuliahId';
    protected $allowedFields = ['setJadwalKuliahMatkulTawarId', 'setJadwalKuliahRefHariId', 'setJadwalKuliahJamMulai', 'setJadwalKuliahJamSelesai', 'setJadwalKuliahRuangId', 'setJadwalKuliahCreatedBy', 'setJadwalKuliahCreatedDate', 'setJadwalKuliahModifiedBy', 'setJadwalKuliahModifiedDate', 'setJadwalKuliahIsAktif'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'setJadwalKuliahCreatedDate';
    protected $updatedField = 'setJadwalKuliahModifiedDate';

    function getRosterKuliahWhere($where = null)
    {
        $builder = $this->table('setting_jadwal_kuliah');
        $builder->join('setting_matkul_tawarkan', 'setting_matkul_tawarkan.setMatkulTawarId = setting_jadwal_kuliah.setJadwalKuliahMatkulTawarId', 'LEFT');
        $builder->join('ref_hari', 'ref_hari.refHariId = setting_jadwal_kuliah.setJadwalKuliahRefHariId', 'LEFT');
        $builder->join('dt_ruangan', 'dt_ruangan.ruangId = setting_jadwal_kuliah.setJadwalKuliahRuangId', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = setting_matkul_tawarkan."setMatkulTawarProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_kelas', 'dt_kelas."kelasId" = setting_matkul_tawarkan."setMatkulTawarKelasId"', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah."waktuId" = setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', 'LEFT');
        $builder->join('dt_tahun_ajaran', 'dt_tahun_ajaran.tahunAjaranId = setting_matkul_tawarkan.setMatkulTawarTahunAjaranId', 'LEFT');
        $builder->join('dt_dosen', 'dt_dosen.dosenId = setting_matkul_tawarkan.setMatkulTawarDosenId', 'LEFT');
        $builder->join('setting_matkul_kurikulum', 'setting_matkul_kurikulum.setMatkulKurikulumId = setting_matkul_tawarkan.setMatkulTawarMatkulKurikulumId', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan.setKurikulumTawarId = setting_matkul_kurikulum.setMatkulKurikulumKurikulumTawarId', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_kurikulum_tawarkan.setKurikulumTawarProdiId', 'LEFT');
        if ($where) {
            $builder->where($where);
        }
        $builder->orderBy('setting_jadwal_kuliah.setJadwalKuliahId', 'ASC');
        return $builder;
    }

    public function dataExist($where, $jamMulai, $jamSelesai)
    {
        $jamMulai = "'" . $jamMulai . "'";
        $jamSelesai = "'" . $jamSelesai . "'";
        $builder = $this->table('setting_jadwal_kuliah');
        $builder->join('setting_matkul_tawarkan', 'setting_matkul_tawarkan."setMatkulTawarId"= setting_jadwal_kuliah."setJadwalKuliahMatkulTawarId"', 'LEFT');
        $builder->where($where);
        $builder->where('setting_jadwal_kuliah."setJadwalKuliahJamMulai" BETWEEN ' . $jamMulai . ' AND ' . $jamSelesai);
        $builder->orWhere('setting_jadwal_kuliah."setJadwalKuliahJamSelesai" BETWEEN ' . $jamMulai . ' AND ' . $jamSelesai);
        $query = $builder->countAllResults();
        return $query;
    }

    public function getWhere($where)
    {
        $builder = $this->table('setting_jadwal_kuliah');
        $builder->join('ref_hari', 'ref_hari.refHariId = setting_jadwal_kuliah.setJadwalKuliahRefHariId', 'LEFT');
        $builder->join('dt_ruangan', 'dt_ruangan.ruangId = setting_jadwal_kuliah.setJadwalKuliahRuangId', 'LEFT');
        $builder->where($where);
        $builder->orderBy('setting_jadwal_kuliah.setJadwalKuliahRefHariId', 'ASC');
        return $builder;
    }
}
