<?php

function getKurikulum($id)
{
    $model = new Modules\Kurikulum\Models\KurikulumModel;
    $result = $model->getKurikulumDetail(['dt_kurikulum.kurikulumId' => $id])->findAll();
    return $result;
}
