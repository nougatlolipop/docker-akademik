<?php

/* 
    Define Nilai Routes
*/
$routes->get('keuBayarTotal', '\Modules\KeuBayarTotal\Controllers\KeuBayarTotal::index');
$routes->get('keuBayarTotal/load', '\Modules\KeuBayarTotal\Controllers\KeuBayarTotal::loadData');
$routes->post('keuBayarTotal/cetak', '\Modules\KeuBayarTotal\Controllers\KeuBayarTotal::print');
