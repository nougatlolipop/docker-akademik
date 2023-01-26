<?php

namespace Modules\SetProdiProgKuliah\Models;

use CodeIgniter\Model;

class SetProdiProgKuliahModel extends Model
{
    protected $table = 'setting_prodi_program_kuliah';
    protected $primaryKey = 'setProdiProgramKuliahId';
    protected $allowedFields = ['setProdiProgramKuliahProdiId', 'setProdiProgramKuliahProgramKuliahId', 'setProdiProgramKuliahWaktuKuliahId', 'setProdiProgramKuliahKelompokKuliahId', 'setProdiProgramKuliahIsAktif', 'setProdiProgramKuliahCreatedBy', 'setProdiProgramKuliahCreatedDate', 'setProdiProgramKuliahModifiedBy', 'setProdiProgramKuliahModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'setProdiProgramKuliahCreatedDate';
    protected $updatedField = 'setProdiProgramKuliahModifiedDate';

    public function getSetProdiProgKuliah($where = null, $fakultas = null, $controller = null)
    {
        $builder = $this->table('setting_prodi_program_kuliah');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_prodi_program_kuliah.setProdiProgramKuliahProdiId', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah.programKuliahId = setting_prodi_program_kuliah.setProdiProgramKuliahProgramKuliahId', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah.waktuId = setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', 'LEFT');
        $builder->join('dt_kelompok_kuliah', 'dt_kelompok_kuliah.kelompokKuliahId = setting_prodi_program_kuliah.setProdiProgramKuliahKelompokKuliahId', 'LEFT');

        if ($fakultas) {
            $builder->where($fakultas);
        }
        if ($where) {
            if (isset($where['angkatan_min'])) {
                $builder->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                    $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                    $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                }
            }
            if (isset($where['angkatan_max'])) {
                $builder->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                    $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                    $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                }
            }

            if (isset($where['program_kuliah'])) {
                $builder->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                }
            }
            if (isset($where['prodi'])) {
                $builder->whereIn('dt_prodi.prodiId', $where['prodi']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                    $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                    $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                }
            }
            if (!isset($where['angkatan_min']) && !isset($where['angkatan_max']) && !isset($where['program_kuliah']) && !isset($where['prodi'])) {
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_waktu_kuliah."waktuNama")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_kelompok_kuliah."kelompokKuliahNama")', strtolower($where['keyword']));
                }
            }
        }
        $builder->orderBy('setting_prodi_program_kuliah.setProdiProgramKuliahId', 'DESC');

        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('setting_prodi_program_kuliah');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }

    public function prodiProgramKuliahAkademik($where, $whereIn = null)
    {
        $builder = $this->table('setting_prodi_program_kuliah');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah."waktuId" = setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', 'LEFT');
        $builder->where($where);
        if ($whereIn) {
            $builder->whereIn('setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"', $whereIn);
        }
        $builder->orderBy('setting_prodi_program_kuliah."setProdiProgramKuliahId"', 'DESC');
        return $builder;
    }

    public function getSetRombel($where = null, $fakultas = null)
    {
        $builder = $this->table('setting_prodi_program_kuliah');
        $builder->join('setting_rombel', 'setting_rombel."setRombelProdiProgramKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_tahun_ajaran', 'dt_tahun_ajaran."tahunAjaranId" = setting_rombel."setRombelTahunAjaranId"', 'LEFT');
        $builder->join('dt_kelas', 'dt_kelas."kelasId" = setting_rombel."setRombelKelasId"', 'LEFT');
        $builder->join('dt_dosen', 'dt_dosen."dosenId" = setting_rombel."setRombelDosenPA"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah."waktuId" = setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', 'LEFT');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if ($where) {
            if (isset($where['program_kuliah'])) {
                $builder->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
            }
            if (isset($where['prodi'])) {
                $builder->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
            }
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']));
                $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']));
                $builder->orlike('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']));
                $builder->orlike('LOWER(dt_dosen."dosenNama")', strtolower($where['keyword']));
            }
        }
        $builder->orderBy('setting_rombel.setRombelId', 'DESC');
        return $builder;
    }
}
