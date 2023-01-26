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
        <?php if ($validation->hasError('kelompokKuliahKode')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('kelompokKuliahKode')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('kelompokKuliahNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('kelompokKuliahNama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('kelompokKuliahDeskripsi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('kelompokKuliahDeskripsi')]]); ?>
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
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahKurikulum"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                            </button>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th width="15%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($kelompokKuliah)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($kelompokKuliah as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->kelompokKuliahKode; ?></td>
                                            <td><?= $row->kelompokKuliahNama; ?></td>
                                            <td><?= $row->kelompokKuliahDeskripsi; ?></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editKurikulum<?= $row->kelompokKuliahId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusKurikulum<?= $row->kelompokKuliahId ?>"><i class="las la-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 5]); ?>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('kelompokKuliah', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- start modal tambah -->
<div class="modal fade" id="tambahKurikulum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/kelompokKuliah/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="kelompokKuliahKode">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="kelompokKuliahNama">
                    </div>
                    <div class="form-group">
                        <label>Nama Deskripsi</label>
                        <input type="text" class="form-control" name="kelompokKuliahDeskripsi">
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
<?php foreach ($kelompokKuliah as $edit) : ?>
    <div class="modal fade" id="editKurikulum<?= $edit->kelompokKuliahId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $edit->kelompokKuliahNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="kelompokKuliah/ubah/<?= $edit->kelompokKuliahId ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name="kelompokKuliahKode" value="<?= $edit->kelompokKuliahKode ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="kelompokKuliahNama" value="<?= $edit->kelompokKuliahNama ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama Deskripsi</label>
                            <input type="text" class="form-control" name="kelompokKuliahDeskripsi" value="<?= $edit->kelompokKuliahDeskripsi ?>">
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
<?php foreach ($kelompokKuliah as $hapus) : ?>
    <div class="modal fade" id="hapusKurikulum<?= $hapus->kelompokKuliahId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $hapus->kelompokKuliahNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data <strong><?= $title ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/kelompokKuliah/hapus/<?= $hapus->kelompokKuliahId; ?>" method="post">
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