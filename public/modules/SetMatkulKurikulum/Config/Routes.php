<?php

/* 
    Define SetMatkulKurikulum Routes
*/
$routes->get('setMatkulKurikulum', '\Modules\SetMatkulKurikulum\Controllers\SetMatkulKurikulum::index');
$routes->post('setMatkulKurikulum/tambah', '\Modules\SetMatkulKurikulum\Controllers\SetMatkulKurikulum::add');
$routes->add('setMatkulKurikulum/ubah/(:num)', '\Modules\SetMatkulKurikulum\Controllers\SetMatkulKurikulum::edit/$1');
$routes->delete('setMatkulKurikulum/hapus/(:num)', '\Modules\SetMatkulKurikulum\Controllers\SetMatkulKurikulum::delete/$1');
$routes->post('setMatkulKurikulum/detail/(:num)', '\Modules\SetMatkulKurikulum\Controllers\SetMatkulKurikulum::detailMatkulKurikulum/$1');
$routes->post('/setMatkulKurikulum/kurikulum', '\Modules\SetMatkulKurikulum\Controllers\SetMatkulKurikulum::kurikulum');
$routes->post('/setMatkulKurikulum/kurikulumDitawarkan', '\Modules\SetMatkulKurikulum\Controllers\SetMatkulKurikulum::kurikulumDitawarkan');
$routes->post('/setMatkulKurikulum/kurikulumDitawarkanEdit', '\Modules\SetMatkulKurikulum\Controllers\SetMatkulKurikulum::kurikulumDitawarkanEdit');
$routes->post('/setMatkulKurikulum/matkulProdi', '\Modules\SetMatkulKurikulum\Controllers\SetMatkulKurikulum::matkulProdi');
