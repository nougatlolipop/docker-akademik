<?php

/* 
    Define ConfigSet Routes
*/
$routes->get('configSet', '\Modules\ConfigSet\Controllers\ConfigSet::index');
$routes->post('configSet/tambah', '\Modules\ConfigSet\Controllers\ConfigSet::add');
$routes->add('configSet/ubah/(:num)', '\Modules\ConfigSet\Controllers\ConfigSet::edit/$1');
