<?php

/* 
    Define Krs Routes
*/
$routes->get('tagihan', '\Modules\Tagihan\Controllers\Tagihan::index');
$routes->post('tagihan/tambah', '\Modules\Tagihan\Controllers\Tagihan::add');
$routes->add('tagihan/ubah/(:num)', '\Modules\Tagihan\Controllers\Tagihan::edit/$1');
$routes->delete('tagihan/hapus/(:num)', '\Modules\Tagihan\Controllers\Tagihan::delete/$1');
$routes->post('tagihan/ubahTagihan', '\Modules\Tagihan\Controllers\Tagihan::ubahTagihan');
$routes->post('tagihan/ubahTagihanHer', '\Modules\Tagihan\Controllers\Tagihan::ubahTagihanHer');
$routes->post('tagihan/ubahTagihanLain', '\Modules\Tagihan\Controllers\Tagihan::ubahTagihanLain');
$routes->post('tagihan/ubahMetodeTagihan', '\Modules\Tagihan\Controllers\Tagihan::ubahMetodeTagihan');
