<?php

namespace Modules\SetMatkulKurikulum\Models;

use CodeIgniter\Model;

class SetMatkulKurikulumModel extends Model
{
    protected $table = 'setting_matkul_kurikulum';
    protected $primaryKey = 'setMatkulKurikulumId';
    protected $allowedFields = ['setMatkulKurikulumKurikulumTawarId', 'setMatkulKurikulumMatkulId', 'setMatkulKurikulumMatkulGroupId', 'setMatkulKurikulumStudiLevelId', 'setMatkulKurikulumSks', 'setMatkulKurikulumIsTranskrip', 'setMatkulKurikulumIsAktif', 'setMatkulKurikulumCreatedBy', 'setMatkulKurikulumCreatedDate', 'setMatkulKurikulumModifiedBy', 'setMatkulKurikulumModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'setMatkulKurikulumCreatedDate';
    protected $updatedField = 'setMatkulKurikulumModifiedDate';

    public function getSetMatkulKurikulum($where = null, $fakultas = null)
    {
        $builder = $this->table('setting_matkul_kurikulum');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan.setKurikulumTawarId = setting_matkul_kurikulum.setMatkulKurikulumKurikulumTawarId', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_kurikulum_tawarkan.setKurikulumTawarProdiId', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah.programKuliahId = setting_kurikulum_tawarkan.setKurikulumTawarProgramKuliahId', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum.kurikulumId = setting_kurikulum_tawarkan.setKurikulumTawarKurikulumId', 'LEFT');
        $builder->join('dt_matkul', 'dt_matkul.matkulId = setting_matkul_kurikulum.setMatkulKurikulumMatkulId', 'LEFT');
        $builder->join('dt_matkul_group', 'dt_matkul_group.matkulGroupId = setting_matkul_kurikulum.setMatkulKurikulumMatkulGroupId', 'LEFT');
        $builder->join('dt_studi_level', 'dt_studi_level.studiLevelId = setting_matkul_kurikulum.setMatkulKurikulumStudiLevelId', 'LEFT');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if ($where) {
            if (isset($where['setMatkulKurikulumId'])) {
                $builder->where('setting_matkul_kurikulum.setMatkulKurikulumId', $where['setMatkulKurikulumId']);
            }
            if (isset($where['program_kuliah'])) {
                $builder->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                }
            }
            if (isset($where['prodi'])) {
                $builder->whereIn('dt_prodi.prodiId', $where['prodi']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                    $builder->orLike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                    $builder->orLike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                    $builder->orLike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                    $builder->orLike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                }
            }
            if (isset($where['kurikulum'])) {
                $builder->where('dt_kurikulum.kurikulumId', $where['kurikulum']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('dt_kurikulum.kurikulumId', $where['kurikulum']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('dt_kurikulum.kurikulumId', $where['kurikulum']);
                    $builder->orLike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->where('dt_kurikulum.kurikulumId', $where['kurikulum']);
                    $builder->orLike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->where('dt_kurikulum.kurikulumId', $where['kurikulum']);
                    $builder->orLike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($where['keyword']))->where('dt_kurikulum.kurikulumId', $where['kurikulum']);
                    $builder->orLike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->where('dt_kurikulum.kurikulumId', $where['kurikulum']);
                }
            }
            if (!isset($where['program_kuliah']) && !isset($where['prodi']) && !isset($where['kurikulum'])) {
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_matkul_group."matkulGroupNama")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']));
                }
            }
        }
        $builder->orderBy('setting_matkul_kurikulum.setMatkulKurikulumId', 'DESC');
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('setting_matkul_kurikulum');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }

    public function getMatkulGroup()
    {
        $builder = $this->db->table('dt_matkul_group');
        $builder->orderBy('dt_matkul_group.matkulGroupId', 'DESC');
        return $builder;
    }

    public function matkulKurikulumAkademik($where, $whereIn)
    {
        $builder = $this->table('setting_matkul_kurikulum');
        $builder->join('dt_matkul', 'dt_matkul."matkulId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulId"', 'LEFT');
        $builder->join('dt_matkul_group', 'dt_matkul_group."matkulGroupId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulGroupId"', 'LEFT');
        $builder->join('dt_studi_level', 'dt_studi_level."studiLevelId" = setting_matkul_kurikulum."setMatkulKurikulumStudiLevelId"', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarId" = setting_matkul_kurikulum."setMatkulKurikulumKurikulumTawarId"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum."kurikulumId" = setting_kurikulum_tawarkan."setKurikulumTawarKurikulumId"', 'LEFT');
        $builder->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', $whereIn);
        $builder->where($where);
        $builder->orderBy('setting_matkul_kurikulum."setMatkulKurikulumId"', 'DESC');
        return $builder;
    }

    public function matkulKurikulumPratikum($where, $whereIn)
    {
        $builder = $this->table('setting_matkul_kurikulum');
        $builder->join('dt_matkul', 'dt_matkul."matkulId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulId"', 'LEFT');
        $builder->join('dt_matkul_type', 'dt_matkul_type."matkulTypeId" = dt_matkul."matkulTypeId"', 'LEFT');
        $builder->join('dt_matkul_group', 'dt_matkul_group."matkulGroupId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulGroupId"', 'LEFT');
        $builder->join('dt_studi_level', 'dt_studi_level."studiLevelId" = setting_matkul_kurikulum."setMatkulKurikulumStudiLevelId"', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarId" = setting_matkul_kurikulum."setMatkulKurikulumKurikulumTawarId"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum."kurikulumId" = setting_kurikulum_tawarkan."setKurikulumTawarKurikulumId"', 'LEFT');
        $builder->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', $whereIn);
        $builder->where($where);
        $builder->orderBy('setting_matkul_kurikulum."setMatkulKurikulumId"', 'DESC');
        return $builder;
    }

    public function matkulTranskrip($where)
    {
        $builder = $this->table('setting_matkul_kurikulum');
        $builder->select('dt_matkul."matkulId",dt_studi_level."studiLevelId",dt_matkul_group."matkulGroupId"');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarId" = setting_matkul_kurikulum."setMatkulKurikulumKurikulumTawarId"', 'LEFT');
        $builder->join('dt_matkul', 'dt_matkul."matkulId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulId"', 'LEFT');
        $builder->join('dt_matkul_group', 'dt_matkul_group."matkulGroupId" = setting_matkul_kurikulum."setMatkulKurikulumMatkulGroupId"', 'LEFT');
        $builder->join('dt_studi_level', 'dt_studi_level."studiLevelId" = setting_matkul_kurikulum."setMatkulKurikulumStudiLevelId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahProdiId" = setting_kurikulum_tawarkan."setKurikulumTawarProdiId" AND setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId" = setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', 'LEFT');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa."mahasiswaProdiProgramKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahId" AND dt_mahasiswa."mahasiswaAngkatan" = setting_kurikulum_tawarkan."setKurikulumTawarAngkatan"', 'LEFT');
        $builder->where($where);
        $builder->orderBy('dt_studi_level."studiLevelId"', 'ASC');
        return $builder;
    }
}
