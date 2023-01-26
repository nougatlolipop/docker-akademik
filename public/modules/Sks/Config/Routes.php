<?php

/* 
    Define Sks Routes
*/
$routes->get('sks', '\Modules\Sks\Controllers\Sks::index');
$routes->post('sks/tambah', '\Modules\Sks\Controllers\Sks::add');
$routes->add('sks/ubah/(:num)', '\Modules\Sks\Controllers\Sks::edit/$1');
$routes->delete('sks/hapus/(:num)', '\Modules\Sks\Controllers\Sks::delete/$1');
