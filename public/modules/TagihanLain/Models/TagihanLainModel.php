<?php

namespace Modules\TagihanLain\Models;

use CodeIgniter\Model;

class TagihanLainModel extends Model
{
    protected $table = 'keu_tagihan_lain';
    protected $primaryKey = 'tagihLainId';
    protected $allowedFields = ['tagihLainKodeBayar', 'tagihLainMahasiswaNpm', 'tagihLainVaNumber', 'tagihLainTahunAjaran', 'tagihLainTahapBayar', 'tagihLainJenisBiayaId', 'tagihLainNominal', 'tagihLainDiskon', 'tagihLainJumlah', 'tagihLainChannelKode', 'tagihLainTerminalKode', 'tagihLainTanggalMulai', 'tagihLainTanggalSelesai', 'tagihLainIsForceToPay', 'tagihLainIsPaid', 'tagihLainCreatedBy', 'tagihLainCreatedDate', 'tagihLainModifiedBy', 'tagihLainModifiedDate'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'tagihLainCreatedDate';
    protected $updatedField = 'tagihLainModifiedDate';

    public function getInfo($where)
    {
        $builder = $this->table('keu_tagihan_lain');
        $builder->join('keu_tarif_biaya_lain', 'keu_tarif_biaya_lain."tarifLainId" = keu_tagihan_lain."tagihLainJenisBiayaId"', 'LEFT');
        $builder->join('ref_jenis_biaya', 'ref_jenis_biaya."refJenisBiayaId" = keu_tarif_biaya_lain."tarifLainJenisBiayaId"', 'LEFT');
        $builder->where($where);
        return $builder;
    }
}
