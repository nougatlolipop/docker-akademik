<?php

function getProgramKuliah($id)
{
    $model = new Modules\ProgramKuliah\Models\ProgramKuliahModel;
    $result = $model->getProgramKuliahDetail(['dt_program_kuliah.programKuliahId' => $id])->findAll();
    return $result;
}
