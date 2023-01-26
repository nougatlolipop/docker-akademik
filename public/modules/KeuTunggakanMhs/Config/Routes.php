<?php

/* 
    Define KeuTunggakanMhs Routes
*/
$routes->get('keuTunggakanMhs', '\Modules\KeuTunggakanMhs\Controllers\KeuTunggakanMhs::index');
$routes->get('keuTunggakanMhs/cari', '\Modules\KeuTunggakanMhs\Controllers\KeuTunggakanMhs::loadData');
