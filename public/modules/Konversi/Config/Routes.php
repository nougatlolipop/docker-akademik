<?php

/* 
    Define Konversi Routes
*/
$routes->get('konversi', '\Modules\Konversi\Controllers\Konversi::index');
$routes->get('konversi/abort', '\Modules\Konversi\Controllers\Konversi::clearSync');
$routes->get('konversi/proses', '\Modules\Konversi\Controllers\Konversi::proses');
$routes->post('konversi/add', '\Modules\Konversi\Controllers\Konversi::add');
