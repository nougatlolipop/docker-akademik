<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/sks" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if ($validation->hasError('sksAllowNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('sksAllowNama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('minIpk')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('minIpk')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('maxIpk')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('maxIpk')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('allow')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('allow')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('sksDefault')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('sksDefault')]]); ?>
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
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahSks"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                            </button>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Nama</th>
                                    <th>Aturan</th>
                                    <th width="15%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($sks)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($sks as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->sksAllowNama; ?></td>
                                            <td><span style="cursor: pointer;" data-toggle="modal" data-target="#sks<?= $row->sksAllowId ?>" class=" text-primary">Klik untuk lihat</span></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editSks<?= $row->sksAllowId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusSks<?= $row->sksAllowId ?>"><i class="las la-trash"></i></button>
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
                        <?= $pager->links('sks', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start modal detail aturan -->
<?php foreach ($sks as $detail) : ?>
    <div class="modal fade" id="sks<?= $detail->sksAllowId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $detail->sksAllowNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-responsive-md table-striped">
                        <thead>
                            <tr>
                                <th colspan="3" style="text-align:center">Minimal Akselerasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" style="text-align:center"><?= json_decode($detail->sksAllowJson)->data[0]->minIpkAkselerasi ?></td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th style="text-align:center">Min IPK</th>
                                <th style="text-align:center">Maks IPK</th>
                                <th style="text-align:center">SKS Maks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $dt = json_decode($detail->sksAllowJson)->data; ?>
                            <?php foreach ($dt[0]->detail as $row) : ?>
                                <tr>
                                    <td style="text-align:center"><?= $row->minIpk ?></td>
                                    <td style="text-align:center"><?= $row->maxIpk ?></td>
                                    <td style="text-align:center"><?= $row->allow ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                        <thead>
                            <tr>
                                <th colspan="3" style="text-align:center">SKS Default</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" style="text-align:center"><?= $detail->sksDefault ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal detail aturan -->

<!-- start modal tambah -->
<div class="modal fade" id="tambahSks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/sks/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Aturan</label>
                        <input type="text" class="form-control" name="sksAllowNama">
                    </div>
                    <div class="form-group">
                        <label>Minimal Akselerasi</label>
                        <input type="text" class="form-control" name="minIpkAkselerasi">
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered table-responsive-md table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Min IPK</th>
                                    <th style="text-align:center">Maks IPK</th>
                                    <th style="text-align:center">SKS Maks</th>
                                </tr>
                            </thead>
                            <tbody id="sks">
                                <tr id="firstBaris">
                                    <td colspan="3" style="text-align:center">Klik tambah baris terlebih dahulu</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <span id="tambahRule" class="btn btn-block bg-primary mb-3"><i class="las la-plus"></i>Tambah Baris</span>
                    <div class="form-group">
                        <label>SKS Default</label>
                        <input type="number" class="form-control" name="sksDefault">
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
<?php foreach ($sks as $edit) : ?>
    <div class="modal fade" id="editSks<?= $edit->sksAllowId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data SKS <?= $edit->sksAllowNama ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="sks/ubah/<?= $edit->sksAllowId ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Aturan</label>
                            <input type="text" class="form-control" name="sksAllowNama" value="<?= $edit->sksAllowNama ?>">
                        </div>
                        <div class="form-group">
                            <label>Minimal Akselerasi</label>
                            <input type="text" class="form-control" name="minIpkAkselerasi" value="<?= json_decode($edit->sksAllowJson)->data[0]->minIpkAkselerasi ?>">
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered table-responsive-md table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">Min IPK</th>
                                        <th style="text-align:center">Maks IPK</th>
                                        <th style="text-align:center">SKS Maks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $data = json_decode($edit->sksAllowJson)->data; ?>
                                    <?php foreach ($data[0]->detail as $row) : ?>
                                        <tr>
                                            <td><input type="type" class="form-control" name="minIpk[]" value="<?= $row->minIpk ?>"></td>
                                            <td><input type="type" class="form-control" name="maxIpk[]" value="<?= $row->maxIpk ?>"></td>
                                            <td><input type="type" class="form-control" name="allow[]" value="<?= $row->allow ?>"></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label>SKS Default</label>
                            <input type="number" class="form-control" name="sksDefault" value="<?= $edit->sksDefault ?>">
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
<?php foreach ($sks as $hapus) : ?>
    <div class="modal fade" id="hapusSks<?= $hapus->sksAllowId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data <strong><?= $hapus->sksAllowNama ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/sks/hapus/<?= $hapus->sksAllowId; ?>" method="post">
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