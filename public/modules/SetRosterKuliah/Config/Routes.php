<?php

/* 
    Define Krs Routes
*/
$routes->get('setRosterKuliah', '\Modules\SetRosterKuliah\Controllers\SetRosterKuliah::index');
$routes->post('setRosterKuliah/tambah/(:num)', '\Modules\SetRosterKuliah\Controllers\SetRosterKuliah::add/$1');
$routes->add('setRosterKuliah/ubah/(:num)', '\Modules\SetRosterKuliah\Controllers\SetRosterKuliah::edit/$1');
$routes->delete('setRosterKuliah/hapus/(:num)', '\Modules\SetRosterKuliah\Controllers\SetRosterKuliah::delete/$1');
