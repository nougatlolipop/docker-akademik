<?php

/* 
    Define Krs Routes
*/
$routes->get('matkulType', '\Modules\MatkulType\Controllers\MatkulType::index');
$routes->post('matkulType/tambah', '\Modules\MatkulType\Controllers\MatkulType::add');
$routes->add('matkulType/ubah/(:num)', '\Modules\MatkulType\Controllers\MatkulType::edit/$1');
$routes->delete('matkulType/hapus/(:num)', '\Modules\MatkulType\Controllers\MatkulType::delete/$1');
