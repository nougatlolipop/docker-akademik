<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>UMSU Academy</title>
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.ico" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/backend.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/@icon/dripicons/dripicons.css">
    <link rel='stylesheet' href='<?= base_url() ?>/assets/vendor/fullcalendar/core/main.css' />
    <link rel='stylesheet' href='<?= base_url() ?>/assets/vendor/fullcalendar/daygrid/main.css' />
    <link rel='stylesheet' href='<?= base_url() ?>/assets/vendor/fullcalendar/timegrid/main.css' />
    <link rel='stylesheet' href='<?= base_url() ?>/assets/vendor/fullcalendar/list/main.css' />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/mapbox/mapbox-gl.css">
</head>

<body>
    <div class="wrapper">
        <section class="login-content">
            <img src="<?= base_url() ?>/assets/images/login/02.png" class="lb-img" alt="">
            <img src="<?= base_url() ?>/assets/images/login/03.png" class="rb-img" alt="">
            <div class="container h-100">
                <div class="row align-items-center justify-content-center h-100">
                    <div class="col-12">
                        <div class="row align-items-center">
                            <div class="col-lg-6 rmb-30">
                                <img src="<?= base_url() ?>/assets/images/login/01.png" class="img-fluid w-80" alt="">
                            </div>
                            <?= $this->renderSection('main') ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="<?= base_url() ?>/assets/js/backend-bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/flex-tree.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/tree.js"></script>
    <script src="<?= base_url() ?>/assets/js/table-treeview.js"></script>
    <script src="<?= base_url() ?>/assets/js/masonry.pkgd.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/mapbox-gl.js"></script>
    <script src="<?= base_url() ?>/assets/js/mapbox.js"></script>
    <script src='<?= base_url() ?>/assets/vendor/fullcalendar/core/main.js'></script>
    <script src='<?= base_url() ?>/assets/vendor/fullcalendar/daygrid/main.js'></script>
    <script src='<?= base_url() ?>/assets/vendor/fullcalendar/timegrid/main.js'></script>
    <script src='<?= base_url() ?>/assets/vendor/fullcalendar/list/main.js'></script>
    <script src="<?= base_url() ?>/assets/js/sweetalert.js"></script>
    <script src="<?= base_url() ?>/assets/js/vector-map-custom.js"></script>
    <script src="<?= base_url() ?>/assets/js/customizer.js"></script>
    <script src="<?= base_url() ?>/assets/js/chart-custom.js"></script>
    <script src="<?= base_url() ?>/assets/js/slider.js"></script>
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
</body>

</html>