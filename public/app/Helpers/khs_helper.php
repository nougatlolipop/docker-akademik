<?php
function getNilaiAngka($where)
{
    $result = [];
    foreach ($where[2] as $key => $data) {
        if ($data->gradeProdiNilaiProdiId == $where[0] && $data->gradeProdiNilaiGradeId == $where[1]) {
            $result = $data;
        }
    }
    return $result;
}

function nilaiAll($prodi)
{
    $model = new Modules\NilaiProdi\Models\NilaiProdiModel;
    $result = $model->getNilaiProdiDetail([
        'dt_grade_prodi_nilai.gradeProdiNilaiProdiId' => $prodi
    ])->findAll();
    return $result;
}

function getNilaiProdiDetailByNpm($where)
{
    $model = new Modules\NilaiProdi\Models\NilaiProdiModel;
    $where = [
        'dt_mahasiswa."mahasiswaNpm"' => $where[0],
        'dt_grade_prodi_nilai."gradeProdiNilaiGradeId"' => $where[1]
    ];
    $result = $model->getNilaiProdiDetailByNpm($where)->findAll();
    return $result;
}


function getKhs($npm)
{
    $model = new Modules\KhsMahasiswa\Models\KhsMahasiswaModel;
    $where = [
        'akd_khs."khsMahasiswaNpm"' => $npm
    ];
    $result = $model->cariKhs($where)->findAll();
    return $result;
}


function getKhsMahasiswa($where)
{
    $model = new Modules\KhsMahasiswa\Models\KhsMahasiswaModel;
    $where = [
        'akd_khs."khsMahasiswaNpm"' => (string)$where[0],
        'akd_khs."khsTahunAjaranId"' => $where[1],
    ];
    $result = $model->cariKhs($where)->findAll();
    return $result;
}

function hitungItem($collection, $item, $criteria)
{
    $jumlah = 0;
    foreach ($collection as $col) {
        if ($col->$criteria == $item) {
            $jumlah++;
        }
    }

    return $jumlah;
}
