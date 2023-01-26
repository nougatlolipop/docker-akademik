<?php

/* 
    Define Krs Routes
*/
$routes->get('kelas', '\Modules\Kelas\Controllers\Kelas::index');
$routes->post('kelas/tambah', '\Modules\Kelas\Controllers\Kelas::add');
$routes->add('kelas/ubah/(:num)', '\Modules\Kelas\Controllers\Kelas::edit/$1');
$routes->delete('kelas/hapus/(:num)', '\Modules\Kelas\Controllers\Kelas::delete/$1');
