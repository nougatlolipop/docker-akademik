<?php

function getJenisBiaya($id)
{
    $model = new Modules\JenisBiaya\Models\JenisBiayaModel;
    $result = $model->getJenisBiaya(['ref_jenis_biaya.refJenisBiayaId' => $id])->findAll();
    return $result;
}
