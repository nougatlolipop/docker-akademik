<?php

/* 
    Define Krs Routes
*/
$routes->get('kurikulumType', '\Modules\KurikulumType\Controllers\KurikulumType::index');
$routes->post('kurikulumType/tambah', '\Modules\KurikulumType\Controllers\KurikulumType::add');
$routes->add('kurikulumType/ubah/(:num)', '\Modules\KurikulumType\Controllers\KurikulumType::edit/$1');
$routes->delete('kurikulumType/hapus/(:num)', '\Modules\KurikulumType\Controllers\KurikulumType::delete/$1');
