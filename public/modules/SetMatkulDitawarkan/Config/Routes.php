<?php

/* 
    Define SetMatkulDitawarkan Routes
*/
$routes->get('setMatkulDitawarkan', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::index');
$routes->post('setMatkulDitawarkan/tambah', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::add');
$routes->post('setMatkulDitawarkan/tambahDosen/(:num)', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::addDosen/$1');
$routes->post('setMatkulDitawarkan/hapusDosen/(:num)', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::deleteDosen/$1');
$routes->add('setMatkulDitawarkan/ubah/(:num)', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::edit/$1');
$routes->delete('setMatkulDitawarkan/hapus/(:num)', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::delete/$1');
$routes->post('/setMatkulDitawarkan/matkulKurikulum', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::matkulKurikulum');
$routes->post('/setMatkulDitawarkan/matkulKurikulum/pratikum', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::pratikum');
$routes->post('/setMatkulDitawarkan/prodiProgramKuliah', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::prodiProgramKuliah');
$routes->post('/setMatkulDitawarkan/prodiProgramKuliahEdit', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::prodiProgramKuliahEdit');
$routes->post('setMatkulDitawarkan/cari', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::cari');
$routes->post('setMatkulDitawarkan/cariMahasiswa', '\Modules\SetMatkulDitawarkan\Controllers\SetMatkulDitawarkan::cariMahasiswaDitawarkan');
