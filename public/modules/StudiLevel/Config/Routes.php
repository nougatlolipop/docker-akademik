<?php

/* 
    Define Krs Routes
*/
$routes->get('studiLevel', '\Modules\StudiLevel\Controllers\StudiLevel::index');
$routes->post('studiLevel/tambah', '\Modules\StudiLevel\Controllers\StudiLevel::add');
$routes->add('studiLevel/ubah/(:num)', '\Modules\StudiLevel\Controllers\StudiLevel::edit/$1');
$routes->delete('studiLevel/hapus/(:num)', '\Modules\StudiLevel\Controllers\StudiLevel::delete/$1');
