<?php

/* 
    Define Krs Routes
*/
$routes->get('kelompokKuliah', '\Modules\KelompokKuliah\Controllers\KelompokKuliah::index');
$routes->post('kelompokKuliah/tambah', '\Modules\KelompokKuliah\Controllers\KelompokKuliah::add');
$routes->add('kelompokKuliah/ubah/(:num)', '\Modules\KelompokKuliah\Controllers\KelompokKuliah::edit/$1');
$routes->delete('kelompokKuliah/hapus/(:num)', '\Modules\KelompokKuliah\Controllers\KelompokKuliah::delete/$1');
