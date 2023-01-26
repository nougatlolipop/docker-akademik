<?php

/* 
    Define FdrTranskrip Routes
*/
$routes->get('fdrTranskrip', '\Modules\FdrTranskrip\Controllers\FdrTranskrip::index');
$routes->post('fdrTranskrip', '\Modules\FdrTranskrip\Controllers\FdrTranskrip::getTranskrip');
