<?= $this->extend('layout/templateHomeMahasiswa'); ?>

<?= $this->section('content'); ?>

<!-- Wrapper Start -->
<?php $mhsSesion = user(); ?>
<div class="wrapper">
    <div class="iq-top-navbar">
        <div class="iq-navbar-custom d-flex align-items-center justify-content-between">
            <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                <a href="<?= base_url() ?>" class="header-logo">
                    <img src="<?= base_url() ?>/assets/images/logo.png" class="img-fluid rounded-normal" alt="logo">
                </a>
            </div>
            <div class="iq-menu-horizontal">
            </div>
            <nav class="navbar navbar-expand-lg school-navbar navbar-light p-0">
                <div class="change-mode">
                    <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                        <div class="custom-switch-inner">
                            <p class="mb-0"> </p>
                            <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true">
                            <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                <span class="switch-icon-left"><i class="a-left"></i></span>
                                <span class="switch-icon-right"><i class="a-right"></i></span>
                            </label>
                        </div>
                    </div>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">
                        <li class="nav-item iq-full-screen"><a href="#" class="" id="btnFullscreen"><i class="ri-fullscreen-line"></i></a></li>
                        <li class="caption-content">
                            <a href="#" class="iq-user-toggle">
                                <img src="<?= base_url() ?>/assets/images/layouts/layout-3/avatar-3.png" class="img-fluid rounded" alt="user">
                            </a>
                            <div class="iq-user-dropdown">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center mb-0">
                                        <div class="header-title">
                                            <h4 class="card-title mb-0">Profile</h4>
                                        </div>
                                        <div class="close-data text-right badge badge-primary cursor-pointer"><i class="ri-close-fill"></i></div>
                                    </div>
                                    <div class="data-scrollbar" data-scroll="2">
                                        <div class="card-body">
                                            <div class="profile-header">
                                                <div class="cover-container text-center">
                                                    <img src="<?= base_url() ?>/assets/images/layouts/layout-3/avatar-3.png" alt="profile-bg" class="rounded img-fluid avatar-80">
                                                    <div class="profile-detail mt-3">
                                                        <h3 id='npmMahasiswa'><?= $mhsSesion->username; ?></h3>
                                                        <p class="mb-1"><?= $mhsSesion->email; ?></p>
                                                    </div>
                                                    <form action="/logout" method="POST">
                                                        <button type="submit" class="btn btn-primary">Sign Out</button>
                                                    </form>
                                                </div>
                                                <div class="profile-details my-4">
                                                    <a class="iq-sub-card bg-primary-light rounded-small p-2">
                                                        <div class="media align-items-center">
                                                            <div class="rounded iq-card-icon-small">
                                                                <i class="ri-file-user-line"></i>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">My Profile</h6>
                                                                <p class="mb-0 font-size-12">View personal profile details.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a class="iq-sub-card bg-danger-light rounded-small p-2">
                                                        <div class="media align-items-center">
                                                            <div class="rounded iq-card-icon-small">
                                                                <i class="ri-profile-line"></i>
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <h6 class="mb-0 ">Edit Profile</h6>
                                                                <p class="mb-0 font-size-12">Modify your personal details.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="personal-details">
                                                    <h5 class="card-title mb-3 mt-3">Personal Info</h5>
                                                    <div class="row align-items-center mb-2">
                                                        <div class="col-sm-6">
                                                            <h6>Birthday</h6>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="mb-0"><?= reformat($mahasiswa[0]->mahasiswaTanggalLahir) ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center mb-2">
                                                        <div class="col-sm-6">
                                                            <h6>Phone</h6>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="mb-0"><?= $mahasiswa[0]->mahasiswaNoHp ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center mb-2">
                                                        <div class="col-sm-6">
                                                            <h6>Email</h6>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="mb-0"><?= $mahasiswa[0]->mahasiswaEmail ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="content-page">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-block card-stretch card-height position-relative overflow-hidden card-overlay-image">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Perkembangan Akademik</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-inline">
                                            <li class="mb-4">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="icon iq-icon-box rounded bg-warning-light text-center">
                                                        <i class="fas fa-wave-square"></i>
                                                    </div>
                                                    <div class="iq-result-info">
                                                        <h6>Indeks Prestasi</h6>
                                                        <small id='ipk'><?= $perkembangan[0]->ipk ?></small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-4">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="icon iq-icon-box rounded bg-info-light text-center">
                                                        <i class="fab fa-cloudscale"></i>
                                                    </div>
                                                    <div class="iq-result-info">
                                                        <h6>Jumlah SKS diambil</h6>
                                                        <small><?= $perkembangan[0]->sksDiambil ?></small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-4">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="icon iq-icon-box rounded bg-danger-light text-center">
                                                        <i class="fab fa-battle-net"></i>
                                                    </div>
                                                    <div class="iq-result-info">
                                                        <h6>Jumlah SKS lulus</h6>
                                                        <small><?= $perkembangan[0]->sksLulus ?></small>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- <div class="card border">
                                            <div class="header-card"></div>
                                            <div class="card-content">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate officia neque repudiandae, nihil maxime provident consequatur earum aspernatur nostrum obcaecati amet quis mollitia temporibus assumenda culpa voluptas, aliquid, rem ipsam!
                                            </div>
                                            <div class="footer-card"></div>
                                        </div> -->
                                    </div>
                                </div>

                            </div>
                            <div class="overlay-image svg-info">
                                <svg height="100%" viewBox="0 0 250 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M108.5 68C82.4829 96.2795 31.0226 108.712 4.54413 112H259C262.2 112 263.333 108.667 263.5 107V6C263.5 1.6 259.167 0.166667 257 0H192.5C172.1 3.2 128 46.6667 108.5 68Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
                <?php endif; ?>
                <?php if (!empty(session()->getFlashdata('danger'))) : ?>
                    <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-check-line', session()->getFlashdata('danger')]]); ?>
                <?php endif; ?>
                <div class="row">
                    <?= $menu ?>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Dosen Pengampu</h4>
                                </div>
                                <div class="card-header-toolbar d-flex align-items-center">
                                    <a href="#!" class="btn btn-sm btn-outline-primary view-more">View All</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php if ($dosenPengampu == null) : ?>
                                    <div class="list-group-item">
                                        <p class="mb-0" style="text-align:center ;">Kamu belum mempunyai dosen pengampu </p>
                                    </div>
                                <?php else : ?>
                                    <?php $no = 0;
                                    foreach ($dosenPengampu as $dosen) : $no++; ?>
                                        <?php if ($no <= 3) : ?>
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="<?= ($dosen->jk == 'L') ? base_url('/assets/images/user/user-1.jpg') : base_url('/assets/images/user/05.jpg') ?>" class="img-fluid avatar-80 rounded" alt="image">
                                                <div class="teacher-detail ml-3">
                                                    <strong><?= $dosen->dosenNamaLengkap ?></strong>
                                                    <p class="mb-0"><?= $dosen->emailGeneral ?> <?= ($dosen->emailCorporate == null) ? '' : ' / ' . $dosen->emailCorporate ?></p>
                                                    <small class="mb-0">mobile : <?= $dosen->noHandphone ?> </small><br>
                                                    <small class="mb-0">wa : <?= ($dosen->noWA == null) ? '-' : $dosen->noWA ?></small>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- start modal fakultas -->
<?php foreach ($menuMhs as $row) : ?>
    <div class="modal fade" id="modalMahasiswa<?= $row->title ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $row->title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if ($row->title == "Pembayaran") : ?>
                        <ul class="nav nav-tabs justify-content-end" id="myTab-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tagihan-tab-end" data-toggle="tab" href="#tagihan-end" role="tab" aria-controls="tagihan" aria-selected="true">Tagihan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="riwayat-tab-end" data-toggle="tab" href="#riwayat-end" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tabPembayaran">
                            <div class="tab-pane fade show active" id="tagihan-end" role="tabpanel" aria-labelledby="tagihan-tab-end">
                                <?php if (count($jadwalLunas) > 0) : ?>
                                    <?= view('layout/templateAlert', ['msg' => ['warning', 'ri-check-line', 'Batas pemilihan metode pembayaran lunas berakhir pada tanggal <strong>' . $jadwalLunas[0]->selesai . '</strong>']]); ?>
                                <?php endif ?>
                                <?php if (count($tagihan) > 0) : ?>
                                    <div class="d-flex w-100 justify-content-between p-2">
                                        <container class="mt-2">
                                            <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                                <div class="custom-switch-inner">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitchAdd" data-id="<?= $tagihan[0]->idTagihan ?>" <?= ($isLunas[0]->tagihMetodeLunas == '1') ? 'checked' : '' ?> name="metodeBayar" onchange="ubahMetodePembayaran()">
                                                    <label class="custom-control-label" for="customSwitchAdd">
                                                        <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                                        <span class="switch-icon-right"><i class="fa fa-times"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <label>Lunas</label>
                                        </container>
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-2" onclick="biayaLain()"><i class="fa fa-plus"></i> Biaya Tambahan</button>
                                    </div>
                                <?php else : ?>
                                    <button type="button" class="btn btn-sm btn-outline-primary mb-2 float-right" onclick="biayaLain()"><i class="fa fa-plus"></i> Biaya Tambahan</button>
                                <?php endif ?>
                                <div class="list-group tagihanList">
                                    <?php $total = 0;
                                    foreach ($tagihan as $tagih) : ?>
                                        <?php $id = ($tagih->jenisBiayaId == 2 || $tagih->jenisBiayaId == 3 || $tagih->jenisBiayaId == 25) ? $tagih->idTagihan . ',' . $tagih->tahap . ',' . $tagih->jenisBiayaId  : $tagih->idTagihan . ',' . $tagih->jenisBiayaId . ',' . $tagih->jenisBiayaId; ?>
                                        <?php $dataIt = (reformat($tagih->endDate) > date('Y-m-d')) ? 'data-id="' .  $id . '"' : ""; ?>
                                        <?php if ($tagih->forceToPay == '1') {
                                            $total = $total + $tagih->nominal;
                                        } ?>
                                        <div class="list-group-item <?= ($tagih->jenisBiayaId == 2 || $tagih->jenisBiayaId == 3 || $tagih->jenisBiayaId == 25) ? 'itemtagih' : '' ?> <?= (reformat($tagih->endDate) < date('Y-m-d')) ? "bg-primary-light" :  "" ?> <?= (reformat($tagih->endDate) > date('Y-m-d') && $tagih->forceToPay == '1')  ? "bg-primary" :  "" ?>" <?= $dataIt ?> data-tahap="<?= $tagih->tahap ?>" <?= (reformat($tagih->endDate) < date('Y-m-d')) ? "" :  "onclick=ubahTagihan('" . $id . "')" ?>>
                                            <div class="d-flex w-100 justify-content-between">
                                                <strong class="mb-0"><?= $tagih->jenisBiayaNama ?><?= ($tagih->mkNama != '') ? ' : ' . $tagih->mkNama : '' ?><?= ' - Tahap ' . $tagih->tahap ?></strong>
                                                <small><?= reformat($tagih->startDate) . ' s/d ' . reformat($tagih->endDate) ?></small>
                                            </div>
                                            <p class="mb-0"><?= number_to_currency($tagih->nominal, 'Rp.', 'en_ID', 0); ?></p>
                                            <small class="diskon" data-tahap="<?= $tagih->tahap ?>">Diskon : <?= number_to_currency($tagih->diskon, 'Rp.', 'en_ID', 0); ?></small>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="d-flex w-100 justify-content-between p-2">
                                    <h4>Sub Tagihan</h4>
                                    <h4 id="total"><?= number_to_currency($total, 'Rp.', 'en_ID', 0); ?></h4>
                                </div>
                                <div class="d-flex w-100 justify-content-between p-2 dompetMhs" <?= ($saldoDompet > 0) ? '' : 'style="display: none !important"' ?>>
                                    <h4>Saldo Dompet</h4>
                                    <h4 id="dompet"><?= number_to_currency($saldoDompet, 'Rp.', 'en_ID', 0); ?></h4>
                                </div>
                                <div class="d-flex w-100 justify-content-between p-2">
                                    <h4>Total Tagihan</h4>
                                    <h4 id="grandTotal"><?= number_to_currency($total - $saldoDompet, 'Rp.', 'en_ID', 0); ?></h4>
                                </div>
                                <form action="/mahasiswa/createInvoice" method="get">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="sumbit" class="btn btn-sm btn-primary" name="npm" value="<?= $mhsSesion->username ?>">Bayar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="riwayat-end" role="tabpanel" aria-labelledby="riwayat-tab-end">
                                <div class="list-group">
                                    <?php foreach ($riwayatPembayaran as $riwayat) : ?>
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <strong class="mb-0"><?= $riwayat->refJenisBiayaKode . ' - Tahap ' . $riwayat->tahap ?></strong>
                                                <small><?= $riwayat->paymentTanggalBayar ?></small>
                                            </div>
                                            <p class="mb-0"><?= number_to_currency($riwayat->nominal, 'Rp.', 'en_ID', 0); ?></p>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($row->title == "KRS") : ?>
                        <ul class="nav nav-tabs justify-content-end" id="myTab-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="isikrs-tab-end" data-toggle="tab" href="#isikrs-end" role="tab" aria-controls="isikrs" aria-selected="true">Penginputan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cetakkrs-tab-end" data-toggle="tab" href="#cetakkrs-end" role="tab" aria-controls="cetakkrs" aria-selected="false">Cetak</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="isikrs-end" role="tabpanel" aria-labelledby="isikrs-tab-end">
                                <div class="alert alert-warning" role="alert">
                                    <div class="iq-alert-icon">
                                        <i class="ri-check-line"></i>
                                    </div>
                                    <div class="iq-alert-text sksMax">
                                        <div class="loader"></div> Memuat Data, Mohon tunggu sebentar..!!!
                                    </div>
                                </div>
                                <form action="mahasiswa/tambahKrs" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="list-group mb-3" id="dataMK">
                                        <div class="list-group-item">
                                            <p class="mb-0">Memuat Informasi Mahasiswa</p>
                                        </div>
                                    </div>
                                    <div id="btnSimpan">
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="cetakkrs-end" role="tabpanel" aria-labelledby="cetakkrs-tab-end">
                                <?php if ($krs == null) : ?>
                                    <div class="list-group-item">
                                        <p class="mb-0" style="text-align:center ;">Data tidak ditemukan</p>
                                    </div>
                                <?php else : ?>
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <?php $no = 0;
                                        foreach ($krs as $krsMhs) : $no++; ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?= ($no == 1) ? 'active' : '' ?>" id="pills-krs-<?= $krsMhs->tahunAjaranId ?>-tab" data-toggle="pill" href="#pills-krs-<?= $krsMhs->tahunAjaranId ?>" role="tab" aria-controls="pills-krs-<?= $krsMhs->tahunAjaranId ?>" aria-selected="true"><?= $krsMhs->tahunAjaranNama ?></a>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                    <div class="tab-content">
                                        <?php $no = 0;
                                        foreach ($krs as $dataKrs) : $no++; ?>
                                            <div class="tab-pane fade show <?= ($no == 1) ? 'active' : '' ?> " id="pills-krs-<?= $dataKrs->tahunAjaranId ?>" role="tabpanel" aria-labelledby="pills-krs-<?= $dataKrs->tahunAjaranId ?>-tab">
                                                <ul class="list-group mb-3">
                                                    <?php foreach (json_decode($dataKrs->krsMatkulTawarkan)->data as $data) : ?>
                                                        <?php $mk = getMatkul($data->matkulId)[0]; ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <?= $mk->matkulKode ?> - <?= $mk->matkulNama ?> (<?= reformatDosen($data->matkulId, $dosenMk) ?>)
                                                            <span class="badge badge-primary badge-pill"><?= $mk->setMatkulKurikulumSks ?> SKS</span>
                                                        </li>
                                                    <?php endforeach ?>
                                                </ul>
                                                <button class="btn btn-primary float-right">Cetak <?= $dataKrs->tahunAjaranNama ?></button>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php elseif ($row->title == "KHS") : ?>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <?php $no = 0;
                            foreach ($khs as $khsMhs) : $no++; ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= ($no == 1) ? 'active' : '' ?>" id="pills-khs-<?= $khsMhs->tahunAjaranId ?>-tab" data-toggle="pill" href="#pills-khs-<?= $khsMhs->tahunAjaranId ?>" role="tab" aria-controls="pills-khs-<?= $khsMhs->tahunAjaranId ?>" aria-selected="true"><?= $khsMhs->tahunAjaranNama ?></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        <div class="tab-content">
                            <?php if ($khs == null) : ?>
                                <div class="list-group-item">
                                    <p class="mb-0" style="text-align:center ;">Kamu belum mempunyai KHS</p>
                                </div>
                            <?php else : ?>
                                <?php $no = 0;
                                foreach ($khs as $dataKhs) : $no++; ?>
                                    <div class="tab-pane fade show <?= ($no == 1) ? 'active' : '' ?> " id="pills-khs-<?= $dataKhs->tahunAjaranId ?>" role="tabpanel" aria-labelledby="pills-khs-<?= $dataKhs->tahunAjaranId ?>-tab">
                                        <div class="list-group mb-3">
                                            <?php foreach (json_decode($dataKhs->khsNilaiMatkul)->data as $data) : ?>
                                                <?php $mkKhs = getMatkul($data->matkulId)[0]; ?>
                                                <?php $nil = getNilaiAngka([$dataKhs->prodiId, $data->gradeId, $nilaiAll]) ?>
                                                <?php $grade = ($data->gradeId == 28 && $data->status == 0) ? 'T' : $nil->gradeNilaiKode ?>
                                                <div class="list-group-item list-group-item-action">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <strong class="mb-0"><?= $mkKhs->matkulKode ?> - <?= $mkKhs->matkulNama ?></strong>
                                                    </div>
                                                    <p class="mb-0">Nilai : <?= $grade ?></p>
                                                    <p class="mb-0"><?= $mkKhs->setMatkulKurikulumSks ?> SKS</p>
                                                    <small><?= reformatdosen($data->matkulId, $dosenMk) ?></small>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                        <button class="btn btn-primary float-right">Cetak <?= $dataKhs->tahunAjaranNama ?></button>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    <?php elseif ($row->title == "Transkrip") : ?>
                        <?php if ($transkrip == null) : ?>
                            <div class="list-group-item">
                                <p class="mb-0" style="text-align:center ;">Kamu belum mempunyai transkrip nilai</p>
                            </div>
                        <?php else : ?>
                            <ul class="list-group mb-3">
                                <?php foreach ($group as $grp) : ?>
                                    <?php if (hitungItem($transkrip, $grp->matkulGroupId, 'matkulGroupId') > 0) : ?>
                                        <li class="list-group-item"><strong><?= $grp->matkulGroupKode; ?></strong></li>
                                    <?php endif ?>
                                    <?php foreach ($transkrip as $row) : ?>
                                        <?php $mk = getMatkulByMatkul($row->matkulId)[0]; ?>
                                        <?php if ($grp->matkulGroupId === $mk->matkulGroupId) : ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <small class="ml-3"><?= $mk->matkulKode ?>-<?= $mk->matkulNama ?> (<?= $mk->studiLevelKode ?>)</small>
                                                <span class="badge">
                                                    <?php if (in_array($mk->matkulId, array_column($nilai, 'matkulId'))) : ?>
                                                        <?php foreach ($nilai as $n) : ?>
                                                            <?php if ($mk->matkulId == $n['matkulId']) : ?>
                                                                <?php if ($n['status'] == 1) : ?>
                                                                    <span class="<?= ($n['gradeId'] == 28 || $n['gradeId'] == 27) ? 'text-danger' : 'text-primary' ?>">
                                                                        <?= getNilaiAngka([$mk->setKurikulumTawarProdiId, $n['gradeId'], $nilaiAll]) ?>
                                                                    </span>
                                                                <?php else : ?>
                                                                    <span>T</span>
                                                                <?php endif ?>
                                                            <?php endif ?>
                                                        <?php endforeach ?>
                                                    <?php else : ?>
                                                        <span>T</span>
                                                    <?php endif ?>
                                                </span>
                                            </li>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                            </ul>
                            <button class="btn btn-primary float-right">Cetak</button>
                        <?php endif ?>
                    <?php elseif ($row->title == "Jadwal") : ?>
                        <?php $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']; ?>
                        <ul class="nav nav-tabs justify-content-center" id="myTab-1" role="tablist">
                            <?php foreach ($hari as $day) : ?>
                                <li class="nav-item">
                                    <a class="nav-link<?= ($day == hari_ini()) ? ' active' : '' ?>" id="<?= $day ?>-tab" data-toggle="tab" href="#<?= $day ?>" role="tab" aria-controls="<?= $day ?>" aria-selected="true"><?= $day; ?></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        <div class="tab-content" id="myTabContent-2">
                            <?php foreach ($hari as $day) : ?>
                                <div class="tab-pane fade show<?= ($day == hari_ini()) ? ' active' : '' ?>" id="<?= $day ?>" role="tabpanel" aria-labelledby="<?= $day ?>-tab">
                                    <?php if ($jadwalKuliah == null) : ?>
                                        <div class="list-group-item">
                                            <p class="mb-0" style="text-align:center ;">Kamu belum mempunyai jadwal kuliah</p>
                                        </div>
                                    <?php else : ?>
                                        <?php foreach ($jadwalKuliah as $jadwal) : ?>
                                            <?php $jadwalHari = [] ?>
                                            <?php array_push($jadwalHari, $jadwal->hari) ?>
                                            <?php $filter = array_diff($hari, $jadwalHari); ?>
                                            <?php if ($jadwal->hari == $day) : ?>
                                                <div class="media align-items-center border rounded p-3 mb-3">
                                                    <div>
                                                        <a href="JavaScript:Void(0);"><img src="<?= base_url('/assets/images/user/user-1.jpg') ?>" class="img-fluid avatar-60 rounded" alt="image"></a>
                                                    </div>
                                                    <div class="media-body ml-3">
                                                        <strong class="mb-2"><?= $jadwal->namaMatkul ?></strong>
                                                        <div class="d-flex align-items-center">
                                                            <small class="mb-0">Dosen: <b><?= reformatdosen($jadwal->idMatkulTawar, $dosenMk) ?></b> | <?= $jadwal->jadwalKuliah ?> (<?= $jadwal->namaRuang ?>)</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                            <?php if (in_array($day, $filter)) : ?>
                                                <div class="list-group-item">
                                                    <p class="mb-0" style="text-align:center ;">Kamu tidak mempunyai jadwal di hari ini</p>
                                                </div>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal fakultas ;-->

<div class="modal fade" id="biayaLain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tagihan Lain</h5>
                <button type="button" class="close" onclick="backMainModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-responsive-md table-striped ">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center">No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($tagihanLain == null) : ?>
                            <tr>
                                <td style="text-align:center;" colspan="3">Pembayaran lain belum diinput oleh Admin</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($tagihanLain as $tLain) : ?>
                                <tr>
                                    <td><input type='checkbox' name='tagihanLain[]' value='<?= $tLain->tarifLainId ?>' class='checkbox-input tagihanLain'></td>
                                    <td><?= ($tLain->tarifLainDeskripsi == null) ? $tLain->refJenisBiayaNama : $tLain->tarifLainDeskripsi ?> (<?= $tLain->tarifLainNominal ?>)</td>
                                    <td>
                                        <select class="form-control <?= 'jumlahTagihan' . $tLain->tarifLainId ?>" <?= ($tLain->tarifLainIsAllowedAmount == '1') ? '' : 'disabled' ?>>
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" onclick="backMainModal()">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="backMainModalAgree()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>