<?php

/* 
    Define Krs Routes
*/
$routes->get('setJabatanStruktural', '\Modules\SetJabatanStruktural\Controllers\SetJabatanStruktural::index');
$routes->post('setJabatanStruktural/tambah', '\Modules\SetJabatanStruktural\Controllers\SetJabatanStruktural::add');
$routes->add('setJabatanStruktural/ubah/(:num)', '\Modules\SetJabatanStruktural\Controllers\SetJabatanStruktural::edit/$1');
$routes->delete('setJabatanStruktural/hapus/(:num)', '\Modules\SetJabatanStruktural\Controllers\SetJabatanStruktural::delete/$1');
