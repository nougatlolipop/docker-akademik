<?php

/* 
    Define MatkulGroupGroup
*/
$routes->get('matkulGroup', '\Modules\MatkulGroup\Controllers\MatkulGroup::index');
$routes->post('matkulGroup/tambah', '\Modules\MatkulGroup\Controllers\MatkulGroup::add');
$routes->add('matkulGroup/ubah/(:num)', '\Modules\MatkulGroup\Controllers\MatkulGroup::edit/$1');
$routes->delete('matkulGroup/hapus/(:num)', '\Modules\MatkulGroup\Controllers\MatkulGroup::delete/$1');
