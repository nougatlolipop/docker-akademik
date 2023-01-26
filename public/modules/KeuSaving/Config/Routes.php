<?php

/* 
    Define KeuSaving Routes
*/
$routes->get('keuSaving', '\Modules\KeuSaving\Controllers\KeuSaving::index');
$routes->get('keuSaving/cari', '\Modules\KeuSaving\Controllers\KeuSaving::loadData');
$routes->post('keuSaving/tambah', '\Modules\KeuSaving\Controllers\KeuSaving::add');
