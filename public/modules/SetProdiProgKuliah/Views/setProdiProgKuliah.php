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
        <?php if ($validation->hasError('setProdiProgramKuliahProdiId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setProdiProgramKuliahProdiId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setProdiProgramKuliahProgramKuliahId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setProdiProgramKuliahProgramKuliahId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setProdiProgramKuliahWaktuKuliahId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setProdiProgramKuliahWaktuKuliahId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setProdiProgramKuliahKelompokKuliahId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setProdiProgramKuliahKelompokKuliahId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('prodi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodi')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('programKuliah')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('programKuliah')]]); ?>
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
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card">
                                    <div class="card-body">
                                        <?php $jml = (count($prodiBiro) < 5) ? count($prodiBiro) : 5; ?>
                                        <?php if (in_groups('Fakultas')) : ?>
                                            <h4 class="card-title">Prodi dari Fakultas</h4>
                                            <?php for ($i = 0; $i < $jml; $i++) : ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="smallPrd" class="custom-control-input" id="customCheck<?= 'prodi' . $i ?>" value="<?= $prodiBiro[$i]->prodiId ?>" <?= in_array($prodiBiro[$i]->prodiId, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
                                                    <label class="custom-control-label" for="customCheck<?= 'prodi' . $i ?>"><?= $prodiBiro[$i]->prodiNama; ?></label>
                                                </div>
                                            <?php endfor ?>
                                            <?php if (count($prodiBiro) > 5) : ?>
                                                <p></p>
                                                <a href="#!" data-toggle="modal" data-target="#prodi" class=" card-link">lainnya</a>
                                            <?php endif ?>
                                        <?php else : ?>
                                            <h4 class="card-title">Prodi dari Fakultas</h4>
                                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="smallPrd" class="custom-control-input" id="customCheck<?= 'prodi' . $i ?>" value="<?= $prodi[$i]->prodiId ?>" <?= in_array($prodi[$i]->prodiId, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
                                                    <label class="custom-control-label" for="customCheck<?= 'prodi' . $i ?>"><?= $prodi[$i]->prodiNama; ?></label>
                                                </div>
                                            <?php endfor ?>
                                            <p></p>
                                            <a href="#!" data-toggle="modal" data-target="#prodi" class=" card-link">lainnya</a>
                                        <?php endif ?>
                                        <hr>
                                        <h4 class="card-title">Program Kuliah</h4>
                                        <select class="form-control" name="progKuliah">
                                            <option value="">Pilih Salah Satu</option>
                                            <?php foreach ($programKuliah as $prg) : ?>
                                                <option value="<?= $prg->programKuliahId; ?>" <?= ($prg->programKuliahId == (isset($_GET['pgKuliah']) ? $_GET['pgKuliah'] : "")) ? "selected" : "" ?>><?= $prg->programKuliahNama ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if (isset($_GET['prodi']) && isset($_GET['pgKuliah'])) : ?>
                                            <button class="btn btn-sm bg-primary float-right mb-2" data-toggle="modal" data-target="#tambahProdi"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                                            </button>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <?php if (count($filter) > 0) : ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php foreach ($filter as $fil) : ?>
                                                <?php if ($fil['type'] == "prodi") : ?>
                                                    <span class="mt-2 badge border border-primary text-primary mt-2 mb-3"><?= $fil['value'] ?> <span class="badge badge-primary ml-2" name="filter" data-name="<?= $fil['type'] ?>" data-val="<?= $fil['id'] ?>" style="cursor: pointer;">x</span></span>
                                                <?php elseif ($fil['type'] == "pgKuliah") : ?>
                                                    <span class="mt-2 badge border border-primary text-primary mt-2 mb-3"><?= $fil['value'] ?> <span class="badge badge-primary ml-2" name="filter" data-name="<?= $fil['type'] ?>" data-val="<?= $fil['id'] ?>" style="cursor: pointer;">x</span></span>
                                                <?php elseif ($fil['type'] == "keyword") : ?>
                                                    <span class="mt-2 badge border border-primary text-primary mt-2 mb-3"><?= $fil['value'] ?> <span class="badge badge-primary ml-2" name="filter" data-name="<?= $fil['type'] ?>" data-val="<?= $fil['id'] ?>" style="cursor: pointer;">x</span></span>
                                                <?php endif; ?>
                                            <?php endforeach ?>
                                            <span class="mt-2 badge border border-danger text-danger mt-2 mb-3">Hapus Filter <span name="deleteFilter" class="badge badge-danger ml-2" style="cursor: pointer;"><i class="las la-trash"></i> </span></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <table class="table table-bordered table-responsive-md table-striped ">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="text-align:center">No</th>
                                            <th>Prodi</th>
                                            <th>Program Kuliah</th>
                                            <th>Waktu Kuliah</th>
                                            <th>Kelompok Kuliah</th>
                                            <th style="text-align:center">Status</th>
                                            <th width="15%" style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($setProdiProgKuliah)) : ?>
                                            <?php
                                            $no = 1  + ($numberPage * ($currentPage - 1));
                                            foreach ($setProdiProgKuliah as $row) : ?>
                                                <tr>
                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                    <td><?= $row->prodiNama; ?></td>
                                                    <td><?= $row->programKuliahNama; ?></td>
                                                    <td><?= $row->waktuNama; ?></td>
                                                    <td><?= $row->kelompokKuliahNama; ?></td>
                                                    <td style="text-align:center"><span class="mt-2 badge border <?= ($row->setProdiProgramKuliahIsAktif == 1) ? "border-success text-success" : "border-danger text-danger" ?> mt-2"><?= ($row->setProdiProgramKuliahIsAktif == 1) ? "Aktif" : "Tidak aktif" ?></span></td>
                                                    <td style="text-align:center">
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editProdi<?= $row->setProdiProgramKuliahId ?>"><i class="las la-pen"></i></button>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusProdi<?= $row->setProdiProgramKuliahId ?>"><i class="las la-trash"></i> </button>
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
                                <?= $pager->links('setProdiProgKuliah', 'pager') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- start modal fakultas -->
<div class="modal fade" id="prodi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Prodi dari Fakultas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (in_groups('Fakultas')) : ?>
                    <p><?= $prodiBiro[0]->fakultasNama ?></p>
                    <div class="row">
                        <?php foreach ($prodiBiro as $data) : ?>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" name="prd" class="custom-control-input" id="customCheck<?= $data->prodiId ?>" value="<?= $data->prodiId ?>" <?= in_array($data->prodiId, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
                                    <label class="custom-control-label" for="customCheck<?= $data->prodiId ?>"><?= $data->prodiNama  ?></label>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php else : ?>
                    <?php foreach ($fakultas as $fak) : ?>
                        <p><?= $fak->fakultasNama ?></p>
                        <div class="row">
                            <?php foreach ($prodi as $prd) : ?>
                                <?php if ($fak->fakultasId == $prd->prodiFakultasId) : ?>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" name="prd" class="custom-control-input" id="customCheck<?= $prd->prodiId ?>" value="<?= $prd->prodiId ?>" <?= in_array($prd->prodiId, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
                                            <label class="custom-control-label" for="customCheck<?= $prd->prodiId ?>"><?= $prd->prodiNama  ?> </label>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                        <hr>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary">Reset</button>
                <button type="button" name="prodi" class="btn btn-sm btn-primary">Terapkan</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal fakultas -->

<!-- start modal tambah -->
<div class="modal fade" id="tambahProdi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/setProdiProgKuliah/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="setProdiProgramKuliahProdiId" value="<?= isset($_GET['prodi']) ? $_GET['prodi'] : "" ?>">
                    <input type="hidden" name="setProdiProgramKuliahProgramKuliahId" value="<?= isset($_GET['pgKuliah']) ? $_GET['pgKuliah'] : "" ?>">

                    <div class="form-group">
                        <label>Waktu Kuliah</label>
                        <select class="form-control" name="setProdiProgramKuliahWaktuKuliahId">
                            <option value="">Pilih Waktu Kuliah</option>
                            <?php foreach ($waktuKuliah as $option) : ?>
                                <option value="<?= $option->waktuId ?>"><?= $option->waktuNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelompok Kuliah</label>
                        <select class="form-control" name="setProdiProgramKuliahKelompokKuliahId">
                            <option value="">Pilih Kelompok Kuliah</option>
                            <?php foreach ($kelompokKuliah as $option) : ?>
                                <option value="<?= $option->kelompokKuliahId ?>"><?= $option->kelompokKuliahNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                            <div class="custom-switch-inner">
                                <input type="checkbox" class="custom-control-input" id="customSwitchAdd" checked="" name="setProdiProgramKuliahIsAktif">
                                <label class="custom-control-label" for="customSwitchAdd">
                                    <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                    <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                </label>
                            </div>
                        </div>
                        <label>Status (Aktif/Tidak Aktif)</label>
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
<?php foreach ($setProdiProgKuliah as $edit) : ?>
    <div class="modal fade" id="editProdi<?= $edit->setProdiProgramKuliahId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $edit->prodiNama ?> <?= $edit->programKuliahNama; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/setProdiProgKuliah/ubah/<?= $edit->setProdiProgramKuliahId ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Prodi</label>
                            <select class="form-control" name="setProdiProgramKuliahProdiId">
                                <option value="">Pilih Prodi</option>
                                <?php if (in_groups('Fakultas')) : ?>
                                    <?php foreach ($prodiBiro as $option) : ?>
                                        <option value="<?= $option->prodiId ?>" <?= ($option->prodiId == $edit->setProdiProgramKuliahProdiId) ? "selected" : "" ?>><?= $option->prodiNama ?></option>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?php foreach ($prodi as $option) : ?>
                                        <option value="<?= $option->prodiId ?>" <?= ($option->prodiId == $edit->setProdiProgramKuliahProdiId) ? "selected" : "" ?>><?= $option->prodiNama ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Program Kuliah</label>
                            <select class="form-control" name="setProdiProgramKuliahProgramKuliahId">
                                <option value="">Pilih Program Kuliah</option>
                                <?php foreach ($programKuliah as $option) : ?>
                                    <option value="<?= $option->programKuliahId ?>" <?= ($option->programKuliahId == $edit->setProdiProgramKuliahProgramKuliahId) ? "selected" : "" ?>><?= $option->programKuliahNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Waktu Kuliah</label>
                            <select class="form-control" name="setProdiProgramKuliahWaktuKuliahId">
                                <option value="">Pilih Waktu Kuliah</option>
                                <?php foreach ($waktuKuliah as $option) : ?>
                                    <option value="<?= $option->waktuId ?>" <?= ($option->waktuId == $edit->setProdiProgramKuliahWaktuKuliahId) ? "selected" : "" ?>><?= $option->waktuNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelompok Kuliah</label>
                            <select class="form-control" name="setProdiProgramKuliahKelompokKuliahId">
                                <option value="">Pilih Kelompok Kuliah</option>
                                <?php foreach ($kelompokKuliah as $option) : ?>
                                    <option value="<?= $option->kelompokKuliahId ?>" <?= ($option->kelompokKuliahId == $edit->setProdiProgramKuliahKelompokKuliahId) ? "selected" : "" ?>><?= $option->kelompokKuliahNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                <div class="custom-switch-inner">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch<?= $edit->setProdiProgramKuliahId ?>" <?= $edit->setProdiProgramKuliahIsAktif ?>" <?= ($edit->setProdiProgramKuliahIsAktif == '1') ? 'checked' : ''; ?> value="<?= ($edit->setProdiProgramKuliahIsAktif == null) ? 0 : 1; ?>" name="setProdiProgramKuliahIsAktif">
                                    <label class="custom-control-label" for="customSwitch<?= $edit->setProdiProgramKuliahId ?>">
                                        <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                        <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                    </label>
                                </div>
                            </div>
                            <label>Status (Aktif/Tidak Aktif)</label>
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
<?php foreach ($setProdiProgKuliah as $hapus) : ?>
    <div class="modal fade" id="hapusProdi<?= $hapus->setProdiProgramKuliahId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Prodi Program Kuliah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data prodi <strong><?= $hapus->prodiNama; ?></strong> program kuliah <strong><?= $hapus->programKuliahNama; ?></strong> ?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/setProdiProgKuliah/hapus/<?= $hapus->setProdiProgramKuliahId; ?>" method="post">
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