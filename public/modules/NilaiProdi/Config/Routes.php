<?php

/* 
    Define NilaiProdi Routes
*/
$routes->get('nilaiProdi', '\Modules\NilaiProdi\Controllers\NilaiProdi::index');
$routes->add('nilaiProdi/ubah', '\Modules\NilaiProdi\Controllers\NilaiProdi::edit');
