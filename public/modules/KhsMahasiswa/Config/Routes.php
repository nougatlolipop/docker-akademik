<?php

/* 
    Define Khs Routes
*/
$routes->get('khsMahasiswa', '\Modules\KhsMahasiswa\Controllers\KhsMahasiswa::index');
$routes->post('khsMahasiswa/tambah', '\Modules\KhsMahasiswa\Controllers\KhsMahasiswa::add');
$routes->add('khsMahasiswa/ubah/(:num)', '\Modules\KhsMahasiswa\Controllers\KhsMahasiswa::edit/$1');
$routes->delete('khsMahasiswa/hapus/(:num)', '\Modules\KhsMahasiswa\Controllers\KhsMahasiswa::delete/$1');
$routes->post('khsMahasiswa/cari', '\Modules\KhsMahasiswa\Controllers\KhsMahasiswa::cari');
