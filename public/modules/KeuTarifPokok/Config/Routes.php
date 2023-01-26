<?php

/* 
    Define KeuTarifPokok Routes
*/
$routes->get('keuTarifPokok', '\Modules\KeuTarifPokok\Controllers\KeuTarifPokok::index');
$routes->post('keuTarifPokok/tambah', '\Modules\KeuTarifPokok\Controllers\KeuTarifPokok::add');
$routes->post('keuTarifPokok/hitung', '\Modules\KeuTarifPokok\Controllers\KeuTarifPokok::hitung');
$routes->put('keuTarifPokok/ubah', '\Modules\KeuTarifPokok\Controllers\KeuTarifPokok::edit');
$routes->delete('keuTarifPokok/hapus', '\Modules\KeuTarifPokok\Controllers\KeuTarifPokok::delete');
