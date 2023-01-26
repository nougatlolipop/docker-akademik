<?php

/* 
    Define Krs Routes
*/
$routes->get('nilai', '\Modules\Nilai\Controllers\Nilai::index');
$routes->post('nilai/tambah', '\Modules\Nilai\Controllers\Nilai::add');
$routes->add('nilai/ubah/(:num)', '\Modules\Nilai\Controllers\Nilai::edit/$1');
$routes->delete('nilai/hapus/(:num)', '\Modules\Nilai\Controllers\Nilai::delete/$1');
