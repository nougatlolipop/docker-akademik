<?php

/* 
    Define Krs Routes
*/
$routes->get('matkul', '\Modules\Matkul\Controllers\Matkul::index');
$routes->post('matkul/tambah', '\Modules\Matkul\Controllers\Matkul::add');
$routes->add('matkul/ubah/(:num)', '\Modules\Matkul\Controllers\Matkul::edit/$1');
$routes->delete('matkul/hapus/(:num)', '\Modules\Matkul\Controllers\Matkul::delete/$1');
