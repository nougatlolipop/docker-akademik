<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/kurikulum" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if ($validation->hasError('kurikulumKode')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('kurikulumKode')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('kurikulumNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('kurikulumNama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('kurikulumKurTypeId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('kurikulumKurTypeId')]]); ?>
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
                                    <th>Tipe</th>
                                    <th>Aturan SKS</th>
                                    <th width="15%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($kurikulum)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($kurikulum as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->kurikulumKode; ?></td>
                                            <td><?= $row->kurikulumNama; ?></td>
                                            <td><?= $row->kurikulumTypeNama; ?></td>
                                            <td><a href="#!"><span data-toggle="modal" data-target="#sks<?= $row->kurikulumId ?>" class=" text-primary"><?= $row->sksAllowNama; ?></span></a></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editKurikulum<?= $row->kurikulumId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusKurikulum<?= $row->kurikulumId ?>"><i class="las la-trash"></i></button>
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
                        <?= $pager->links('kurikulum', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start modal detail sks -->
<?php foreach ($kurikulum as $detail) : ?>
    <div class="modal fade" id="sks<?= $detail->kurikulumId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $detail->kurikulumNama ?></h5>
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
<!-- end modal detail sks -->

<!-- start modal tambah -->
<div class="modal fade" id="tambahKurikulum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/kurikulum/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="kurikulumKode">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="kurikulumNama">
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                        <select class="form-control" name="kurikulumKurTypeId">
                            <option value="">Pilih Tipe</option>
                            <?php foreach ($kurikulumType as $option) : ?>
                                <option value="<?= $option->kurikulumTypeId ?>"><?= $option->kurikulumTypeNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Aturan SKS</label>
                        <select class="form-control" name="kurikulumSksAllowId">
                            <option value="">Pilih Aturan</option>
                            <?php foreach ($sksAllow as $option) : ?>
                                <option value="<?= $option->sksAllowId ?>"><?= $option->sksAllowNama ?></option>
                            <?php endforeach ?>
                        </select>
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
<?php foreach ($kurikulum as $edit) : ?>
    <div class="modal fade" id="editKurikulum<?= $edit->kurikulumId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $edit->kurikulumNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="kurikulum/ubah/<?= $edit->kurikulumId ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name="kurikulumKode" value="<?= $edit->kurikulumKode ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="kurikulumNama" value="<?= $edit->kurikulumNama ?>">
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select class="form-control" name="kurikulumKurTypeId">
                                <option value="">Pilih Tipe</option>
                                <?php foreach ($kurikulumType as $option) : ?>
                                    <option value="<?= $option->kurikulumTypeId ?>" <?= ($option->kurikulumTypeId == $edit->kurikulumKurTypeId) ? "selected" : "" ?>><?= $option->kurikulumTypeNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Aturan SKS</label>
                            <select class="form-control" name="kurikulumSksAllowId">
                                <option value="">Pilih Aturan</option>
                                <?php foreach ($sksAllow as $option) : ?>
                                    <option value="<?= $option->sksAllowId ?>" <?= ($option->sksAllowId == $edit->kurikulumSksAllowId) ? "selected" : "" ?>><?= $option->sksAllowNama ?></option>
                                <?php endforeach ?>
                            </select>
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
<?php foreach ($kurikulum as $hapus) : ?>
    <div class="modal fade" id="hapusKurikulum<?= $hapus->kurikulumId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data <strong><?= $hapus->kurikulumNama ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/kurikulum/hapus/<?= $hapus->kurikulumId; ?>" method="post">
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