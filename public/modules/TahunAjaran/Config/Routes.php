<?php

/* 
    Define Krs Routes
*/
$routes->get('tahunAjaran', '\Modules\TahunAjaran\Controllers\TahunAjaran::index');
$routes->post('tahunAjaran/tambah', '\Modules\TahunAjaran\Controllers\TahunAjaran::add');
$routes->add('tahunAjaran/ubah/(:num)', '\Modules\TahunAjaran\Controllers\TahunAjaran::edit/$1');
$routes->delete('tahunAjaran/hapus/(:num)', '\Modules\TahunAjaran\Controllers\TahunAjaran::delete/$1');
