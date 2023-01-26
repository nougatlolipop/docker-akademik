<?php

namespace Modules\KhsMahasiswa\Models;

use CodeIgniter\Model;

class KhsMahasiswaModel extends Model
{
    protected $table = 'akd_khs';
    protected $primaryKey = 'khsId';
    protected $allowedFields = ['khsMahasiswaNpm', 'khsTahunAjaranId', 'khsNilaiMatkul', 'khsCreatedBy', 'khsCreatedDate', 'khsModifiedBy', 'khsModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'khsCreatedDate';
    protected $updatedField = 'khsModifiedDate';

    public function getKhs($where, $fakultas = null)
    {
        $builder = $this->table('akd_khs');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa.mahasiswaNpm = akd_khs.khsMahasiswaNpm', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah.setProdiProgramKuliahId = dt_mahasiswa.mahasiswaProdiProgramKuliahId', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah.programKuliahId = setting_prodi_program_kuliah.setProdiProgramKuliahProgramKuliahId', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_prodi_program_kuliah.setProdiProgramKuliahProdiId', 'LEFT');
        $builder->join('dt_tahun_ajaran', 'dt_tahun_ajaran.tahunAjaranId = akd_khs.khsTahunAjaranId', 'LEFT');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if (isset($where['angkatan_min'])) {
            $builder->where('dt_mahasiswa."mahasiswaAngkatan" >=', $where['angkatan_min']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(akd_khs."khsMahasiswaNpm")', strtolower($where['keyword']))->where('dt_mahasiswa."mahasiswaAngkatan" >=', $where['angkatan_min']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->where('dt_mahasiswa."mahasiswaAngkatan" >=', $where['angkatan_min']);
            }
        }
        if (isset($where['angkatan_max'])) {
            $builder->where('dt_mahasiswa."mahasiswaAngkatan" <=', $where['angkatan_max']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(akd_khs."khsMahasiswaNpm")', strtolower($where['keyword']))->where('dt_mahasiswa."mahasiswaAngkatan" <=', $where['angkatan_max']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->where('dt_mahasiswa."mahasiswaAngkatan" <=', $where['angkatan_max']);
            }
        }
        if (isset($where['program_kuliah'])) {
            $builder->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(akd_khs."khsMahasiswaNpm")', strtolower($where['keyword']))->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
            }
        }
        if (isset($where['prodi'])) {
            $builder->whereIn('dt_prodi."prodiId"', $where['prodi']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(akd_khs."khsMahasiswaNpm")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', $where['prodi']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', $where['prodi']);
            }
        }
        if (isset($where['waktuKuliah'])) {
            $builder->whereIn('setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', $where['waktuKuliah']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(akd_khs."khsMahasiswaNpm")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', $where['waktuKuliah']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', $where['waktuKuliah']);
            }
        }
        if (isset($where['tahunAjar'])) {
            $builder->where('dt_tahun_ajaran."tahunAjaranKode"', $where['tahunAjar']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(akd_khs."khsMahasiswaNpm")', strtolower($where['keyword']))->where('dt_tahun_ajaran."tahunAjaranKode"', $where['tahunAjar']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->where('dt_tahun_ajaran."tahunAjaranKode"', $where['tahunAjar']);
            }
        }
        if (!isset($where['angkatan_min']) && !isset($where['angkatan_max']) && !isset($where['program_kuliah']) && !isset($where['prodi']) && !isset($where['waktuKuliah']) && !isset($where['tahunAjar'])) {
            if (isset($where['keyword'])) {
                $builder->like('LOWER(akd_khs."khsMahasiswaNpm")', strtolower($where['keyword']));
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']));
            }
        }
        if (isset($where['npm'])) {
            $builder->where('akd_khs.khsMahasiswaNpm', $where['npm']);
        }
        $builder->orderBy('akd_khs.khsId', 'DESC');
        return $builder;
    }

    public function cariKhs($where)
    {
        $builder = $this->table('akd_khs');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa.mahasiswaNpm = akd_khs.khsMahasiswaNpm', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah.setProdiProgramKuliahId = dt_mahasiswa.mahasiswaProdiProgramKuliahId', 'LEFT');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan.setKurikulumTawarProdiId = setting_prodi_program_kuliah.setProdiProgramKuliahProdiId AND setting_kurikulum_tawarkan.setKurikulumTawarProgramKuliahId = setting_prodi_program_kuliah.setProdiProgramKuliahProgramKuliahId AND setting_kurikulum_tawarkan.setKurikulumTawarAngkatan = dt_mahasiswa.mahasiswaAngkatan', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum.kurikulumId = setting_kurikulum_tawarkan.setKurikulumTawarKurikulumId', 'LEFT');
        $builder->join('dt_sks_allow', 'dt_sks_allow.sksAllowId = dt_kurikulum.kurikulumSksAllowId', 'LEFT');
        $builder->where($where);
        $builder->orderBy('akd_khs.khsId', 'DESC');
        return $builder;
    }
}
