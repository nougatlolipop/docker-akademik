<?php

/* 
    Define Krs Routes
*/
$routes->get('syncMhs', '\Modules\SyncMhs\Controllers\SyncMhs::index');
$routes->get('syncMhsAccount', '\Modules\SyncMhs\Controllers\SyncMhs::syncAccount');
$routes->post('createMhsAccount', '\Modules\SyncMhs\Controllers\SyncMhs::createMhsAccount');
