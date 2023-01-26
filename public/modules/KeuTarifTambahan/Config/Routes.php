<?php

/* 
    Define Tarif Tambahan Routes
*/
$routes->get('keuTarifTambahan', '\Modules\KeuTarifTambahan\Controllers\KeuTarifTambahan::index');
$routes->post('keuTarifTambahan/tambah', '\Modules\KeuTarifTambahan\Controllers\KeuTarifTambahan::add');
$routes->add('keuTarifTambahan/ubah/(:num)', '\Modules\KeuTarifTambahan\Controllers\KeuTarifTambahan::edit/$1');
$routes->delete('keuTarifTambahan/hapus/(:num)', '\Modules\KeuTarifTambahan\Controllers\KeuTarifTambahan::delete/$1');
