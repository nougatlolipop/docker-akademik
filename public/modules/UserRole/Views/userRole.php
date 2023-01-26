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
        <?php if ($validation->hasError('roleApp')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('roleApp')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('roleTingkatId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('roleTingkatId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('roleFakultasId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('roleFakultasId')]]); ?>
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
                            <form action="#" class="searchbox">
                                <input type="text" class="text search-input" placeholder="Type here to search..." name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Email Akun</th>
                                    <th>Tingkatan</th>
                                    <th>Fakultas</th>
                                    <th>Aplikasi</th>
                                    <th width="10%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($manajemenAkun)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($manajemenAkun as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->email; ?></td>
                                            <td><?= ($row->refTingkatNama == null) ? "Belum disetting" : $row->refTingkatNama; ?></td>
                                            <td><?= ($row->fakultasNama == null) ? "Belum disetting" : $row->fakultasNama; ?></td>
                                            <td><?= $row->roleApp == null ? "Belum disetting" : ($row->roleApp == "academy" ? "UMSU Academy" : "UMSU Finance"); ?></td>
                                            <td style="text-align:center">
                                                <?php if ($row->roleId == null) : ?>
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahAkun<?= $row->user_id ?>" <?= (user()->email == $row->email) ? 'disabled' : '' ?>><i class="las la-cog"></i>Set</button>
                                                <?php else : ?>
                                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#editAkun<?= $row->roleId ?>" <?= (user()->email == $row->email) ? 'disabled' : '' ?>><i class="las la-edit"></i>Edit</button>
                                                <?php endif; ?>
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
                        <?= $pager->links('userRole', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start modal setting -->
<?php foreach ($manajemenAkun as $tambah) : ?>
    <?php if (user()->email != $tambah->email) : ?>
        <div class="modal fade" id="tambahAkun<?= $tambah->user_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Setting Role Pengguna<strong> <?= $tambah->email; ?></strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="userRole/tambah" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Email Akun</label>
                                <input type="text" class="form-control" name="roleEmail" value="<?= $tambah->email; ?>">
                            </div>
                            <div class="form-group">
                                <label>Aplikasi</label>
                                <select class="form-control" name="roleApp">
                                    <option value="">Pilih Aplikasi</option>
                                    <option value="academy">UMSU Academy</option>
                                    <option value="finance">UMSU Finance</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tingkatan</label>
                                <select class="form-control" name="roleTingkatId">
                                    <option value="">Pilih Tingkatan</option>
                                    <?php foreach ($tingkat as $option) : ?>
                                        <option value="<?= $option->refTingkatId; ?>"><?= $option->refTingkatNama; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Fakultas</label>
                                <select class="form-control" name="roleFakultasId">
                                    <option value="">Pilih Fakultas</option>
                                    <?php foreach ($fakultas as $option) : ?>
                                        <option value="<?= $option->fakultasId; ?>"><?= $option->fakultasNama; ?></option>
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
    <?php endif ?>
<?php endforeach ?>
<!-- start modal setting -->

<!-- start modal edit -->
<?php foreach ($manajemenAkun as $edit) : ?>
    <?php if (user()->email != $edit->email) : ?>
        <div class="modal fade" id="editAkun<?= $edit->roleId; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Role Pengguna<strong> <?= $edit->email; ?></strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="userRole/ubah/<?= $edit->roleId ?>" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Email Akun</label>
                                <input type="text" class="form-control" name="roleEmail" value="<?= $edit->email; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Aplikasi</label>
                                <select class="form-control" name="roleApp">
                                    <option value="">Pilih Aplikasi</option>
                                    <option value="<?= $edit->roleApp ?>" <?= ($edit->roleApp == 'academy') ? "selected" : "" ?>>UMSU Academy</option>
                                    <option value="<?= $edit->roleApp ?>" <?= ($edit->roleApp == 'finance') ? "selected" : "" ?>>UMSU Finance</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tingkatan</label>
                                <select class="form-control" name="roleTingkatId">
                                    <option value="">Pilih Tingkatan</option>
                                    <?php foreach ($tingkat as $option) : ?>
                                        <option value="<?= $option->refTingkatId; ?>" <?= ($option->refTingkatId == $edit->roleTingkatId) ? "selected" : ""; ?>><?= $option->refTingkatNama; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Fakultas</label>
                                <select class="form-control" name="roleFakultasId">
                                    <option value="">Pilih Fakultas</option>
                                    <?php foreach ($fakultas as $option) : ?>
                                        <option value="<?= $option->fakultasId; ?>" <?= ($option->fakultasId == $edit->roleFakultasId) ? "selected" : ""; ?>><?= $option->fakultasNama; ?></option>
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
    <?php endif ?>
<?php endforeach ?>
<!-- end modal edit -->

<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>