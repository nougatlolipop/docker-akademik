<?php

/* 
    Define Krs Routes
*/
$routes->get('setDosenProdi', '\Modules\SetDosenProdi\Controllers\SetDosenProdi::index');
$routes->post('setDosenProdi/cari', '\Modules\SetDosenProdi\Controllers\SetDosenProdi::search');
$routes->post('setDosenProdi/cari/dosenPa', '\Modules\SetDosenProdi\Controllers\SetDosenProdi::searchDosenPa');
$routes->post('setDosenProdi/tambah', '\Modules\SetDosenProdi\Controllers\SetDosenProdi::add');
$routes->post('setDosenProdi/dosen', '\Modules\SetDosenProdi\Controllers\SetDosenProdi::dosenProdi');
$routes->delete('setDosenProdi/hapus/(:num)', '\Modules\SetDosenProdi\Controllers\SetDosenProdi::delete/$1');
