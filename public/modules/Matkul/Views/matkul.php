<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <?php if (in_groups('Fakultas')) : ?>
                    <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[1]; ?></li>
                <?php else : ?>
                    <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                    <li class="breadcrumb-item"><a href="/matkul" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
                <?php endif ?>
            </ol>
        </nav>
        <?php if ($validation->hasError('matkulKode')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('matkulKode')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('matkulNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('matkulNama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('matkulNamaEnglish')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('matkulNamaEnglish')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('matkulTypeId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('matkulTypeId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('matkulProdiId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('matkulProdiId')]]); ?>
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
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahMatkul"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                            </button>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Nama asing</th>
                                    <th>Tipe</th>
                                    <th>Prodi</th>
                                    <th width="15%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($matkul)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($matkul as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->matkulKode; ?></td>
                                            <td><?= $row->matkulNama; ?></td>
                                            <td><?= $row->matkulNamaEnglish; ?></td>
                                            <td><?= $row->matkulTypeNama; ?></td>
                                            <td><?= $row->prodiNama; ?></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editMatkul<?= $row->matkulId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusMatkul<?= $row->matkulId ?>"><i class="las la-trash"></i></button>
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
                        <?= $pager->links('matkul', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- start modal tambah -->
<div class="modal fade" id="tambahMatkul" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/matkul/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="matkulKode">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="matkulNama">
                    </div>
                    <div class="form-group">
                        <label>Nama asing</label>
                        <input type="text" class="form-control" name="matkulNamaEnglish">
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                        <select class="form-control" name="matkulTypeId">
                            <option value="">Pilih Tipe</option>
                            <?php foreach ($type as $option) : ?>
                                <option value="<?= $option->matkulTypeId ?>"><?= $option->matkulTypeNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Prodi</label>
                        <select class="form-control" name="matkulProdiId">
                            <option value="">Pilih Prodi</option>
                            <?php if (in_groups('Fakultas')) : ?>
                                <?php foreach ($prodiBiro as $option) : ?>
                                    <option value="<?= $option->prodiId ?>"><?= $option->prodiNama ?> (<?= $option->refJenjangNama ?>)</option>
                                <?php endforeach ?>
                            <?php else : ?>
                                <?php foreach ($prodi as $option) : ?>
                                    <option value="<?= $option->prodiId ?>"><?= $option->prodiNama ?> (<?= $option->refJenjangNama ?>)</option>
                                <?php endforeach ?>
                            <?php endif ?>
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
<?php foreach ($matkul as $edit) : ?>
    <div class="modal fade" id="editMatkul<?= $edit->matkulId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Matkul <?= $edit->matkulNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="matkul/ubah/<?= $edit->matkulId ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="oldMatkulKode" value="<?= $edit->matkulKode ?>">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name="matkulKode" value="<?= $edit->matkulKode ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="matkulNama" value="<?= $edit->matkulNama ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama asing</label>
                            <input type="text" class="form-control" name="matkulNamaEnglish" value="<?= $edit->matkulNamaEnglish ?>">
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select class="form-control" name="matkulTypeId">
                                <option value="">Pilih Tipe</option>
                                <?php foreach ($type as $option) : ?>
                                    <option value="<?= $option->matkulTypeId ?>" <?= ($option->matkulTypeId == $edit->matkulTypeId) ? "selected" : "" ?>><?= $option->matkulTypeNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Prodi</label>
                            <select class="form-control" name="matkulProdiId">
                                <option value="">Pilih Prodi</option>
                                <?php if (in_groups('Fakultas')) : ?>
                                    <?php foreach ($prodiBiro as $option) : ?>
                                        <option value="<?= $option->prodiId ?>" <?= ($option->prodiId == $edit->matkulProdiId) ? "selected" : "" ?>><?= $option->prodiNama ?> (<?= $option->refJenjangNama ?>)</option>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?php foreach ($prodi as $option) : ?>
                                        <option value="<?= $option->prodiId ?>" <?= ($option->prodiId == $edit->matkulProdiId) ? "selected" : "" ?>><?= $option->prodiNama ?> (<?= $option->refJenjangNama ?>)</option>
                                    <?php endforeach ?>
                                <?php endif ?>
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
<?php foreach ($matkul as $hapus) : ?>
    <div class="modal fade" id="hapusMatkul<?= $hapus->matkulId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Matkul <?= $hapus->matkulNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data matkul <strong><?= $hapus->matkulNama ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/matkul/hapus/<?= $hapus->matkulId; ?>" method="post">
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