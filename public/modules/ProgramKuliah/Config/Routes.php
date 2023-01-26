<?php

/* 
    Define Krs Routes
*/
$routes->get('programKuliah', '\Modules\ProgramKuliah\Controllers\ProgramKuliah::index');
$routes->post('programKuliah/tambah', '\Modules\ProgramKuliah\Controllers\ProgramKuliah::add');
$routes->add('programKuliah/ubah/(:num)', '\Modules\ProgramKuliah\Controllers\ProgramKuliah::edit/$1');
$routes->delete('programKuliah/hapus/(:num)', '\Modules\ProgramKuliah\Controllers\ProgramKuliah::delete/$1');
