<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[1]; ?></li>
            </ol>
        </nav>
        <?php if ($validation->hasError('fakultasKode')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('fakultasKode')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('fakultasNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('fakultasNama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('fakultasAcronym')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('fakultasAcronym')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('fakultasNamaAsing')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('fakultasNamaAsing')]]); ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
        <?php endif; ?>
        <div id="alert">
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?= $title; ?></h4>
                        </div>
                        <div class="iq-search-bar device-search float-right">
                            <div class="searchbox">
                                <input type="text" class="text search-input cari" placeholder="Type here to search..." name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                <a class="search-link" style="cursor: pointer;"><i class="ri-search-line"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="padding-bottom:20px" class="card-header-toolbar d-flex align-items-center float-right">
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahFakultas"><i class="las la-plus"><span class="pl-1"></span></i>Tambah</button>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Akronim</th>
                                    <th>Nama Asing</th>
                                    <th style="text-align:center">Status</th>
                                    <th width="15%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($fakultas)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($fakultas as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->fakultasKode; ?></td>
                                            <td><?= $row->fakultasNama; ?></td>
                                            <td><?= $row->fakultasAcronym; ?></td>
                                            <td><?= $row->fakultasNamaAsing; ?></td>
                                            <td style="text-align:center"><span class="mt-2 badge border <?= ($row->fakultasIsAktif == 1) ? "border-success text-success" : "border-danger text-danger" ?> mt-2"><?= ($row->fakultasIsAktif == 1) ? "Aktif" : "Tidak aktif" ?></span></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dosen<?= $row->fakultasId ?>"><i class="las la-user"></i></button>
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editFakultas<?= $row->fakultasId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusFakultas<?= $row->fakultasId ?>"><i class="las la-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('fakultas', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start tambah dosen pimpinan -->
<?php foreach ($fakultas as $dsn) : ?>
    <div class="modal fade" id="dosen<?= $dsn->fakultasId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Pimpinan Fakultas <?= $dsn->fakultasNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Type here to search..." aria-describedby="basic-addon2" name="cariDsnFakultas<?= $dsn->fakultasId ?>" onkeyup="cariDsnFakultas(<?= $dsn->fakultasId ?>,<?= $dsn->fakultasKode ?>)">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="cariDsnFakultas(<?= $dsn->fakultasId ?>,<?= $dsn->fakultasKode ?>)"><span class="las la-search"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="alertDsnFakultas<?= $dsn->fakultasId ?>" class="mb-3 mt-3"></div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Cari Dosen</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th width="10%"></th>
                                                <th>Nama Dosen</th>
                                                <th>Jabatan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pilihDsnFakultas<?= $dsn->fakultasId ?>">
                                            <tr>
                                                <td colspan="3" style="text-align: center;">Data dosen belum dicari</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="float-right" id="updateDsnFakultas<?= $dsn->fakultasId ?>"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4><?= ($dsn->fakultasKode == '20') ? 'Pimpinan' : 'Dekanat' ?> </h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-responsive-md  ">
                                        <tbody>
                                            <?= reformatDosenPimpinan(['fakultas', $dsn->fakultasDekan, $dsn->fakultasWD1, $dsn->fakultasWD3, $dsn->fakultasKode]); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end tambah dosen pimpinan -->

<!-- start modal tambah -->
<div class="modal fade" id="tambahFakultas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/fakultas/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="fakultasKode">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="fakultasNama">
                    </div>
                    <div class="form-group">
                        <label>Akronim</label>
                        <input type="text" class="form-control" name="fakultasAcronym">
                    </div>
                    <div class="form-group">
                        <label>Nama Asing</label>
                        <input type="text" class="form-control" name="fakultasNamaAsing">
                    </div>
                    <div class="form-group">
                        <label>Nama Dekan</label>
                        <input type="text" class="form-control" name="fakultasDekan">
                    </div>
                    <div class="form-group">
                        <label>Nama WD I</label>
                        <input type="text" class="form-control" name="fakultasWD1">
                    </div>
                    <div class="form-group">
                        <label>Nama WD II</label>
                        <input type="text" class="form-control" name="fakultasWD2">
                    </div>
                    <div class="form-group">
                        <label>Nama WD III</label>
                        <input type="text" class="form-control" name="fakultasWD3">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                            <div class="custom-switch-inner">
                                <input type="checkbox" class="custom-control-input" id="customSwitchAdd" checked="" name="fakultasIsAktif">
                                <label class="custom-control-label" for="customSwitchAdd">
                                    <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                    <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                </label>
                            </div>
                        </div>
                        <label>Status (Aktif/Tidak Aktif)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal edit -->
<?php foreach ($fakultas as $edit) : ?>
    <div class="modal fade" id="editFakultas<?= $edit->fakultasId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $title ?> <?= $edit->fakultasNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="fakultas/ubah/<?= $edit->fakultasId ?>">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name="fakultasKode" value="<?= $edit->fakultasKode ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="fakultasNama" value="<?= $edit->fakultasNama ?>">
                        </div>
                        <div class="form-group">
                            <label>Akronim</label>
                            <input type="text" class="form-control" name="fakultasAcronym" value="<?= $edit->fakultasAcronym ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama Asing</label>
                            <input type="text" class="form-control" name="fakultasNamaAsing" value="<?= $edit->fakultasNamaAsing ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama Dekan</label>
                            <input type="text" class="form-control" name="fakultasDekan" value="<?= $edit->fakultasDekan ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama WD I</label>
                            <input type="text" class="form-control" name="fakultasWD1" value="<?= $edit->fakultasWD1 ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama WD II</label>
                            <input type="text" class="form-control" name="fakultasWD2" value="<?= $edit->fakultasWD2 ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama WD III</label>
                            <input type="text" class="form-control" name="fakultasWD3" value="<?= $edit->fakultasWD3 ?>">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                <div class="custom-switch-inner">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch<?= $edit->fakultasId ?>" <?= ($edit->fakultasIsAktif == 1) ? 'checked' : ''; ?> value="<?= ($edit->fakultasIsAktif == null) ? 0 : 1; ?>" name="fakultasIsAktif">
                                    <label class="custom-control-label" for="customSwitch<?= $edit->fakultasId ?>">
                                        <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                        <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                    </label>
                                </div>
                            </div>
                            <label>Status (Aktif/Tidak Aktif)</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>

<!-- start modal hapus -->
<?php foreach ($fakultas as $hapus) : ?>
    <div class="modal fade" id="hapusFakultas<?= $hapus->fakultasId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data <strong><?= $hapus->fakultasNama ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/fakultas/hapus/<?= $hapus->fakultasId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal hapus -->
<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>