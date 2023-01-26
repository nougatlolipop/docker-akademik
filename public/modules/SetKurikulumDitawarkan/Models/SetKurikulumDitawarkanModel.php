<?php

namespace Modules\SetKurikulumDitawarkan\Models;

use CodeIgniter\Model;

class SetKurikulumDitawarkanModel extends Model
{
    protected $table = 'setting_kurikulum_tawarkan';
    protected $primaryKey = 'setKurikulumTawarId';
    protected $allowedFields = ['setKurikulumTawarProdiId', 'setKurikulumTawarProgramKuliahId', 'setKurikulumTawarAngkatan', 'setKurikulumTawarKurikulumId', 'setKurikulumTawarCreatedBy', 'setKurikulumTawarCreatedDate', 'setKurikulumTawarModifiedBy', 'setKurikulumTawarModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'setKurikulumTawarCreatedDate';
    protected $updatedField = 'setKurikulumTawarModifiedDate';

    public function getSetKurikulumDitawarkan($where = null, $fakultas = null)
    {
        $builder = $this->table('setting_kurikulum_tawarkan');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_kurikulum_tawarkan.setKurikulumTawarProdiId', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah.programKuliahId = setting_kurikulum_tawarkan.setKurikulumTawarProgramKuliahId', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum.kurikulumId = setting_kurikulum_tawarkan.setKurikulumTawarKurikulumId', 'LEFT');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if ($where) {
            if (isset($where['angkatan_min'])) {
                $builder->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                    $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                    $builder->orlike('LOWER(setting_kurikulum_tawarkan."setKurikulumTawarAngkatan")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                }
            }
            if (isset($where['angkatan_max'])) {
                $builder->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                    $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                    $builder->orlike('LOWER(setting_kurikulum_tawarkan."setKurikulumTawarAngkatan")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                }
            }
            if (isset($where['program_kuliah'])) {
                $builder->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(setting_kurikulum_tawarkan."setKurikulumTawarAngkatan")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->where('setting_kurikulum_tawarkan."setKurikulumTawarProgramKuliahId"', $where['program_kuliah']);
                }
            }
            if (isset($where['prodi'])) {
                $builder->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(setting_kurikulum_tawarkan."setKurikulumTawarAngkatan")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']))->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', is_array($where['prodi']) ? $where['prodi'] : [$where['prodi']]);
                }
            }
            if (!isset($where['angkatan_min']) && !isset($where['angkatan_max']) && !isset($where['program_kuliah']) && !isset($where['prodi'])) {
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(setting_kurikulum_tawarkan."setKurikulumTawarAngkatan")', strtolower($where['keyword']));
                    $builder->orlike('LOWER(dt_kurikulum."kurikulumNama")', strtolower($where['keyword']));
                }
            }
        }
        $builder->orderBy('setting_kurikulum_tawarkan.setKurikulumTawarId', 'DESC');
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('setting_kurikulum_tawarkan');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }

    public function kurikulumAkademik($where)
    {
        $builder = $this->db->table('dt_kurikulum');
        $builder->select('dt_kurikulum."kurikulumId", dt_kurikulum."kurikulumNama"');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarKurikulumId" = dt_kurikulum."kurikulumId"', 'LEFT');
        $builder->where($where);
        $builder->groupBy('dt_kurikulum."kurikulumId"');
        return $builder;
    }

    public function kurikulumAkademikDitawarkan($where, $whereIn = null)
    {
        $builder = $this->db->table('dt_kurikulum');
        $builder->join('setting_kurikulum_tawarkan', 'setting_kurikulum_tawarkan."setKurikulumTawarKurikulumId" = dt_kurikulum."kurikulumId"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', 'LEFT');
        if ($whereIn) {
            $builder->whereIn('setting_kurikulum_tawarkan."setKurikulumTawarProdiId"', $whereIn);
        }
        $builder->where($where);
        return $builder;
    }


    function getKurikulumTawarTarif($where = null, $fakultas = null)
    {
        $builder = $this->table($this->table);
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = ' . $this->table . '."setKurikulumTawarProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = ' . $this->table . '."setKurikulumTawarProgramKuliahId"', 'LEFT');
        $builder->join('dt_kurikulum', 'dt_kurikulum."kurikulumId" = ' . $this->table . '."setKurikulumTawarKurikulumId"', 'LEFT');
        $builder->join('ref_keu_tahap', 'ref_keu_tahap."refKeuTahapProdiId" = dt_prodi."prodiId" AND ref_keu_tahap."refKeuTahapProgramKuliahId" = dt_program_kuliah."programKuliahId" AND ref_keu_tahap."refKeuTahapAngkatan" = setting_kurikulum_tawarkan."setKurikulumTawarAngkatan"', 'LEFT');

        if ($fakultas) {
            $builder->where($fakultas);
        }
        if ($where) {
            if (isset($where['angkatan_min'])) {
                $builder->where('' . $this->table . '.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('' . $this->table . '.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('' . $this->table . '.setKurikulumTawarAngkatan >=', $where['angkatan_min']);
                }
            }
            if (isset($where['angkatan_max'])) {
                $builder->where('' . $this->table . '.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('' . $this->table . '.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('' . $this->table . '.setKurikulumTawarAngkatan <=', $where['angkatan_max']);
                }
            }
            if (isset($where['program_kuliah'])) {
                $builder->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                }
            }
            if (isset($where['prodi'])) {
                $builder->whereIn('dt_prodi.prodiId', $where['prodi']);
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                }
            }
            if (!isset($where['angkatan_min']) && !isset($where['angkatan_max']) && !isset($where['program_kuliah']) && !isset($where['prodi'])) {
                if (isset($where['keyword'])) {
                    $builder->like('LOWER(dt_prodi."prodiNama")', strtolower($where['keyword']));
                    $builder->orLike('LOWER(dt_program_kuliah."programKuliahNama")', strtolower($where['keyword']));
                }
            }
        }
        return $builder;
    }
}
