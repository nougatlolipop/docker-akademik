<?php

/* 
    Define DataMahasiswa Routes
*/
$routes->get('dataMahasiswa', '\Modules\DataMahasiswa\Controllers\DataMahasiswa::index');
$routes->post('dataMahasiswa/tambah', '\Modules\DataMahasiswa\Controllers\DataMahasiswa::add');
$routes->add('dataMahasiswa/ubah/(:num)', '\Modules\DataMahasiswa\Controllers\DataMahasiswa::edit/$1');
$routes->delete('dataMahasiswa/hapus/(:num)', '\Modules\DataMahasiswa\Controllers\DataMahasiswa::delete/$1');
