<?php

/* 
    Define Mahasiswa Routes
*/

$routes->get('mahasiswa', '\Modules\Mahasiswa\Controllers\Mahasiswa::index', ['filter' => 'role:Mahasiswa']);
$routes->get('mahasiswa/index', '\Modules\Mahasiswa\Controllers\Mahasiswa::index', ['filter' => 'role:Mahasiswa']);
$routes->post('mahasiswa/cari', '\Modules\Mahasiswa\Controllers\Mahasiswa::cari');
$routes->post('mahasiswa/kurikulum', '\Modules\Mahasiswa\Controllers\Mahasiswa::kurikulum');
$routes->post('mahasiswa/matkul', '\Modules\Mahasiswa\Controllers\Mahasiswa::matkul');
$routes->get('mahasiswa/createInvoice', '\Modules\Mahasiswa\Controllers\Mahasiswa::createInvoice');
$routes->post('mahasiswa/tambahKrs', '\Modules\Mahasiswa\Controllers\Mahasiswa::add');
