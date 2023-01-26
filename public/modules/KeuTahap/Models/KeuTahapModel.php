<?php

namespace Modules\KeuTahap\Models;

use CodeIgniter\Model;

class KeuTahapModel extends Model
{
    protected $table = 'ref_keu_tahap';
    protected $primaryKey = 'refKeuTahapId';
    protected $allowedFields = ['refKeuTahapProdiId', 'refKeuTahapProgramKuliahId', 'refKeuTahapAngkatan', 'refKeuTahapJumlah', 'refKeuTahapCreatedBy', 'refKeuTahapCreatedDate', 'refKeuTahapModifiedBy', 'refKeuTahapModifiedDate', 'refKeuTahapIsHer', 'refKeuTahapHer'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'refKeuTahapCreatedDate';
    protected $updatedField = 'refKeuTahapModifiedDate';

    public function getKeuTahap($where = null)
    {
        $builder = $this->table('ref_keu_tahap');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = ref_keu_tahap."refKeuTahapProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = ref_keu_tahap."refKeuTahapProgramKuliahId"', 'LEFT');
        if ($where) {
            if (isset($where['program_kuliah'])) {
                $builder->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(ref_keu_tahap."refKeuTahapAngkatan")', strtolower($where['keyword']))->where('dt_program_kuliah."programKuliahId"', $where['program_kuliah']);
                }
            }
            if (isset($where['prodi'])) {
                $builder->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(ref_keu_tahap."refKeuTahapAngkatan")', strtolower($where['keyword']))->whereIn('dt_prodi."prodiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                }
            }
            if (!isset($where['program_kuliah']) && !isset($where['prodi'])) {
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(ref_keu_tahap."refKeuTahapAngkatan")', strtolower($where['keyword']));
                }
            }
        }
        $builder->orderBy('ref_keu_tahap.refKeuTahapId', 'DESC');
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('ref_keu_tahap');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }

    public function getWhere($where)
    {
        $builder = $this->table('ref_keu_tahap');
        $builder->where($where);
        return $builder;
    }
}
