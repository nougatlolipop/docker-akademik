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
        <?php if ($validation->hasError('dosenId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('fakultasId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('fakultasId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('jabatanId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jabatanId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('nomorSK')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('nomorSK')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('fileSK')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('fileSK')]]); ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('failed'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', session()->getFlashdata('failed')]]); ?>
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
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahJabatan"><i class="las la-plus"><span class="pl-1"></span></i>Tambah</button>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="5%" style="text-align:center">No</th>
                                    <th rowspan="2">Dosen</th>
                                    <th rowspan="2">Fakultas</th>
                                    <th style="text-align:center" colspan="3">Jabatan</th>
                                    <th rowspan="2" width="20%" style="text-align:center">Action</th>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($jabatan)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($jabatan as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= ($row->dosenGelarDepan == null) ? '' : $row->dosenGelarDepan ?> <?= $row->dosenNama . ' ' . $row->dosenGelarBelakang ?></td>
                                            <td><?= $row->fakultasNama; ?></td>
                                            <td><?= $row->refJabatanStrukturalNama; ?></td>
                                            <td><?= reformat($row->setJabatanStartDate) ?></td>
                                            <td><?= reformat($row->setJabatanEndDate) ?></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#lihat<?= $row->setJabatanId; ?>"><i class="las la-eye"></i></button>
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editJabatan<?= $row->setJabatanId; ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusJabatan<?= $row->setJabatanId; ?>"><i class="las la-trash"></i></button>
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
                        <?= $pager->links('jabatanAkademik', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Wrapper End-->

<!-- start modal tambah -->
<div class="modal fade" id="tambahJabatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/setJabatanStruktural/tambah" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Dosen</label>
                        <select class="form-control" name="dosenId">
                            <option value="">Pilih Dosen</option>
                            <?php foreach ($dosen as $option) : ?>
                                <option value="<?= $option->dosenId ?>"><?= ($option->dosenGelarDepan == null) ? '' : $option->dosenGelarDepan ?> <?= $option->dosenNama . ' ' . $option->dosenGelarBelakang ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fakultas</label>
                        <select class="form-control" name="fakultasId">
                            <option value="">Pilih Fakultas</option>
                            <?php foreach ($fakultas as $option) : ?>
                                <option value="<?= $option->fakultasId ?>"><?= $option->fakultasNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select class="form-control" name="jabatanId">
                            <option value="">Pilih Jabatan</option>
                            <?php foreach ($struktural as $option) : ?>
                                <option value="<?= $option->refJabatanStrukturalId ?>"><?= $option->refJabatanStrukturalNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor SK</label>
                        <input type="text" class="form-control" name="nomorSK">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputdate">Tanggal SK</label>
                        <input type="date" class="form-control" name="jabatanTanggalSK" id="exampleInputdate" value="<?= date("Y-m-d") ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputdate">Tanggal Awal Jabat</label>
                        <input type="date" class="form-control" name="jabatanStartDate" id="exampleInputdate" value="<?= date("Y-m-d") ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputdate">Tanggal Akhir Jabat</label>
                        <input type="date" class="form-control" name="jabatanEndDate" id="exampleInputdate" value="<?= date("Y-m-d") ?>">
                    </div>
                    <label>File SK</label>
                    <div class="custom-file">
                        <input name="fileSK" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal edit -->
<?php foreach ($jabatan as $edit) : ?>
    <div class="modal fade" id="editJabatan<?= $edit->setJabatanId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/setJabatanStruktural/ubah/<?= $edit->setJabatanId ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="fileLama" value="<?= $edit->setJabatanSKDokumen; ?>">
                    <input type="hidden" name="oldJabatanId" value="<?= $edit->setJabatanStukturalId; ?>">
                    <input type="hidden" name="oldFakultasId" value="<?= $edit->setJabatanFakultasId; ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Dosen</label>
                            <select class="form-control" name="dosenId">
                                <option value="">Pilih Dosen</option>
                                <?php foreach ($dosen as $option) : ?>
                                    <option value="<?= $option->dosenId ?>" <?= ($option->dosenId == $edit->setJabatanDosenId) ? "selected" : "" ?>><?= ($option->dosenGelarDepan == null) ? '' : $option->dosenGelarDepan ?> <?= $option->dosenNama . ' ' . $option->dosenGelarBelakang ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fakultas</label>
                            <select class="form-control" name="fakultasId">
                                <option value="">Pilih Fakultas</option>
                                <?php foreach ($fakultas as $option) : ?>
                                    <option value="<?= $option->fakultasId ?>" <?= ($option->fakultasId == $edit->setJabatanFakultasId) ? "selected" : "" ?>><?= $option->fakultasNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control" name="jabatanId">
                                <option value="">Pilih Jabatan</option>
                                <?php foreach ($struktural as $option) : ?>
                                    <option value="<?= $option->refJabatanStrukturalId ?>" <?= ($option->refJabatanStrukturalId == $edit->setJabatanStukturalId) ? "selected" : "" ?>><?= $option->refJabatanStrukturalNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nomor SK</label>
                            <input type="text" class="form-control" name="nomorSK" value="<?= $edit->setJabatanNoSK ?>">
                        </div>
                        <div class=" form-group">
                            <label for="exampleInputdate">Tanggal SK</label>
                            <input type="date" class="form-control" name="jabatanTanggalSK" id="exampleInputdate" value="<?= reformat($edit->setJabatanTanggalSK) ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputdate">Tanggal Awal Jabat</label>
                            <input type="date" class="form-control" name="jabatanStartDate" id="exampleInputdate" value="<?= reformat($edit->setJabatanStartDate) ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputdate">Tanggal Akhir Jabat</label>
                            <input type="date" class="form-control" name="jabatanEndDate" id="exampleInputdate" value="<?= reformat($edit->setJabatanEndDate) ?>">
                        </div>
                        <label>File SK</label>
                        <div class="form-group">
                            <div class="custom-file">
                                <input name="fileSK" type="file" accept="application/pdf" class="custom-file-input" value="<?= $edit->setJabatanSKDokumen; ?>" id="customFile<?= $edit->setJabatanId; ?>" onchange="labelDokumenEdit(<?= $edit->setJabatanId; ?>)">
                                <label class="custom-file-label custom-file-label<?= $edit->setJabatanId; ?>" for="customFile"><?= $edit->setJabatanSKDokumen; ?></label>
                            </div>
                        </div>

                    </div>
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- end modal edit -->

<!-- start modal delete -->
<?php foreach ($jabatan as $hapus) : ?>
    <div class="modal fade" id="hapusJabatan<?= $hapus->setJabatanId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/setJabatanStruktural/hapus/<?= $hapus->setJabatanId ?>" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data <strong><?= ($hapus->dosenGelarDepan == null) ? '' : $hapus->dosenGelarDepan ?> <?= $hapus->dosenNama . ' ' . $hapus->dosenGelarBelakang ?> (<?= $hapus->refJabatanStrukturalNama ?>)</strong> dari <strong><?= $hapus->fakultasNama ?></strong>?</p>
                        <p class="text-warning"><small>This action cannot be undone</small></p>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- end modal delete -->

<!-- start modal sk -->
<?php foreach ($jabatan as $sk) : ?>
    <div class="modal fade" id="lihat<?= $sk->setJabatanId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= ($sk->dosenGelarDepan == null ? "" : $sk->dosenGelarDepan) . " " . $sk->dosenNama . " " . $sk->dosenGelarBelakang; ?> - No. SK: <?= $sk->setJabatanNoSK; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <embed src="<?= base_url() ?>/Dokumen/sk/<?= $sk->setJabatanSKDokumen; ?>" frameborder="0" width="100%" height="500px">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal sk -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>