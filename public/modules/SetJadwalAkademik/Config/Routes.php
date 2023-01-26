<?php

/* 
    Define Krs Routes
*/
$routes->get('setJadwalAkademik', '\Modules\SetJadwalAkademik\Controllers\SetJadwalAkademik::index');
$routes->post('setJadwalAkademik/tambah', '\Modules\SetJadwalAkademik\Controllers\SetJadwalAkademik::add');
$routes->add('setJadwalAkademik/ubah/(:num)', '\Modules\SetJadwalAkademik\Controllers\SetJadwalAkademik::edit/$1');
$routes->delete('setJadwalAkademik/hapus/(:num)', '\Modules\SetJadwalAkademik\Controllers\SetJadwalAkademik::delete/$1');
