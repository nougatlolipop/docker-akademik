<?php

function getProdiDetail($id)
{
    $model = new Modules\Prodi\Models\ProdiModel;
    $result = $model->getProdiDetail(['dt_prodi.prodiId' => $id])->findAll();
    return $result;
}
