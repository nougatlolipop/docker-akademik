<?php

/* 
    Define SetRombel Routes
*/
$routes->get('setRombel', '\Modules\SetRombel\Controllers\SetRombel::index');
$routes->post('setRombel/tambah', '\Modules\SetRombel\Controllers\SetRombel::add');
$routes->post('setRombel/dosen/(:any)', '\Modules\SetRombel\Controllers\SetRombel::updateDosen/$1');
$routes->add('setRombel/ubah/(:num)', '\Modules\SetRombel\Controllers\SetRombel::edit/$1');
$routes->delete('setRombel/hapus/(:num)', '\Modules\SetRombel\Controllers\SetRombel::delete/$1');
