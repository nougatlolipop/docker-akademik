<?php

/* 
    Define Krs Routes
*/
$routes->get('prodi', '\Modules\Prodi\Controllers\Prodi::index');
$routes->post('prodi/tambah', '\Modules\Prodi\Controllers\Prodi::add');
$routes->add('prodi/ubah/(:num)', '\Modules\Prodi\Controllers\Prodi::edit/$1');
$routes->post('prodi/dosen/(:num)', '\Modules\Prodi\Controllers\Prodi::updateDosen/$1');
$routes->delete('prodi/hapus/(:num)', '\Modules\Prodi\Controllers\Prodi::delete/$1');
