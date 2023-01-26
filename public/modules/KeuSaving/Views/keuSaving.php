<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/keuSaving" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[1]; ?></li>
            </ol>
        </nav>

        <?php if (empty($mhs) && isset($_GET['npm']) ? $_GET['npm'] != null : ""  && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Data Mahasiswa <strong>' . session()->getFlashdata('keterangan') . '</strong> Tidak Ditemukan']]); ?>
        <?php elseif (!empty($mhs) && isset($_GET['npm']) ? $_GET['npm'] != null : ""  && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', 'Data Mahasiswa <strong>' . session()->getFlashdata('keterangan') . '</strong> Berhasil Dimuat']]); ?>
        <?php endif; ?>

        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?= $title; ?></h4>
                        </div>
                        <?php if (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) : ?>
                            <div class="iq-search-bar device-search float-right">
                                <button class="btn btn-sm bg-primary float-right" data-toggle="modal" data-target="#tambah"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                                </button>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="card-body">
                        <form action="/keuSaving/cari" method="get" class="searchbox">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control npm" placeholder="Cari Menggunakan NPM...." name="npm" value="<?= isset($_GET['npm']) ? $_GET['npm'] : "" ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary"><span class="las la-search"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div style="padding-top:60px; padding-bottom:10px;">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-body rounded bg-primary mt-3">
                                    <div class="ecommerce-avtar" style="margin-top: -90px; margin-bottom: 20px">
                                        <img src="<?= base_url() ?>/assets/images/layouts/layout-3/avatar-3.png" class="img-fluid avatar-100" style="height: 150px; width: 150px; line-height: 150px; min-width: 150px;" alt=" image">
                                    </div>
                                    <div class="row iq-profile-ecommerce">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="card-body mathew-icon">
                                                <div class="media align-items-center">
                                                    <i class="fas fa-user text-white font-icon"></i>
                                                    <div class="media-body  ml-3">
                                                        <h3 class="text-white"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->mahasiswaNpm : "-" ?></h3>
                                                        <p class="mb-0"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->mahasiswaNamaLengkap : "-" ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 mt-3 mt-md-0">
                                            <div class="card-body mathew-icon">
                                                <div class="media align-items-center">
                                                    <i class="fas fa-school text-white font-icon"></i>
                                                    <div class="media-body ml-3">
                                                        <h3 class="text-white"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->fakultasNama : "-" ?></h3>
                                                        <p class="mb-0"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->prodiNama : "-" ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 mt-3 mt-md-0">
                                            <div class="card-body mathew-icon">
                                                <div class="media align-items-center">
                                                    <i class="fas fa-graduation-cap text-white font-icon f-small"></i>
                                                    <div class="media-body ml-3">
                                                        <h3 class="text-white"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->programKuliahNama : "-" ?></h3>
                                                        <p class="mb-0"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->waktuNama : "-" ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="card card-block card-stretch card-height">
                                            <div class="card-body bg-white rounded p-5">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="rounded iq-card-icon bg-primary"><i class="ri-wallet-fill"></i>
                                                    </div>
                                                    <div class="text-right">
                                                        <h2 class="mb-0 text-primary"><span class=""><?= number_to_currency((isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs) && $sv[0]->savingNominal != null) ? $sv[0]->savingNominal : 0, 'Rp.', 'en_ID', 0); ?></span></h2>
                                                        <h5 class="font-italic text-primary"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs) && $sv[0]->savingNominal != null && $sv[0]->savingNominal != 0) ? terbilang($sv[0]->savingNominal) : 'Nol'; ?> rupiah</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-block card-stretch card-height  position-relative overflow-hidden card-overlay-image">
                                <div class="card-body p-5">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="iq-cart-image">
                                            <div class="row">
                                                <div class="mr-3 mt-2">
                                                    <i class="ri-wallet-fill text-primary" style="font-size: 580%;text-align:center;margin-right:10px"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-primary"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->fakultasNama . " / " . $mhs[0]->fakultasNama : "Fakultas / Prodi" ?></h4>
                                                    <h1 class="mt-3 text-primary"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->mahasiswaNamaLengkap : "Nama Lengkap" ?></h1>
                                                    <h5 class="mt-3 text-primary"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->mahasiswaNpm : "NPM" ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="iq-cart-text">
                                            <div>
                                                <h1 class="text-primary"><?= number_to_currency((isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs) && $sv[0]->savingNominal != null) ? $sv[0]->savingNominal : 0, 'Rp.', 'en_ID', 0); ?></h1>
                                                <h3 class="font-italic text-primary"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs) && $sv[0]->savingNominal != null && $sv[0]->savingNominal != 0) ? terbilang($sv[0]->savingNominal) : 'Nol'; ?> rupiah</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="overlay-image svg-primary">
                                    <svg height="100%" viewBox="0 0 264 113" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M108.5 68C82.4829 96.2795 31.0226 108.712 4.54413 112H259C262.2 112 263.333 108.667 263.5 107V6C263.5 1.6 259.167 0.166667 257 0H192.5C172.1 3.2 128 46.6667 108.5 68Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card card-block card-stretch card-height salon-2-back" style="background: url(<?= base_url() ?>/assets/images/layouts/layout-12/11.png) no-repeat; background-size: cover;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="mt-4 mb-4">
                                                <h4><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->mahasiswaNamaLengkap : "Nama Lengkap" ?> (<?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->mahasiswaNpm : "NPM" ?>)</h4>
                                                <h1 class="mt-5"><?= number_to_currency((isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs) && $sv[0]->savingNominal != null) ? $sv[0]->savingNominal : 0, 'Rp.', 'en_ID', 0); ?></h1>
                                                <h5 class="mt-3 font-italic"><?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs) && $sv[0]->savingNominal != null && $sv[0]->savingNominal != 0) ? terbilang($sv[0]->savingNominal) : 'Nol'; ?> rupiah</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- start modal tambah -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="/keuSaving/tambah" method="post">
                <?= csrf_field() ?>
                <div class=" modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="npm" value="<?= isset($_GET['npm']) ? $_GET['npm'] : "" ?>">
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" class="form-control" name="nominal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal tambah -->
<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>