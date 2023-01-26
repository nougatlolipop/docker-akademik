<?php

/* 
    Define KeuTahap Routes
*/
$routes->get('keuTahap', '\Modules\KeuTahap\Controllers\KeuTahap::index');
$routes->post('keuTahap/tambah', '\Modules\KeuTahap\Controllers\KeuTahap::add');
$routes->post('keuTahap/jumlah', '\Modules\KeuTahap\Controllers\KeuTahap::jumlahTahap');
$routes->add('keuTahap/ubah/(:num)', '\Modules\KeuTahap\Controllers\KeuTahap::edit/$1');
$routes->delete('keuTahap/hapus/(:num)', '\Modules\KeuTahap\Controllers\KeuTahap::delete/$1');
