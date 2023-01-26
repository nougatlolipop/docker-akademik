<?php

/* 
    Define TagihanLain Routes
*/
$routes->get('tagihanLain', '\Modules\TagihanLain\Controllers\TagihanLain::index');
$routes->post('tagihanLain/add', '\Modules\TagihanLain\Controllers\TagihanLain::add');
