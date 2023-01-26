<?php

/* 
    Define FdrMahasiswa Routes
*/
$routes->get('fdrMahasiswa', '\Modules\FdrMahasiswa\Controllers\FdrMahasiswa::index');
$routes->post('fdrMahasiswa', '\Modules\FdrMahasiswa\Controllers\FdrMahasiswa::detail');
