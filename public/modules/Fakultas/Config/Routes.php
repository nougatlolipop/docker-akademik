<?php

/* 
    Define Krs Routes
*/
$routes->get('fakultas', '\Modules\Fakultas\Controllers\Fakultas::index');
$routes->post('fakultas/tambah', '\Modules\Fakultas\Controllers\Fakultas::add');
$routes->add('fakultas/ubah/(:num)', '\Modules\Fakultas\Controllers\Fakultas::edit/$1');
$routes->post('fakultas/dosen/(:num)', '\Modules\Fakultas\Controllers\Fakultas::updateDosen/$1');
$routes->delete('fakultas/hapus/(:num)', '\Modules\Fakultas\Controllers\Fakultas::delete/$1');
