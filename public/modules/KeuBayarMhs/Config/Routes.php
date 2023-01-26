<?php

/* 
    Define KeuBayarMhs Routes
*/
$routes->get('keuBayarMhs', '\Modules\KeuBayarMhs\Controllers\KeuBayarMhs::index');
$routes->get('keuBayarMhs/cari', '\Modules\KeuBayarMhs\Controllers\KeuBayarMhs::loadData');
