<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferensiModel extends Model
{

    public function getHari()
    {
        $builder = $this->db->table('ref_hari');
        $builder->whereNotIn('ref_hari.refHariKode', ['1']);
        return $builder->get();
    }

    public function getJabatan()
    {
        $builder = $this->db->table('ref_jabatan_struktural');
        return $builder->get();
    }

    public function getGedung()
    {
        $builder = $this->db->table('ref_gedung');
        return $builder->get();
    }

    public function getTingkat()
    {
        $builder = $this->db->table('ref_tingkat_users');
        return $builder->get();
    }

    public function kelamin()
    {
        $builder = $this->db->table('ref_jenis_kelamin');
        return $builder->get();
    }

    public function agama()
    {
        $builder = $this->db->table('ref_agama');
        return $builder->get();
    }

    public function golDarah()
    {
        $builder = $this->db->table('ref_golongan_darah');
        return $builder->get();
    }

    public function kecamatan()
    {
        $builder = $this->db->table('ref_kecamatan');
        return $builder->get();
    }

    public function jenjangPendidikan()
    {
        $builder = $this->db->table('ref_jenjang_pendidikan');
        $builder->whereIn('refJenjangId', [11, 12, 13, 14, 15, 16, 18, 20]);
        return $builder->get();
    }

    public function penghasilan()
    {
        $builder = $this->db->table('ref_penghasilan');
        return $builder->get();
    }

    public function statusDosen()
    {
        $builder = $this->db->table('ref_status_dosen');
        return $builder->get();
    }

    public function statusAktif()
    {
        $builder = $this->db->table('ref_status_aktif');
        return $builder->get();
    }

    public function statusNikah()
    {
        $builder = $this->db->table('ref_status_nikah');
        return $builder->get();
    }

    public function getKeuTahap($where = null)
    {
        $builder = $this->db->table('ref_keu_tahap');
        $builder->selectMax("refKeuTahapJumlah");
        if ($where) {
            $builder->whereIn('refKeuTahapProdiId', $where);
        }
        return $builder->get();
    }

    public function getBank($where = null)
    {
        $builder = $this->db->table('ref_bank');
        if ($where) {
            $builder->where($where);
        }
        return $builder->get();
    }

    public function getJadwalBayarInfo($init, $where = null)
    {
        $builder = $this->db->table("function_jadwal_tagihan_all('" . $init[0] . "','" . $init[1] . "')");
        if ($where) {
            $builder->where($where);
        }
        return $builder->get();
    }
}
