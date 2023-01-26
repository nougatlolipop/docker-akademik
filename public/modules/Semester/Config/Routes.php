<?php

/* 
    Define Krs Routes
*/
$routes->get('semester', '\Modules\Semester\Controllers\Semester::index');
$routes->post('semester/tambah', '\Modules\Semester\Controllers\Semester::add');
$routes->add('semester/ubah/(:num)', '\Modules\Semester\Controllers\Semester::edit/$1');
$routes->delete('semester/hapus/(:num)', '\Modules\Semester\Controllers\Semester::delete/$1');
