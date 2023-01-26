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
        <?php if ($validation->hasError('tahunAjaranKode')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tahunAjaranKode')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tahunAjaranNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tahunAjaranNama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('semesterId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('semesterId')]]); ?>
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
                                    <th rowspan="2" width="5%" style="text-align:center">No</th>
                                    <th rowspan="2">Kode</th>
                                    <th rowspan="2">Nama</th>
                                    <th rowspan="2">Semester</th>
                                    <th style="text-align:center" colspan="2">Masa Berlaku</th>
                                    <th rowspan="2" width="15%" style="text-align:center">Action</th>
                                </tr>
                                <tr>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tahunAjaran)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($tahunAjaran as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->tahunAjaranKode; ?></td>
                                            <td><?= $row->tahunAjaranNama; ?></td>
                                            <td><?= $row->semesterNama; ?></td>
                                            <td><?= ($row->tahunAjaranStartDate == null) ? "-" : date('d-m-Y', (strtotime($row->tahunAjaranStartDate))); ?></td>
                                            <td><?= ($row->tahunAjaranEndDate == null) ? "-" : date('d-m-Y', (strtotime($row->tahunAjaranEndDate))); ?></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editKurikulum<?= $row->tahunAjaranId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusKurikulum<?= $row->tahunAjaranId ?>"><i class="las la-trash"></i></button>
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
                        <?= $pager->links('tahunAjaran', 'pager') ?>
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
            <form action="/tahunAjaran/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="tahunAjaranKode">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="tahunAjaranNama">
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select class="form-control" name="semesterId">
                            <option value="">Pilih Semester</option>
                            <?php foreach ($semester as $option) : ?>
                                <option value="<?= $option->semesterId ?>"><?= $option->semesterNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputdate">Tanggal Awal </label>
                        <input type="date" class="form-control" name="tahunAjaranStartDate" id="exampleInputdate" value="<?= date("Y-m-d") ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputdate">Tanggal Akhir </label>
                        <input type="date" class="form-control" name="tahunAjaranEndDate" id="exampleInputdate" value="<?= date("Y-m-d", strtotime("+1 week")) ?>">
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
<?php foreach ($tahunAjaran as $edit) : ?>
    <div class="modal fade" id="editKurikulum<?= $edit->tahunAjaranId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $edit->tahunAjaranNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="tahunAjaran/ubah/<?= $edit->tahunAjaranId ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name="tahunAjaranKode" value="<?= $edit->tahunAjaranKode ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="tahunAjaranNama" value="<?= $edit->tahunAjaranNama ?>">
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select class="form-control" name="semesterId">
                                <option value="">Semester</option>
                                <?php foreach ($semester as $option) : ?>
                                    <option value="<?= $option->semesterId ?>" <?= ($option->semesterId == $edit->tahunAjaranSemesterId) ? "selected" : "" ?>><?= $option->semesterNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputdate">Tanggal Awal </label>
                            <input type="date" class="form-control" name="tahunAjaranStartDate" id="exampleInputdate" value="<?= ($edit->tahunAjaranStartDate == null) ? $edit->tahunAjaranStartDate : reformat($edit->tahunAjaranStartDate) ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputdate">Tanggal Akhir </label>
                            <input type="date" class="form-control" name="tahunAjaranEndDate" id="exampleInputdate" value="<?= ($edit->tahunAjaranEndDate == null) ? $edit->tahunAjaranEndDate : reformat($edit->tahunAjaranEndDate) ?>">
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
<?php foreach ($tahunAjaran as $hapus) : ?>
    <div class="modal fade" id="hapusKurikulum<?= $hapus->tahunAjaranId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data <strong><?= $hapus->tahunAjaranNama ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/tahunAjaran/hapus/<?= $hapus->tahunAjaranId; ?>" method="post">
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