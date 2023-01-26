<?php

/* 
    Define KeuTunggakanDetail Routes
*/
$routes->get('keuTunggakanDetail', '\Modules\KeuTunggakanDetail\Controllers\KeuTunggakanDetail::index');
$routes->get('keuTunggakanDetail/load', '\Modules\KeuTunggakanDetail\Controllers\KeuTunggakanDetail::loadData');
$routes->post('/keuTunggakanDetail/cetak', '\Modules\KeuTunggakanDetail\Controllers\KeuTunggakanDetail::print');
