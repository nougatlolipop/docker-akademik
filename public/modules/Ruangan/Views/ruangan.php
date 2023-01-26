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
        <?php if ($validation->hasError('ruanganKode')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('ruanganKode')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('ruanganNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('ruanganNama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('ruanganGedungId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('ruanganGedungId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('ruanganKelompokId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('ruanganKelompokId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('ruanganDeskripsi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('ruanganDeskripsi')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('ruanganKapasitas')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('ruanganKapasitas')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('ruanganAkronim')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('ruanganAkronim')]]); ?>
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
                        <div class="iq-search-bar device-search float-right">
                            <div class="searchbox">
                                <input type="text" class="text search-input cari" placeholder="Type here to search..." name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                <a class="search-link" style="cursor: pointer;"><i class="ri-search-line"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div style="padding-bottom:20px" class="card-header-toolbar d-flex align-items-center float-right">
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahRuangan"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                            </button>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Kode</th>
                                    <th>Nama/Akronim</th>
                                    <th>Deskripsi</th>
                                    <th>Kapasitas</th>
                                    <th>Gedung</th>
                                    <th>Kelompok Kuliah</th>
                                    <th style="text-align:center">Status</th>
                                    <th width="10%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ruangan)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($ruangan as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->ruangKode; ?></td>
                                            <td><?= ($row->ruangAkronim != null) ? $row->ruangNama . "/" . $row->ruangAkronim : $row->ruangNama; ?></td>
                                            <td><?= $row->ruangDeskripsi; ?></td>
                                            <td><?= $row->ruangKapasitas; ?></td>
                                            <td><?= $row->refGedungNama; ?></td>
                                            <td><?= $row->kelompokKuliahNama; ?></td>
                                            <td style="text-align:center"><span class="mt-2 badge border <?= ($row->ruangIsAktif == 1) ? "border-success text-success" : "border-danger text-danger" ?> mt-2"><?= ($row->ruangIsAktif == 1) ? "Aktif" : "Tidak aktif" ?></span></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editRuangan<?= $row->ruangId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusRuangan<?= $row->ruangId ?>"><i class="las la-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 9]); ?>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('ruangan', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start modal tambah -->
<div class="modal fade" id="tambahRuangan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/ruangan/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="ruangKode">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="ruanganNama">
                    </div>
                    <div class="form-group">
                        <label>Akronim</label>
                        <input type="text" class="form-control" name="ruanganAkronim">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="2" name="ruanganDeskripsi"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kapasitas</label>
                        <input type="number" class="form-control" name="ruanganKapasitas">
                    </div>
                    <div class="form-group">
                        <label>Gedung</label>
                        <select class="form-control" name="ruanganGedungId">
                            <option value="">Pilih Gedung</option>
                            <?php foreach ($gedung as $option) : ?>
                                <option value="<?= $option->refGedungId ?>"><?= $option->refGedungNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelompok Kuliah</label>
                        <select class="form-control" name="ruanganKelompokId">
                            <option value="">Pilih Kelompok Kuliah</option>
                            <?php foreach ($kelompok as $option) : ?>
                                <option value="<?= $option->kelompokKuliahId ?>"><?= $option->kelompokKuliahNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                            <div class="custom-switch-inner">
                                <input type="checkbox" class="custom-control-input" id="customSwitchAdd" checked="" name="ruanganIsAktif">
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
<?php foreach ($ruangan as $edit) : ?>
    <div class="modal fade" id="editRuangan<?= $edit->ruangId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Ruang <?= $edit->ruangNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="ruangan/ubah/<?= $edit->ruangId ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" value="<?= $edit->ruangKode ?>" name="ruanganKode">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" value="<?= $edit->ruangNama ?>" name="ruanganNama">
                        </div>
                        <div class="form-group">
                            <label>Akronim</label>
                            <input type="text" class="form-control" value="<?= $edit->ruangAkronim ?>" name="ruanganAkronim">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" rows="2" name="ruanganDeskripsi"><?= $edit->ruangDeskripsi ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Kapasitas</label>
                            <input type="number" class="form-control" value="<?= $edit->ruangKapasitas ?>" name="ruanganKapasitas">
                        </div>
                        <div class="form-group">
                            <label>Gedung</label>
                            <select class="form-control" name="ruanganGedungId">
                                <option value="">Pilih Gedung</option>
                                <?php foreach ($gedung as $option) : ?>
                                    <option value="<?= $option->refGedungId ?>" <?= ($option->refGedungId == $edit->ruangGedungId) ? "selected" : ""; ?>><?= $option->refGedungNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelompok Kuliah</label>
                            <select class="form-control" name="ruanganKelompokId">
                                <option value="">Pilih Kelompok Kuliah</option>
                                <?php foreach ($kelompok as $option) : ?>
                                    <option value="<?= $option->kelompokKuliahId ?>" <?= ($option->kelompokKuliahId == $edit->ruangKelompokId) ? "selected" : ""; ?>><?= $option->kelompokKuliahNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                <div class="custom-switch-inner">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch<?= $edit->ruangId ?>" <?= $edit->ruangIsAktif ?>" <?= ($edit->ruangIsAktif == '1') ? 'checked' : ''; ?> value="<?= ($edit->ruangIsAktif == null) ? 0 : 1; ?>" name="ruanganIsAktif">
                                    <label class="custom-control-label" for="customSwitch<?= $edit->ruangId ?>">
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
<!-- end modal edit -->

<!-- start modal hapus -->
<?php foreach ($ruangan as $hapus) : ?>
    <div class="modal fade" id="hapusRuangan<?= $hapus->ruangId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data ruang <strong><?= $hapus->ruangNama ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/ruangan/hapus/<?= $hapus->ruangId; ?>" method="post">
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