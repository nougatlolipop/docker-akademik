<?php

function getKelompokKuliah($id)
{
    $model = new Modules\KelompokKuliah\Models\KelompokKuliahModel;
    $result = $model->getKelompokKuliah(['dt_kelompok_kuliah.kelompokKuliahId' => $id])->findAll();
    return $result;
}
