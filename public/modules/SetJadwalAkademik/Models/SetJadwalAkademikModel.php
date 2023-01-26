<?php

namespace Modules\SetJadwalAkademik\Models;

use CodeIgniter\Model;

class SetJadwalAkademikModel extends Model
{
    protected $table = 'setting_jadwal_akademik';
    protected $primaryKey = 'setJadwalAkademikId';
    protected $allowedFields = ['setJadwalAkademikProdiId', 'setJadwalAkademikTahunAjaranId', 'setJadwalAkademikKrsForceAktif', 'setJadwalAkademikKrsStartDate', 'setJadwalAkademikKrsEndDate', 'setJadwalAkademikUtsForceAktif', 'setJadwalAkademikUtsStartDate', 'setJadwalAkademikUtsEndDate',  'setJadwalAkademikUasForceAktif', 'setJadwalAkademikUasStartDate', 'setJadwalAkademikUasEndDate',  'setJadwalAkademikCreatedBy', 'setJadwalAkademikCreatedDate', 'setJadwalAkademikModifiedBy', 'setJadwalAkademikModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'setJadwalAkademikCreatedDate';
    protected $updatedField = 'setJadwalAkademikModifiedDate';

    public function getJadwalAkademikSearch($keyword = null, $fakultas = null)
    {
        $builder = $this->table('setting_jadwal_akademik');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_jadwal_akademik.setJadwalAkademikProdiId');
        $builder->join('dt_tahun_ajaran', 'dt_tahun_ajaran.tahunAjaranId = setting_jadwal_akademik.setJadwalAkademikTahunAjaranId');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($keyword));
        $builder->orLike('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($keyword));
        return $builder;
    }

    public function getJadwalAkademik($where = null, $fakultas = null)
    {
        $builder = $this->table('setting_jadwal_akademik');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_jadwal_akademik.setJadwalAkademikProdiId');
        $builder->join('dt_tahun_ajaran', 'dt_tahun_ajaran.tahunAjaranId = setting_jadwal_akademik.setJadwalAkademikTahunAjaranId');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if ($where) {
            if (isset($where['prodi'])) {
                $builder->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                }
            }
            if (isset($where['tahunAjar'])) {
                $builder->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                    $builder->orlike('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']))->where('dt_tahun_ajaran.tahunAjaranKode', $where['tahunAjar']);
                }
            }
            if (!isset($where['prodi']) && !isset($where['tahunAjar'])) {
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_tahun_ajaran."tahunAjaranNama")', strtolower($where['keyword']));
                }
            }
        }
        $builder->orderBy('setting_jadwal_akademik.setJadwalAkademikId', 'DESC');
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('setting_jadwal_akademik');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }

    public function getTahunAjaranAktif($where, $orwhere = null)
    {
        $builder = $this->table('setting_jadwal_akademik');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_jadwal_akademik."setJadwalAkademikProdiId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahProdiId" = dt_prodi."prodiId"', 'LEFT');
        $builder->join('dt_mahasiswa', 'dt_mahasiswa."mahasiswaProdiProgramKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_tahun_ajaran', 'dt_tahun_ajaran."tahunAjaranId" = setting_jadwal_akademik."setJadwalAkademikTahunAjaranId"', 'LEFT');
        $builder->join('dt_semester', 'dt_semester."semesterId"=dt_tahun_ajaran."tahunAjaranSemesterId"', 'LEFT');
        $builder->where($where);
        if ($orwhere != []) {
            $builder->orWhere($orwhere[0])->where($orwhere[1]);
        }
        $builder->orderBy('setting_jadwal_akademik."setJadwalAkademikId"', 'ASC');
        return $builder;
    }
}
