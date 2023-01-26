<?php

/* 
    Define Krs Routes
*/
$routes->get('waktuKuliah', '\Modules\WaktuKuliah\Controllers\WaktuKuliah::index');
$routes->post('waktuKuliah/tambah', '\Modules\WaktuKuliah\Controllers\WaktuKuliah::add');
$routes->add('waktuKuliah/ubah/(:num)', '\Modules\WaktuKuliah\Controllers\WaktuKuliah::edit/$1');
$routes->delete('waktuKuliah/hapus/(:num)', '\Modules\WaktuKuliah\Controllers\WaktuKuliah::delete/$1');
