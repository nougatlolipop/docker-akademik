<?php

/* 
    Define FdrAktivitas Routes
*/
$routes->get('fdrAktivitas', '\Modules\FdrAktivitas\Controllers\FdrAktivitas::index');
$routes->post('fdrAktivitas', '\Modules\FdrAktivitas\Controllers\FdrAktivitas::detail');
