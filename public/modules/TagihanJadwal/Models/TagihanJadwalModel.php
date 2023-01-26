<?php

namespace Modules\TagihanJadwal\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class TagihanJadwalModel extends Model
{
    protected $table = 'keu_tagihan_jadwal';
    protected $primaryKey = 'jadwalTagihanId';
    protected $allowedFields = ['jadwalTagihanProdiId', 'jadwalTagihanProgramKuliahId', 'jadwalTagihanAngkatan', 'jadwalTagihanTahun', 'jadwalTagihanDeskripsi', 'jadwalTagihanDeskripsiHer'];
    protected $returnType = 'object';
}
