<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title . " | " . lang('Auth.appName'); ?></title>

    <!-- Favicon -->
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
    <style>
        .loader {
            border: 5px solid #f3f3f3;
            /* Light grey */
            border-top: 5px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 25px;
            height: 25px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .header-card {
            height: 50px;
            background-color: #1a2b3c;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .footer-card {
            height: 50px;
            background-color: #1a2b3c;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    </style>



</head>

<!-- <body class="fixed-top-navbar" onload="loadMahasiswa()"> -->

<body class="fixed-top-navbar">
    <?= $this->renderSection('content'); ?>

    <?= view('layout/templateFooter'); ?>

    <!-- Backend Bundle JavaScript -->
    <script src=" <?= base_url() ?>/assets/js/backend-bundle.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url() ?>/assets/js/customizer.js"></script>

    <!-- Flextree Javascript-->
    <script src="<?= base_url() ?>/assets/js/flex-tree.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/tree.js"></script>

    <!-- Table Treeview JavaScript -->
    <script src="<?= base_url() ?>/assets/js/table-treeview.js"></script>

    <!-- Masonary Gallery Javascript -->
    <script src="<?= base_url() ?>/assets/js/masonry.pkgd.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/imagesloaded.pkgd.min.js"></script>

    <!-- Fullcalender Javascript -->
    <script src='<?= base_url() ?>/assets/vendor/fullcalendar/core/main.js'></script>
    <script src='<?= base_url() ?>/assets/vendor/fullcalendar/daygrid/main.js'></script>
    <script src='<?= base_url() ?>/assets/vendor/fullcalendar/timegrid/main.js'></script>
    <script src='<?= base_url() ?>/assets/vendor/fullcalendar/list/main.js'></script>

    <!-- SweetAlert JavaScript -->
    <script src="<?= base_url() ?>/assets/js/sweetalert.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url() ?>/assets/js/chart-custom.js"></script>

    <!-- slider JavaScript -->
    <script src="<?= base_url() ?>/assets/js/slider.js"></script>

    <!-- app JavaScript -->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <script src="<?= base_url() ?>/assets/pulltorefresh.js/dist/pulltorefresh.js" type="text/javascript"></script>

    <script src="https://unpkg.com/hammer-touchemulator@0.0.2/touch-emulator.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script>
        TouchEmulator()
    </script>
    <script src="<?= base_url() ?>/js/script-mahasiswa.js"></script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/637c48eeb0d6371309d05a0b/1gienpp6v';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->


</body>

</html>