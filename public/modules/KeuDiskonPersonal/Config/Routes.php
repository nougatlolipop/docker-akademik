<?php

/* 
    Define KeuDiskonPersonal Routes
*/
$routes->get('keuDiskonPersonal', '\Modules\KeuDiskonPersonal\Controllers\KeuDiskonPersonal::index');
$routes->get('keuDiskonPersonal/cari', '\Modules\KeuDiskonPersonal\Controllers\KeuDiskonPersonal::loadData');
$routes->post('keuDiskonPersonal/setting', '\Modules\KeuDiskonPersonal\Controllers\KeuDiskonPersonal::setting');
