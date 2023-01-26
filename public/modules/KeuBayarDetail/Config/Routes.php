<?php

/* 
    Define KeuBayarDetail Routes
*/
$routes->get('keuBayarDetail', '\Modules\KeuBayarDetail\Controllers\KeuBayarDetail::index');
$routes->get('keuBayarDetail/load', '\Modules\KeuBayarDetail\Controllers\KeuBayarDetail::loadData');
$routes->post('/keuBayarDetail/cetak', '\Modules\KeuBayarDetail\Controllers\KeuBayarDetail::print');
