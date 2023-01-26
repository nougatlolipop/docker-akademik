<?php

namespace Modules\Tagihan\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class TagihanModel extends Model
{
    protected $table = 'keu_tagihan';
    protected $primaryKey = 'tagihId';
    protected $allowedFields = ['tagihKodeBayar', 'tagihNoDaftar', 'tagihVaNumber', 'tagihProdiProgramKuliahId', 'tagihTahunAjaran', 'tagihTahunSemester', 'tagihTahapBayar', 'tagihBankId', 'tagihChannelKode', 'tagihTerminalKode', 'tagihTanggalMulai', 'tagihTanggalBayar', 'tagihMetodeLunas', 'tagihIsForceToPay', 'tagihDetailHer', 'tagihIsPaid', 'tagihCreatedBy', 'tagihCreatedDate', 'tagihModifiedBy', 'tagihModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'tagihCreatedDate';
    protected $updatedField = 'tagihModifiedDate';
    protected $jenis;

    public function cekTunggakan($where)
    {
        $builder = $this->db->table("function_cek_tunggakan_krs('" . $where[0] . "','" . $where[1] . "')");
        return $builder->get();
    }

    public function updateTagihan($where)
    {
        $builder = $this->db->query("CALL prosedur_ubah_force_pay(" . $where[0] . ",'" . $where[1] . "','" . $where[2] . "')");
        return $builder;
    }

    public function updateTagihanHer($where)
    {
        $builder = $this->db->query("CALL prosedur_ubah_force_pay_her(" . $where[0] . ",'" . $where[1] . "','" . $where[2] . "')");
        return $builder;
    }

    public function updateTagihanLain($where)
    {
        $builder = $this->db->query("CALL prosedur_ubah_force_pay_biaya_lain(" . $where[0] . ",'" . $where[1] . "')");
        return $builder;
    }
}
