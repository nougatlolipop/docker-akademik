<?php

/* 
    Define SetBiayaPraktikum Routes
*/
$routes->get('setBiayaPraktikum', '\Modules\SetBiayaPraktikum\Controllers\SetBiayaPraktikum::index');
$routes->post('setBiayaPraktikum/tambah', '\Modules\SetBiayaPraktikum\Controllers\SetBiayaPraktikum::add');
$routes->add('setBiayaPraktikum/ubah/(:num)', '\Modules\SetBiayaPraktikum\Controllers\SetBiayaPraktikum::edit/$1');
$routes->delete('setBiayaPraktikum/hapus/(:num)', '\Modules\SetBiayaPraktikum\Controllers\SetBiayaPraktikum::delete/$1');
