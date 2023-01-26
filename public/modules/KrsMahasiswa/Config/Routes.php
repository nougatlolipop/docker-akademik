<?php

/* 
    Define Krs Routes
*/
$routes->get('krsMahasiswa', '\Modules\KrsMahasiswa\Controllers\KrsMahasiswa::index');
$routes->get('krsMahasiswa/cekTunggakan', '\Modules\KrsMahasiswa\Controllers\KrsMahasiswa::cekTunggakan');
$routes->post('krsMahasiswa/hapusKrs', '\Modules\KrsMahasiswa\Controllers\KrsMahasiswa::hapusKrs');
$routes->post('krsMahasiswa/tambah', '\Modules\KrsMahasiswa\Controllers\KrsMahasiswa::add');
$routes->get('/krsMahasiswa/cetak', '\Modules\KrsMahasiswa\Controllers\KrsMahasiswa::print');
// $routes->post('/krsMahasiswa/cetak', '\Modules\KrsMahasiswa\Controllers\KrsMahasiswa::print');
$routes->post('krsMahasiswa/krsMahasiswa', '\Modules\KrsMahasiswa\Controllers\KrsMahasiswa::getKrs');
$routes->add('krsMahasiswa/ubah/(:num)', '\Modules\KrsMahasiswa\Controllers\KrsMahasiswa::edit/$1');
$routes->delete('krsMahasiswa/hapus/(:num)', '\Modules\KrsMahasiswa\Controllers\KrsMahasiswa::delete/$1');
