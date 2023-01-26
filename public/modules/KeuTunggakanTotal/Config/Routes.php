<?php

/* 
    Define Nilai Routes
*/
$routes->get('keuTunggakanTotal', '\Modules\KeuTunggakanTotal\Controllers\KeuTunggakanTotal::index');
$routes->get('keuTunggakanTotal/load', '\Modules\KeuTunggakanTotal\Controllers\KeuTunggakanTotal::loadData');
$routes->post('keuTunggakanTotal/cetak', '\Modules\KeuTunggakanTotal\Controllers\KeuTunggakanTotal::print');
