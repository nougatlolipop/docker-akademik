<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title . " | " . lang('Auth.appName'); ?>
    </title>

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
</head>

<body class="sidebar-bg-box  ">

    <input type="hidden" name="sessionEmail" value="<?= user()->email ?>">

    <?= $this->renderSection('content'); ?>

    <!-- Backend Bundle JavaScript -->
    <script src="<?= base_url() ?>/assets/js/backend-bundle.min.js"></script>

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
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>


    <!-- SweetAlert JavaScript -->
    <script src="<?= base_url() ?>/assets/js/sweetalert.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url() ?>/assets/js/customizer.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url() ?>/assets/js/chart-custom.js"></script>

    <!-- slider JavaScript -->
    <script src="<?= base_url() ?>/assets/js/slider.js"></script>

    <!-- app JavaScript -->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <script src="<?= base_url() ?>/js/script-kurikulum-ditawarkan.js"></script>

    <script src="<?= base_url() ?>/js/script-rombel-dosen-pa.js"></script>

    <script src="<?= base_url() ?>/js/script-filter-krs.js"></script>

    <script src="<?= base_url() ?>/js/script-sks-disetujui.js"></script>

    <script src="<?= base_url() ?>/js/script-keuangan.js"></script>

    <script src="<?= base_url() ?>/js/script-dosen.js"></script>

    <script src="<?= base_url() ?>/js/script-cetak-dokumen.js"></script>

    <?php $uri = current_url(true); ?>
    <?php if ($uri->getSegment(1) == 'keuTeller') : ?>
        <script src="<?= base_url() ?>/js/script-teller.js"></script>
    <?php endif ?>

    <?php if ($uri->getSegment(1) == 'fdrMahasiswa' || $uri->getSegment(1) == 'fdrAktivitas') : ?>
        <script src="<?= base_url() ?>/js/script-feeder.js"></script>
    <?php endif ?>

    <script>
        function labelDokumen() {
            const dokumen = document.querySelector('#customFile');
            const dokumenLabel = document.querySelector('.custom-file-label');

            dokumenLabel.textContent = dokumen.files[0].name;
        }

        function labelDokumenEdit(id) {
            const dokumen = document.querySelector('#customFile' + id);
            const dokumenLabel = document.querySelector('.custom-file-label' + id);

            dokumenLabel.textContent = dokumen.files[0].name;
        }
    </script>
</body>

</html>