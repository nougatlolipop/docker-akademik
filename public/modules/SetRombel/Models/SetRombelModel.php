<?php

namespace Modules\SetRombel\Models;

use CodeIgniter\Model;

class SetRombelModel extends Model
{
    protected $table = 'setting_rombel';
    protected $primaryKey = 'setRombelId';
    protected $allowedFields = ['setRombelAngkatan', 'setRombelTahunAjaranId', 'setRombelProdiProgramKuliahId', 'setRombelDosenPA', 'setRombelKelasId', 'setRombelCreatedBy', 'setRombelCreatedDate', 'setRombelModifiedBy', 'setRombelModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'setRombelCreatedDate';
    protected $updatedField = 'setRombelModifiedDate';

    public function getSetRombel($where = null, $fakultas = null)
    {
        $builder = $this->table('setting_rombel');
        $builder->join('dt_tahun_ajaran', 'dt_tahun_ajaran."tahunAjaranId" = setting_rombel."setRombelTahunAjaranId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = setting_rombel."setRombelProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah."waktuId" = setting_prodi_program_kuliah."setProdiProgramKuliahWaktuKuliahId"', 'LEFT');
        $builder->join('dt_kelas', 'dt_kelas."kelasId" = setting_rombel."setRombelKelasId"', 'LEFT');
        $builder->join('dt_dosen', 'dt_dosen."dosenId" = setting_rombel."setRombelDosenPA"', 'LEFT');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if ($where) {
            if (isset($where['program_kuliah'])) {
                $builder->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']))->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_dosen."dosenNama")', strtolower($where['keyword']))->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                }
            }
            if (isset($where['prodi'])) {
                $builder->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_dosen."dosenNama")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                }
            }
        }
        $builder->orderBy('setting_rombel.setRombelId', 'DESC');
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('setting_rombel');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }
}
