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
        <?php if ($validation->hasError('semesterKode')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('semesterKode')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('semesterNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('semesterNama')]]); ?>
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
                        <div class="card-header-toolbar d-flex align-items-center">
                            <span class="float-right">
                                <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahKurikulum"><i class="las la-plus"><span class="pl-1">Tambah</span></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div style="padding-bottom:20px" class="iq-search-bar device-search float-right">
                            <form action="#" class="searchbox">
                                <input type="text" class="text search-input" placeholder="Type here to search..." name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                            </form>
                        </div>

                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th width="15%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($semester)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($semester as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->semesterKode; ?></td>
                                            <td><?= $row->semesterNama; ?></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#editKurikulum<?= $row->semesterId ?>"><i class="las la-edit"></i>Edit</button>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusKurikulum<?= $row->semesterId ?>"><i class="las la-trash"></i>Hapus</button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('semester', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- start modal tambah -->
<div class="modal fade" id="tambahKurikulum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/semester/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="semesterKode">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="semesterNama">
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
<?php foreach ($semester as $edit) : ?>
    <div class="modal fade" id="editKurikulum<?= $edit->semesterId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $edit->semesterNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="semester/ubah/<?= $edit->semesterId ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name="semesterKode" value="<?= $edit->semesterKode ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="semesterNama" value="<?= $edit->semesterNama ?>">
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
<?php foreach ($semester as $hapus) : ?>
    <div class="modal fade" id="hapusKurikulum<?= $hapus->semesterId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $hapus->semesterNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data <strong><?= $hapus->semesterNama ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/semester/hapus/<?= $hapus->semesterId; ?>" method="post">
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