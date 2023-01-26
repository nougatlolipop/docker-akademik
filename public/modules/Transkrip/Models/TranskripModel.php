<?php


namespace Modules\Transkrip\Models;

use CodeIgniter\Model;

class TranskripModel extends Model
{

    public function getTranskrip($npm)
    {
        // $khs = $this->getKhs($npm);
        // $query = [];
        // foreach ($khs as $k) {
        //     foreach (json_decode($k->khsNilaiMatkul) as $row) {
        //         array_push($query, $row);
        //     }
        // }
        // $query =  json_encode($query);
        // dd($query);
        // $builder = $this->db->table('jsonb_to_recordset ((SELECT '[{"nilai":3.67,"status":1,"gradeId":20,"matkulId":12,"totalNilai":11.01},{"nilai":4,"status":1,"gradeId":19,"matkulId":18,"totalNilai":12},{"nilai":2,"status":1,"gradeId":26,"matkulId":1,"totalNilai":6},{"nilai":3.67,"status":1,"gradeId":20,"matkulId":12,"totalNilai":11.01},{"nilai":4,"status":1,"gradeId":19,"matkulId":18,"totalNilai":12},{"nilai":2,"status":1,"gradeId":26,"matkulId":1,"totalNilai":6}]'::jsonb  || (SELECT "konversiNilaiMatkulNew" FROM akd_konversi_nilai WHERE "konversiNilaiId" = 6)::jsonb) ) AS x ( "matkulId" INT, "gradeId" INT )');

        // return $builder;
    }

    public function getKhs($npm)
    {
        $builder = $this->db->table('akd_khs');
        $builder->where(['khsMahasiswaNpm' => $npm]);
        return $builder->get()->getResult();
    }
}
