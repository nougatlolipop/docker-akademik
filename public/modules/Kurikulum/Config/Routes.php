<?php

/* 
    Define Krs Routes
*/
$routes->get('kurikulum', '\Modules\Kurikulum\Controllers\Kurikulum::index');
$routes->post('kurikulum/tambah', '\Modules\Kurikulum\Controllers\Kurikulum::add');
$routes->add('kurikulum/ubah/(:num)', '\Modules\Kurikulum\Controllers\Kurikulum::edit/$1');
$routes->delete('kurikulum/hapus/(:num)', '\Modules\Kurikulum\Controllers\Kurikulum::delete/$1');
