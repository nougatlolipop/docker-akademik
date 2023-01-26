<?php

/* 
    Define JadwalWaktu Routes
*/
$routes->get('jadwalWaktu', '\Modules\JadwalWaktu\Controllers\JadwalWaktu::index');
$routes->post('jadwalWaktu/tambah', '\Modules\JadwalWaktu\Controllers\JadwalWaktu::add');
$routes->add('jadwalWaktu/ubah/(:num)', '\Modules\JadwalWaktu\Controllers\JadwalWaktu::edit/$1');
$routes->delete('jadwalWaktu/hapus/(:num)', '\Modules\JadwalWaktu\Controllers\JadwalWaktu::delete/$1');
