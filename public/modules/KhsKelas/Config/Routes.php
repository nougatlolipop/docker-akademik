<?php

/* 
    Define KhsKelas Routes
*/
$routes->get('khsKelas', '\Modules\KhsKelas\Controllers\KhsKelas::index');
$routes->get('khsKelas/getNilai', '\Modules\KhsKelas\Controllers\KhsKelas::getNilai');
$routes->post('khsKelas/tambah', '\Modules\KhsKelas\Controllers\KhsKelas::add');
$routes->get('khsKelas/load', '\Modules\KhsKelas\Controllers\KhsKelas::loadData');
$routes->add('khsKelas/ubah/(:num)', '\Modules\KhsKelas\Controllers\KhsKelas::edit/$1');
$routes->delete('khsKelas/hapus/(:num)', '\Modules\KhsKelas\Controllers\KhsKelas::delete/$1');
$routes->post('/khsKelas/matkulKurikulum', '\Modules\KhsKelas\Controllers\KhsKelas::matkulKurikulum');
$routes->post('/khsKelas/prodiProgramKuliah', '\Modules\KhsKelas\Controllers\KhsKelas::prodiProgramKuliah');
$routes->post('khsKelas/cari', '\Modules\KhsKelas\Controllers\KhsKelas::cari');
$routes->post('/khsKelas/getTakenKrs', '\Modules\KhsKelas\Controllers\KhsKelas::getTakenKrs');
