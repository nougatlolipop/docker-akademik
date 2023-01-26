<?php

namespace Modules\KeuTarifTambahan\Models;

use CodeIgniter\Model;

class KeuTarifTambahanModel extends Model
{
    protected $table = 'keu_tarif_biaya_lain';
    protected $primaryKey = 'tarifLainId';
    protected $allowedFields = ['tarifLainProdiId', 'tarifLainKelompokKuliahId', 'tarifLainSemester', 'tarifLainKodeBayar', 'tarifLainJenisBiayaId', 'tarifLainMatkulTawarId', 'tarifLainIncludeTahap', 'tarifLainNominal', 'tarifLainIsAllowedAmount', 'tarifLainDeskripsi', 'tarifLainCreatedBy', 'tarifLainCreatedDate', 'tarifLainModifiedBy', 'tarifLainModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'tarifLainCreatedDate';
    protected $updatedField = 'tarifLainModifiedDate';

    public function getKeuTarifTambahan($where = null, $fakultas = null)
    {
        $builder = $this->table($this->table);
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = ' . $this->table . '."tarifLainProdiId"', 'LEFT');
        $builder->join('dt_kelompok_kuliah', 'dt_kelompok_kuliah."kelompokKuliahId" = ' . $this->table . '."tarifLainKelompokKuliahId"', 'LEFT');
        $builder->join('ref_jenis_biaya', 'ref_jenis_biaya."refJenisBiayaId" = ' . $this->table . '."tarifLainJenisBiayaId"', 'LEFT');
        $builder->join('setting_matkul_tawarkan', 'setting_matkul_tawarkan."setMatkulTawarId" = ' . $this->table . '."tarifLainMatkulTawarId"', 'LEFT');
        $builder->join('setting_matkul_kurikulum', 'setting_matkul_kurikulum."setMatkulKurikulumId" =  setting_matkul_tawarkan ."setMatkulTawarMatkulKurikulumId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" =  setting_matkul_tawarkan ."setMatkulTawarProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah."waktuId" =  setting_prodi_program_kuliah ."setProdiProgramKuliahWaktuKuliahId"', 'LEFT');
        $builder->join('dt_kelas', 'dt_kelas."kelasId" =  setting_matkul_tawarkan ."setMatkulTawarKelasId"', 'LEFT');
        $builder->join('dt_studi_level', 'dt_studi_level."studiLevelId" =  setting_matkul_kurikulum ."setMatkulKurikulumStudiLevelId"', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarId" = setting_matkul_kurikulum."setMatkulKurikulumKurikulumTawarId"', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum."kurikulumId" = setting_kurikulum_tawarkan."setKurikulumTawarKurikulumId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', 'LEFT');
        $builder->join('dt_matkul', 'dt_matkul."matkulId" =  setting_matkul_kurikulum."setMatkulKurikulumMatkulId"', 'LEFT');
        $builder->join('dt_matkul_group', 'dt_matkul_group."matkulGroupId" =  setting_matkul_kurikulum."setMatkulKurikulumMatkulGroupId"', 'LEFT');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if (isset($where['kelKuliah'])) {
            $builder->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
                $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']))->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
                $builder->orLike('LOWER(ref_jenis_biaya."refJenisBiayaNama")', strtolower($where['keyword']))->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
                $builder->orLike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
                $builder->orLike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
                $builder->orLike('LOWER(dt_matkul_group."matkulGroupKode")', strtolower($where['keyword']))->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
                $builder->orLike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
                $builder->orLike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']))->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
                $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->where('dt_kelompok_kuliah."kelompokKuliahId"', $where['kelKuliah']);
            }
        }
        if (isset($where['prodi'])) {
            if ($where['prodi'] != in_array('99', $where['prodi'])) {
                // $where['prodi'][] = null;
                $builder->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                    $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']))->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                    $builder->orLike('LOWER(ref_jenis_biaya."refJenisBiayaNama")', strtolower($where['keyword']))->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                    $builder->orLike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                    $builder->orLike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                    $builder->orLike('LOWER(dt_matkul_group."matkulGroupKode")', strtolower($where['keyword']))->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                    $builder->orLike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                    $builder->orLike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']))->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                    $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->whereIn($this->table . '."tarifLainProdiId"', $where['prodi']);
                }
            }
        }
        if (isset($where['program_kuliah'])) {
            $builder->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                $builder->orLike('LOWER(ref_jenis_biaya."refJenisBiayaNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                $builder->orLike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                $builder->orLike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                $builder->orLike('LOWER(dt_matkul_group."matkulGroupKode")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                $builder->orLike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                $builder->orLike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
            }
        }
        if (isset($where['jenisBiaya'])) {
            $builder->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
                $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']))->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
                $builder->orLike('LOWER(ref_jenis_biaya."refJenisBiayaNama")', strtolower($where['keyword']))->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
                $builder->orLike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']))->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
                $builder->orLike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']))->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
                $builder->orLike('LOWER(dt_matkul_group."matkulGroupKode")', strtolower($where['keyword']))->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
                $builder->orLike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
                $builder->orLike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']))->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
                $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->whereIn('ref_jenis_biaya."refJenisBiayaId"', $where['jenisBiaya']);
            }
        }
        if ($where['tambahan']) {
            $builder->whereIn('ref_jenis_biaya."refJenisBiayaTagihanTypeId"', $where['tambahan']);
            $builder->orWhereIn('ref_jenis_biaya."refJenisBiayaTagihanTypeId"', $where['tambahan'])->where($this->table . '."tarifLainProdiId"', null);
        }
        if (!isset($where['kelKuliah']) && !isset($where['prodi']) && !isset($where['program_kuliah']) && !isset($where['jenisBiaya'])) {
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']));
                $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']));
                $builder->orLike('LOWER(ref_jenis_biaya."refJenisBiayaNama")', strtolower($where['keyword']));
                $builder->orLike('LOWER(dt_matkul."matkulKode")', strtolower($where['keyword']));
                $builder->orLike('LOWER(dt_matkul."matkulNama")', strtolower($where['keyword']));
                $builder->orLike('LOWER(dt_matkul_group."matkulGroupKode")', strtolower($where['keyword']));
                $builder->orLike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']));
                $builder->orLike('LOWER(dt_studi_level."studiLevelNama")', strtolower($where['keyword']));
                $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']));
            }
        }

        $builder->orderBy('keu_tarif_biaya_lain."tarifLainId', 'DESC');
        return $builder;
    }

    public function getInfoTarifTambahan($where)
    {
        $builder = $this->table($this->table);
        $builder->join('ref_jenis_biaya', 'ref_jenis_biaya."refJenisBiayaId" = ' . $this->table . '."tarifLainJenisBiayaId"', 'LEFT');
        $builder->where($where);
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('keu_tarif_biaya_lain');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }
}
