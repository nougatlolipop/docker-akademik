<?php

/* 
    Define SetProdiProgKuliah Routes
*/
$routes->get('setProdiProgKuliah', '\Modules\SetProdiProgKuliah\Controllers\SetProdiProgKuliah::index');
$routes->post('setProdiProgKuliah/tambah', '\Modules\SetProdiProgKuliah\Controllers\SetProdiProgKuliah::add');
$routes->add('setProdiProgKuliah/ubah/(:num)', '\Modules\SetProdiProgKuliah\Controllers\SetProdiProgKuliah::edit/$1');
$routes->delete('setProdiProgKuliah/hapus/(:num)', '\Modules\SetProdiProgKuliah\Controllers\SetProdiProgKuliah::delete/$1');
