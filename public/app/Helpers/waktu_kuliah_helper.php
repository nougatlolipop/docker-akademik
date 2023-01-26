<?php

function getWaktuKuliahDetail($id)
{
    $model = new Modules\WaktuKuliah\Models\WaktuKuliahModel;
    $result = $model->getWaktuKuliahDetail(['dt_waktu_kuliah.waktuId' => $id])->findAll();
    return $result;
}
