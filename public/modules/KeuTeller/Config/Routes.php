<?php

/* 
    Define KeuTeller Routes
*/
$routes->get('keuTeller', '\Modules\KeuTeller\Controllers\KeuTeller::index');
$routes->get('keuTeller/cari', '\Modules\KeuTeller\Controllers\KeuTeller::loadData');
$routes->get('keuTeller/create', '\Modules\KeuTeller\Controllers\KeuTeller::createInvoice');
$routes->get('keuTeller/getInvoice', '\Modules\KeuTeller\Controllers\KeuTeller::getInvoice');
$routes->post('keuTeller/setLunas', '\Modules\KeuTeller\Controllers\KeuTeller::setLunas');
$routes->post('keuTeller/setTahap', '\Modules\KeuTeller\Controllers\KeuTeller::setTahap');
$routes->post('keuTeller/cekJadwalLunas', '\Modules\KeuTeller\Controllers\KeuTeller::cekJadwalLunas');
