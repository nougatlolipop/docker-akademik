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
        <?php if ($validation->hasError('jadwalKuliahKelompokId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jadwalKuliahKelompokId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('jadwalKuliahHariId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jadwalKuliahHariId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('jadwalKuliahDeskripsi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jadwalKuliahDeskripsi')]]); ?>
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
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahJadwal"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                            </button>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Kelompok Kuliah</th>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Deskripsi</th>
                                    <th width="15%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($jadwalWaktu)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($jadwalWaktu as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->kelompokKuliahNama; ?></td>
                                            <td><?= $row->refHariNama; ?></td>
                                            <td><?= $row->jadwalKuliahMulai; ?></td>
                                            <td><?= $row->jadwalKuliahSelesai; ?></td>
                                            <td><?= $row->jadwalKuliahDeskripsi; ?></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editJadwal<?= $row->jadwalKuliahId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusJadwal<?= $row->jadwalKuliahId ?>"><i class="las la-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 7]); ?>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('jadwalWaktu', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- start modal tambah -->
<div class="modal fade" id="tambahJadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/jadwalWaktu/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" class="form-control" name="jadwalKuliahMulai" value="00:00">
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai</label>
                        <input type="time" class="form-control" name="jadwalKuliahSelesai" value="00:00">
                    </div>
                    <label>Kelompok Kuliah</label>
                    <div class="form-group">
                        <?php foreach ($kelompokKuliah as $option) : ?>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" name="jadwalKuliahKelompokId[]" class="custom-control-input" id="kelompok<?= $option->kelompokKuliahId ?>" value="<?= $option->kelompokKuliahId ?>">
                                <label class="custom-control-label" for="kelompok<?= $option->kelompokKuliahId ?>"><?= $option->kelompokKuliahNama; ?></label>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <label>Hari</label>
                    <div class="form-group">
                        <?php foreach ($hari as $option) : ?>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" name="jadwalKuliahHariId[]" class="custom-control-input" id="hari<?= $option->refHariId ?>" value="<?= $option->refHariId ?>">
                                <label class="custom-control-label" for="hari<?= $option->refHariId ?>"><?= $option->refHariNama; ?></label>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="2" name="jadwalKuliahDeskripsi"></textarea>
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
<?php foreach ($jadwalWaktu as $edit) : ?>
    <div class="modal fade" id="editJadwal<?= $edit->jadwalKuliahId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Jadwal Waktu Kuliah <?= $edit->kelompokKuliahNama; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="jadwalWaktu/ubah/<?= $edit->jadwalKuliahId ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kelompok Kuliah</label>
                            <select class="form-control" name="jadwalKuliahKelompokId">
                                <option value="">Pilih Kelompok Kuliah</option>
                                <?php foreach ($kelompokKuliah as $option) : ?>
                                    <option value="<?= $option->kelompokKuliahId ?>" <?= ($option->kelompokKuliahId == $edit->jadwalKuliahKelompokId) ? "selected" : "" ?>><?= $option->kelompokKuliahNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hari</label>
                            <select class="form-control" name="jadwalKuliahHariId">
                                <option value="">Pilih Hari</option>
                                <?php foreach ($hari as $option) : ?>
                                    <option value="<?= $option->refHariId ?>" <?= ($option->refHariId == $edit->jadwalKuliahHariId) ? "selected" : "" ?>><?= $option->refHariNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jam Mulai</label>
                            <input type="time" class="form-control" name="jadwalKuliahMulai" value="<?= $edit->jadwalKuliahMulai ?>">
                        </div>
                        <div class="form-group">
                            <label>Jam Selesai</label>
                            <input type="time" class="form-control" name="jadwalKuliahSelesai" value="<?= $edit->jadwalKuliahSelesai ?>">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" rows="2" name="jadwalKuliahDeskripsi"><?= $edit->jadwalKuliahDeskripsi ?></textarea>
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
<?php foreach ($jadwalWaktu as $hapus) : ?>
    <div class="modal fade" id="hapusJadwal<?= $hapus->jadwalKuliahId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Jadwal Waktu Kuliah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data jadwal waktu kuliah <strong><?= $hapus->kelompokKuliahNama ?></strong> pada hari <strong><?= $hapus->jadwalKuliahDeskripsi ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/jadwalWaktu/hapus/<?= $hapus->jadwalKuliahId; ?>" method="post">
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