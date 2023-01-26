<?php

/* 
    Define Dosen Routes
*/
$routes->get('dosen', '\Modules\Dosen\Controllers\Dosen::index');
$routes->post('dosen/tambah', '\Modules\Dosen\Controllers\Dosen::add');
$routes->post('dosen/cari', '\Modules\Dosen\Controllers\Dosen::search');
$routes->post('dosen/cari/fakultas', '\Modules\Dosen\Controllers\Dosen::searchPimpinan');
$routes->post('dosen/cari/prodi', '\Modules\Dosen\Controllers\Dosen::searchPimpinan');
$routes->add('dosen/ubah/(:num)', '\Modules\Dosen\Controllers\Dosen::edit/$1');
$routes->delete('dosen/hapus/(:num)', '\Modules\Dosen\Controllers\Dosen::delete/$1');
