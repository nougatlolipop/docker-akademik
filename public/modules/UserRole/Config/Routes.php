<?php

/* 
    Define UserRole Routes
*/
$routes->get('userRole', '\Modules\UserRole\Controllers\UserRole::index');
$routes->post('userRole/tambah', '\Modules\UserRole\Controllers\UserRole::add');
$routes->add('userRole/ubah/(:num)', '\Modules\UserRole\Controllers\UserRole::edit/$1');
