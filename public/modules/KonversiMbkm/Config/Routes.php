<?php

/* 
    Define KonversiMbkm Routes
*/
$routes->get('konversiMbkm', '\Modules\KonversiMbkm\Controllers\KonversiMbkm::index');
$routes->get('konversiMbkm/abort', '\Modules\KonversiMbkm\Controllers\KonversiMbkm::clearSync');
$routes->get('konversiMbkm/proses', '\Modules\KonversiMbkm\Controllers\KonversiMbkm::proses');
$routes->post('konversiMbkm/add', '\Modules\KonversiMbkm\Controllers\KonversiMbkm::add');
