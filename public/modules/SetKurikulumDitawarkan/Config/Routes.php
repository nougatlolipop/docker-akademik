<?php

/* 
    Define SetKurikulumDitawarkan Routes
*/
$routes->get('setKurikulumDitawarkan', '\Modules\SetKurikulumDitawarkan\Controllers\SetKurikulumDitawarkan::index');
$routes->post('setKurikulumDitawarkan/tambah', '\Modules\SetKurikulumDitawarkan\Controllers\SetKurikulumDitawarkan::add');
$routes->add('setKurikulumDitawarkan/ubah/(:num)', '\Modules\SetKurikulumDitawarkan\Controllers\SetKurikulumDitawarkan::edit/$1');
$routes->delete('setKurikulumDitawarkan/hapus/(:num)', '\Modules\SetKurikulumDitawarkan\Controllers\SetKurikulumDitawarkan::delete/$1');
$routes->post('/setKurikulumDitawarkan/programKuliah', '\Modules\SetKurikulumDitawarkan\Controllers\SetKurikulumDitawarkan::programKuliah');
