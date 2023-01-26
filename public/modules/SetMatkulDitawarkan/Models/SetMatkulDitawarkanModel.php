<?php

namespace Modules\SetMatkulDitawarkan\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\RawSql;

class SetMatkulDitawarkanModel extends Model
{
    protected $table = 'setting_matkul_tawarkan';
    protected $primaryKey = 'setMatkulTawarId';
    protected $allowedFields = ['setMatkulTawarTahunAjaranId', 'setMatkulTawarKuotaKelas', 'setMatkulTawarDosenId', 'setMatkulTawarDosen', 'setMatkulTawarMatkulKurikulumId', 'setMatkulTawarProdiProgramKuliahId', 'setMatkulTawarKelasId', 'setMatkulTawarKelasTerpakai', 'setMatkulTawarSemuaKelas', 'setMatkulTawarIsAktif', 'setMatkulTawarCreatedBy', 'setMatkulTawarCreatedDate', 'setMatkulTawarModifiedBy', 'setMatkulTawarModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'setMatkulTawarCreatedDate';
    protected $updatedField = 'setMatkulTawarModifiedDate';

    public function getMatkultawar($where = null, $fakultas = null)
    {
        $builder = $this->table('setting_matkul_tawarkan');
        $builder->join('dt_tahun_ajaran', 'dt_tahun_ajaran."tahunAjaranId" = setting_matkul_tawarkan."setMatkulTawarTahunAjaranId"', 'LEFT');
        $builder->join('setting_matkul_kurikulum', 'setting_matkul_kurikulum."setMatkulKurikulumId" = setting_matkul_tawarkan."setMatkulTawarMatkulKurikulumId"', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarId" = setting_matkul_kurikulum."setMatkulKurikulumKurikulumTawarId"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum."kurikulumId" = setting_kurikulum_tawarkan."setKurikulumTawarKurikulumId"', 'LEFT');
        $builder->join('dt_matkul', 'dt_matkul."matkulId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulId"', 'LEFT');
        $builder->join('dt_matkul_group', 'dt_matkul_group."matkulGroupId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulGroupId"', 'LEFT');
        $builder->join('dt_studi_level', 'dt_studi_level."studiLevelId" = setting_matkul_kurikulum."setMatkulKurikulumStudiLevelId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = setting_matkul_tawarkan."setMatkulTawarProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_kelas', 'dt_kelas."kelasId" = setting_matkul_tawarkan."setMatkulTawarKelasId"', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah."waktuId" = setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', 'LEFT');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if ($where) {
            if (isset($where['matkul_tawar_id'])) {
                $builder->where('setting_matkul_tawarkan."setMatkulTawarId"', $where['matkul_tawar_id']);
            }
            if (isset($where['program_kuliah'])) {
                $builder->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_kelas."kelasKode")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                }
            }
            if (isset($where['prodi'])) {
                $builder->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_kelas."kelasKode")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                }
            }
            if (isset($where['tahunAjar'])) {
                $builder->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                    $builder->orlike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                    $builder->orlike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                    $builder->orlike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                    $builder->orlike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                    $builder->orlike('LOWER(dt_kelas."kelasKode")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                    $builder->orlike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                }
            }
            if (isset($where['waktuKuliah'])) {
                $builder->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                    $builder->orlike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                    $builder->orlike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                    $builder->orlike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                    $builder->orlike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                    $builder->orlike('LOWER(dt_kelas."kelasKode")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                    $builder->orlike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                }
            }
            if (!isset($where['program_kuliah']) && !isset($where['prodi']) && !isset($where['tahunAjar']) && !isset($where['waktuKuliah'])) {
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_kelas."kelasKode")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($where['keyword']));
                }
            }
        }
        $builder->orderBy('setting_matkul_tawarkan.setMatkulTawarId', 'DESC');
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('setting_matkul_tawarkan');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }

    public function getSetMatkulDitawarkanKonversi($where = null)
    {
        $builder = $this->table('setting_matkul_tawarkan');
        $builder->join('setting_matkul_kurikulum', 'setting_matkul_kurikulum."setMatkulKurikulumId" = setting_matkul_tawarkan."setMatkulTawarMatkulKurikulumId"', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarId" = setting_matkul_kurikulum."setMatkulKurikulumKurikulumTawarId"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = setting_matkul_tawarkan."setMatkulTawarProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum."kurikulumId" = setting_kurikulum_tawarkan."setKurikulumTawarKurikulumId"', 'LEFT');
        $builder->join('dt_matkul', 'dt_matkul."matkulId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulId"', 'LEFT');
        $builder->join('dt_matkul_group', 'dt_matkul_group."matkulGroupId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulGroupId"', 'LEFT');
        if ($where != null) {
            $builder->where($where);
        }
        $builder->orderBy('setting_matkul_tawarkan.setMatkulTawarId', 'DESC');
        return $builder;
    }

    public function cariMatkulDitawarkan($initInfo, $allow = null)
    {
        $builder = $this->table('setting_matkul_tawarkan');
        $builder->join('dt_tahun_ajaran', 'dt_tahun_ajaran.tahunAjaranId = setting_matkul_tawarkan.setMatkulTawarTahunAjaranId', 'LEFT');
        $builder->join('setting_matkul_kurikulum', 'setting_matkul_kurikulum.setMatkulKurikulumId = setting_matkul_tawarkan.setMatkulTawarMatkulKurikulumId', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah.setProdiProgramKuliahId = setting_matkul_tawarkan.setMatkulTawarProdiProgramKuliahId', 'LEFT');
        $builder->join('dt_dosen', 'dt_dosen.dosenId = setting_matkul_tawarkan.setMatkulTawarDosenId', 'LEFT');
        $builder->join('dt_matkul', 'dt_matkul.matkulId = setting_matkul_kurikulum.setMatkulKurikulumMatkulId', 'LEFT');
        $builder->join('dt_matkul_type', 'dt_matkul_type.matkulTypeId = dt_matkul.matkulTypeId', 'LEFT');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa.mahasiswaProdiProgramKuliahId = setting_prodi_program_kuliah.setProdiProgramKuliahId', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_prodi_program_kuliah.setProdiProgramKuliahProdiId', 'LEFT');
        $builder->join('dt_kelas', 'dt_kelas.kelasId = setting_matkul_tawarkan.setMatkulTawarKelasId', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah.waktuId = setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan.setKurikulumTawarId = setting_matkul_kurikulum.setMatkulKurikulumKurikulumTawarId', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum.kurikulumId = setting_kurikulum_tawarkan.setKurikulumTawarKurikulumId', 'LEFT');
        $builder->where('dt_mahasiswa.mahasiswaNpm', $initInfo[0])->where('setting_matkul_tawarkan.setMatkulTawarKelasId', $initInfo[1])->where('setting_matkul_tawarkan.setMatkulTawarSemuaKelas', '0')->where('dt_tahun_ajaran.tahunAjaranId', $initInfo[2]);
        if ($allow != null) {
            if ($allow) {
                $builder->orWhere('dt_mahasiswa.mahasiswaNpm', $initInfo[0])->where('setting_matkul_tawarkan.setMatkulTawarSemuaKelas', '1')->where('dt_tahun_ajaran.tahunAjaranId', $initInfo[2]);
            }
        }
        return $builder;
    }

    public function getKrsDetail($where)
    {
        $query = new RawSql('LATERAL JSON_ARRAY_ELEMENTS ( setting_matkul_tawarkan."setMatkulTawarDosen" -> \'data\' ) json_line_item LEFT JOIN dt_dosen on dt_dosen."dosenId" = (json_line_item->>\'id\')::int');
        $builder = $this->table('setting_matkul_tawarkan');
        $builder->join('setting_matkul_kurikulum', 'setting_matkul_kurikulum."setMatkulKurikulumId" = setting_matkul_tawarkan."setMatkulTawarMatkulKurikulumId"', 'LEFT');
        $builder->join('setting_jadwal_kuliah', 'setting_jadwal_kuliah."setJadwalKuliahMatkulTawarId" = setting_matkul_tawarkan."setMatkulTawarId"', 'LEFT');
        $builder->join('ref_hari', 'ref_hari."refHariId" = setting_jadwal_kuliah."setJadwalKuliahRefHariId"', 'LEFT');
        $builder->join('dt_ruangan', 'dt_ruangan."ruangId" = setting_jadwal_kuliah."setJadwalKuliahRuangId"', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarId" = setting_matkul_kurikulum."setMatkulKurikulumKurikulumTawarId"', 'LEFT');
        $builder->join('dt_matkul_group', 'dt_matkul_group."matkulGroupId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulGroupId"', 'LEFT');
        $builder->join('dt_studi_level', 'dt_studi_level."studiLevelId" = setting_matkul_kurikulum."setMatkulKurikulumStudiLevelId"', 'LEFT');
        $builder->join('dt_matkul', 'dt_matkul."matkulId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulId", ' . $query, 'LEFT');
        $builder->where($where);
        return $builder;
    }


    public function maktulTranskrip($where)
    {
        $builder = $this->table('setting_matkul_tawarkan');
        $builder->select('dt_matkul."matkulId",dt_studi_level."studiLevelId",dt_matkul_group."matkulGroupId');
        $builder->join('setting_matkul_kurikulum', 'setting_matkul_kurikulum."setMatkulKurikulumId" = setting_matkul_tawarkan."setMatkulTawarMatkulKurikulumId"', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarId" = setting_matkul_kurikulum."setMatkulKurikulumKurikulumTawarId"', 'LEFT');
        $builder->join('dt_studi_level', 'dt_studi_level."studiLevelId" = setting_matkul_kurikulum."setMatkulKurikulumStudiLevelId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = setting_matkul_tawarkan."setMatkulTawarProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum."kurikulumId" = setting_kurikulum_tawarkan."setKurikulumTawarKurikulumId"', 'LEFT');
        $builder->join('dt_matkul', 'dt_matkul."matkulId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulId"', 'LEFT');
        $builder->join('dt_matkul_group', 'dt_matkul_group."matkulGroupId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulGroupId"', 'LEFT');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa."mahasiswaProdiProgramKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahId" AND dt_mahasiswa."mahasiswaKelasId" = setting_matkul_tawarkan."setMatkulTawarKelasId"', 'INNER');
        $builder->where($where);
        $builder->groupBy('dt_matkul."matkulId",dt_studi_level."studiLevelId",dt_matkul_group."matkulGroupId');
        $builder->orderBy('dt_studi_level."studiLevelId"', 'ASC');
        return $builder;
    }

    public function cariMahasiswaDitawarkan($where)
    {
        $builder = $this->table('setting_matkul_tawarkan');
        $builder->join('setting_matkul_kurikulum', 'setting_matkul_kurikulum."setMatkulKurikulumId" = setting_matkul_tawarkan."setMatkulTawarMatkulKurikulumId"', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarId" = setting_matkul_kurikulum."setMatkulKurikulumKurikulumTawarId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = setting_matkul_tawarkan."setMatkulTawarProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_matkul', 'dt_matkul."matkulId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulId"', 'LEFT');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa."mahasiswaProdiProgramKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahId"', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function getMatkulTawarPrak($where)
    {
        $builder = $this->table('setting_matkul_tawarkan');
        $builder->where($where);
        return $builder;
    }

    public function getAllowAkselarasi($npm)
    {
        $builder = $this->db->table("function_tampil_study_level_ipk('" . $npm . "')");
        return $builder->get();
    }

    public function matkulTawarKrs($where)
    {
    }
}
