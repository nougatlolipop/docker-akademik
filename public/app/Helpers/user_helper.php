<?php

function getUserDetail()
{
    $model = new Modules\ManajemenAkun\Models\ManajemenAkunModel;
    $result = $model->getUserDetail(['users.email' => user()->email])->findAll();
    return $result;
}

function getDosenProdi()
{
    $model = new Modules\ManajemenAkun\Models\ManajemenAkunModel;
    $result = $model->getDosenProdi(['users.email' => user()->email])->findAll();
    return $result;
}
