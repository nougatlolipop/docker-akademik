<?php

/* 
    Define Krs Routes
*/
$routes->get('ruangan', '\Modules\Ruangan\Controllers\Ruangan::index');
$routes->post('ruangan/tambah', '\Modules\Ruangan\Controllers\Ruangan::add');
$routes->add('ruangan/ubah/(:num)', '\Modules\Ruangan\Controllers\Ruangan::edit/$1');
$routes->delete('ruangan/hapus/(:num)', '\Modules\Ruangan\Controllers\Ruangan::delete/$1');
