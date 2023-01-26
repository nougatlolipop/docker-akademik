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
                    <li class="breadcrumb-item"><a href="/nilaiProdi" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
                <?php endif ?>
            </ol>
        </nav>
        <?php if ($validation->hasError('gradeProdiNilaiBobot')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('gradeProdiNilaiBobot')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('gradeProdiNilaiPredikat')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('gradeProdiNilaiPredikat')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('gradeProdiNilaiPredikatEng')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('gradeProdiNilaiPredikatEng')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('gradeProdiNilaiSkalaMax')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('gradeProdiNilaiSkalaMax')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('gradeProdiNilaiSkalaMin')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('gradeProdiNilaiSkalaMin')]]); ?>
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
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Prodi</th>
                                    <th>Fakultas</th>
                                    <th style="text-align:center">Aturan Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($prodi)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($prodi as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->prodiNama; ?></td>
                                            <td><?= $row->fakultasNama; ?></td>
                                            <td style="text-align:center"><span style="cursor: pointer;" data-toggle="modal" data-target="#nilai<?= $row->prodiId ?>" class=" text-primary">Klik untuk lihat</span></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('nilaiProdi', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start modal detail -->
<?php foreach ($prodi as $detail) : ?>
    <div class="modal fade" id="nilai<?= $detail->prodiId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Nilai Prodi <?= $detail->prodiNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <table class="table table-bordered table-responsive-md table-striped">
                            <thead>
                                <tr>
                                    <th width="15%" style="text-align:center">Nilai Huruf</th>
                                    <th>Bobot</th>
                                    <th width="21%">Predikat</th>
                                    <th width="21%">Predikat (Eng)</th>
                                    <th>Nilai Min</th>
                                    <th>Nilai Max</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($nilaiProdi as $row) : ?>
                                    <?php if ($row->gradeProdiNilaiProdiId == $detail->prodiId) : ?>
                                        <form action="nilaiProdi/ubah" method="post">
                                            <?= csrf_field() ?>
                                            <tr>
                                                <input type="hidden" name="gradeProdiNilaiId[]" value="<?= $row->gradeProdiNilaiId ?>">
                                                <input type="hidden" name="gradeProdiNilaiProdiId[]" value="<?= $row->gradeProdiNilaiProdiId ?>">
                                                <input type="hidden" name="gradeProdiNilaiGradeId[]" value="<?= $row->gradeNilaiId ?>">
                                                <th style="text-align:center"><?= $row->gradeNilaiKode ?></th>
                                                <td><input type="number" class="form-control" name="gradeProdiNilaiBobot[]" value="<?= $row->gradeProdiNilaiBobot ?>"></td>
                                                <td><input type="text" class="form-control" name="gradeProdiNilaiPredikat[]" value="<?= $row->gradeProdiNilaiPredikat ?>"></td>
                                                <td><input type="text" class="form-control" name="gradeProdiNilaiPredikatEng[]" value="<?= $row->gradeProdiNilaiPredikatEng ?>"></td>
                                                <td><input type="number" class="form-control" name="gradeProdiNilaiSkalaMin[]" value="<?= $row->gradeProdiNilaiSkalaMin ?>"></td>
                                                <td><input type="number" class="form-control" name="gradeProdiNilaiSkalaMax[]" value="<?= $row->gradeProdiNilaiSkalaMax ?>"></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach ?>
                            </tbody>
                        </table>
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
<!-- end modal detail -->

<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>