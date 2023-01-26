<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/keuTarifTambahan" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if ($validation->hasError('tarifLainNominal')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tarifLainNominal')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tarifLainDeskripsi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tarifLainDeskripsi')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tarifLainJenisBiayaId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tarifLainJenisBiayaId')]]); ?>
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
                                        <h4 class="card-title">Prodi dari Fakultas</h4>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="smallPrd" class="custom-control-input" id="customCheck0" value="99" <?= in_array(99, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
                                            <label class="custom-control-label" for="customCheck0">Semua Prodi</label>
                                        </div>
                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="smallPrd" class="custom-control-input" id="customCheck<?= 'prodi' . $i ?>" value="<?= $prodi[$i]->prodiId ?>" <?= in_array(99, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?><?= in_array($prodi[$i]->prodiId, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
                                                <label class="custom-control-label" for="customCheck<?= 'prodi' . $i ?>"><?= $prodi[$i]->prodiNama; ?></label>
                                            </div>
                                        <?php endfor ?>
                                        <p></p>
                                        <a href="#!" data-toggle="modal" data-target="#prodi" class=" card-link">lainnya</a>
                                        <hr>
                                        <h4 class="card-title">Kelompok Kuliah</h4>
                                        <select class="form-control" name="kelKuliah">
                                            <option value="">Pilih Salah Satu</option>
                                            <?php foreach ($kelompokKuliah as $prg) : ?>
                                                <option value="<?= $prg->kelompokKuliahId; ?>" <?= ($prg->kelompokKuliahId == (isset($_GET['kelKuliah']) ? $_GET['kelKuliah'] : "")) ? "selected" : "" ?>><?= $prg->kelompokKuliahNama ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <hr>
                                        <h4 class="card-title">Jenis Biaya</h4>
                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="smallJenis" class="custom-control-input" id="customCheck<?= 'jenisBiaya' . $i ?>" value="<?= $tagihan[$i]->refJenisBiayaId ?>" <?= in_array($tagihan[$i]->refJenisBiayaId, (isset($_GET['jenisBiaya']) ? explode(",", $_GET['jenisBiaya']) : [])) ? "checked" : "" ?>>
                                                <label class="custom-control-label" for="customCheck<?= 'jenisBiaya' . $i ?>"><?= $tagihan[$i]->refJenisBiayaNama; ?></label>
                                            </div>
                                        <?php endfor ?>
                                        <p></p>
                                        <a href="#!" data-toggle="modal" data-target="#jenisBiaya" class=" card-link">lainnya</a>\
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if (isset($_GET['jenisBiaya']) && isset($_GET['kelKuliah']) && isset($_GET['prodi'])) : ?>
                                            <button class="btn btn-sm bg-primary float-right mb-2" data-toggle="modal" data-target="#tambah"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                                            </button>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <?php if (count($filter) > 0) : ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php foreach ($filter as $fil) : ?>
                                                <?php if ($fil['type'] == "kelKuliah") : ?>
                                                    <span class="mt-2 badge border border-primary text-primary mt-2 mb-3"><?= $fil['value'] ?> <span class="badge badge-primary ml-2" name="filter" data-name="<?= $fil['type'] ?>" data-val="<?= $fil['id'] ?>" style="cursor: pointer;">x</span></span>
                                                <?php elseif ($fil['type'] == "jenisBiaya") : ?>
                                                    <span class="mt-2 badge border border-primary text-primary mt-2 mb-3"><?= $fil['value'] ?> <span class="badge badge-primary ml-2" name="filter" data-name="<?= $fil['type'] ?>" data-val="<?= $fil['id'] ?>" style="cursor: pointer;">x</span></span>
                                                <?php elseif ($fil['type'] == "prodi") : ?>
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
                                            <th>Kelompok Kuliah</th>
                                            <th>Jenis Biaya</th>
                                            <th>Tahap</th>
                                            <th>Semester</th>
                                            <th>Deskripsi</th>
                                            <th width="13%" style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($tagihanLain)) : ?>
                                            <?php
                                            $no = 1  + ($numberPage * ($currentPage - 1));
                                            foreach ($tagihanLain as $row) : ?>
                                                <tr>
                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                    <td><?= ($row->tarifLainProdiId == null) ? 'Semua Prodi' : $row->prodiNama; ?></td>
                                                    <td><?= $row->kelompokKuliahNama; ?></td>
                                                    <td><?= $row->refJenisBiayaNama; ?></td>
                                                    <td><?= ($row->tarifLainIncludeTahap == 0) ? 'Lunas' : $row->tarifLainIncludeTahap; ?></td>
                                                    <td><?= $row->tarifLainSemester == 0 ? 'Semua' : ($row->tarifLainSemester == 1 ? 'Ganjil' : 'Genap') ?></td>
                                                    <td><?= $row->tarifLainDeskripsi; ?></td>
                                                    <td style="text-align:center">
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editTambahan<?= $row->tarifLainId ?>"><i class="las la-pen"></i></button>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusTambahan<?= $row->tarifLainId ?>"><i class="las la-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <tr>
                                                <?= view('layout/templateEmpty', ['jumlahSpan' => 9]); ?>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                                <?= $pager->links('keuTarifTambahan', 'pager') ?>
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
                <?php foreach ($fakultas as $fak) : ?>
                    <p><?= $fak->fakultasNama ?></p>
                    <div class="row">
                        <?php foreach ($prodi as $prd) : ?>
                            <?php if ($fak->fakultasId == $prd->prodiFakultasId) : ?>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" name="prd" class="custom-control-input" id="customCheck<?= $prd->prodiId ?>" value="<?= $prd->prodiId ?>" <?= in_array(99, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?><?= in_array($prd->prodiId, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
                                        <label class="custom-control-label" for="customCheck<?= $prd->prodiId ?>"><?= $prd->prodiNama  ?> </label>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                    <hr>
                <?php endforeach ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary">Reset</button>
                <button type="button" name="prodi" class="btn btn-sm btn-primary">Terapkan</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal fakultas -->

<!-- start modal jenis biaya -->
<div class="modal fade" id="jenisBiaya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Jenis Biaya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($tagihan as $data) : ?>
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="jenisBiaya" class="custom-control-input" id="<?= 'jenisBiaya' . $data->refJenisBiayaId ?>" value="<?= $data->refJenisBiayaId ?>" <?= in_array($data->refJenisBiayaId, (isset($_GET['jenisBiaya']) ? explode(",", $_GET['jenisBiaya']) : [])) ? "checked" : "" ?>>
                                <label class="custom-control-label" for="<?= 'jenisBiaya' . $data->refJenisBiayaId ?>"><?= $data->refJenisBiayaNama; ?></label>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary">Reset</button>
                <button type="button" name="jenisBiaya" class="btn btn-sm btn-primary">Terapkan</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal jenis biaya -->

<!-- start modal tambah -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="/keuTarifTambahan/tambah" method="post">
                <?= csrf_field() ?>
                <div class=" modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tarifLainKelompokKuliahId" value="<?= isset($_GET['kelKuliah']) ? $_GET['kelKuliah'] : "" ?>">
                    <input type="hidden" name="tarifLainJenisBiayaId" value="<?= isset($_GET['jenisBiaya']) ? $_GET['jenisBiaya'] : "" ?>">
                    <input type="hidden" name="tarifLainProdiId" value="<?= isset($_GET['prodi']) ? $_GET['prodi'] : "" ?>">
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" class="form-control" name="tarifLainNominal">
                    </div>
                    <div class="form-group">
                        <label>Pembayaran Tahap</label>
                        <br>
                        <?php for ($i = 1; $i <= $tahap; $i++) : ?>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="tahap<?= $i ?>" value="<?= $i ?>" name="tarifLainIncludeTahap" class="custom-control-input" <?= ($i == 1) ? "checked" : "" ?>>
                                <label class="custom-control-label" for="tahap<?= $i ?>"><?= $i ?></label>
                            </div>
                        <?php endfor ?>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <br>
                        <?php for ($i = 0; $i < 3; $i++) : ?>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="semester<?= $i ?>" value="<?= $i ?>" name="tarifLainSemester" class="custom-control-input" <?= ($i == 0) ? "checked" : "" ?>>
                                <label class="custom-control-label" for="semester<?= $i ?>"><?= $i == 0 ? 'Semua' : ($i == 1 ? 'Ganjil' : 'Genap') ?></label>
                            </div>
                        <?php endfor ?>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="2" name="tarifLainDeskripsi"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                            <div class="custom-switch-inner">
                                <input type="checkbox" class="custom-control-input" id="customSwitchAdd" name="tarifLainIsAllowedAmount">
                                <label class="custom-control-label" for="customSwitchAdd">
                                    <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                    <span class="switch-icon-right"><i class="fa fa-times"></i></span>
                                </label>
                            </div>
                        </div>
                        <label>Izinkan Lebih dari Satu Tagihan</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal edit -->
<?php foreach ($tagihanLain as $edit) : ?>
    <div class="modal fade" id="editTambahan<?= $edit->tarifLainId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form action="/keuTarifTambahan/ubah/<?= $edit->tarifLainId ?>" method="post">
                    <?= csrf_field() ?>
                    <div class=" modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $edit->refJenisBiayaNama; ?> di <?= ($edit->tarifLainProdiId == null) ? 'Semua Prodi' : 'Prodi ' . $edit->prodiNama; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="tarifLainKelompokKuliahId" value="<?= $edit->tarifLainKelompokKuliahId ?>">
                        <input type="hidden" name="tarifLainProdiId" value="<?= $edit->tarifLainProdiId ?>">
                        <input type="hidden" name="oldTarifLainJenisBiayaId" value="<?= $edit->tarifLainJenisBiayaId ?>">
                        <div class="form-group">
                            <label>Jenis Biaya</label>
                            <select class="form-control" name="tarifLainJenisBiayaId">
                                <option value="">Pilih Jenis Biaya</option>
                                <?php foreach ($tagihan as $option) : ?>
                                    <option value="<?= $option->refJenisBiayaId ?>" <?= ($option->refJenisBiayaId == $edit->tarifLainJenisBiayaId) ? 'selected' : ''; ?>><?= $option->refJenisBiayaNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nominal</label>
                            <input type="number" class="form-control" name="tarifLainNominal" value="<?= $edit->tarifLainNominal ?>">
                        </div>
                        <div class="form-group">
                            <label>Pembayaran Tahap</label>
                            <br>
                            <?php
                            $prodi = ($edit->tarifLainProdiId == 0) ? null : [$edit->tarifLainProdiId];
                            $tahap = getKeuTahap($prodi)[0]->refKeuTahapJumlah;
                            for ($i = 1; $i <= $tahap; $i++) : ?>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="tahap<?= $i . $edit->tarifLainId ?>" value="<?= $i ?>" <?= ($i == $edit->tarifLainIncludeTahap) ? 'checked' : ''; ?> name="tarifLainIncludeTahap" class="custom-control-input">
                                    <label class="custom-control-label" for="tahap<?= $i . $edit->tarifLainId ?>"><?= $i ?></label>
                                </div>
                            <?php endfor ?>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <br>
                            <?php for ($i = 0; $i < 3; $i++) : ?>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="semester<?= $i . $edit->tarifLainId ?>" value="<?= $i ?>" <?= ($i == $edit->tarifLainSemester) ? 'checked' : ''; ?> name="tarifLainSemester" class="custom-control-input">
                                    <label class="custom-control-label" for="semester<?= $i . $edit->tarifLainId ?>"><?= $i == 0 ? 'Semua' : ($i == 1 ? 'Ganjil' : 'Genap') ?></label>
                                </div>
                            <?php endfor ?>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" rows="2" name="tarifLainDeskripsi"><?= $edit->tarifLainDeskripsi; ?></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                <div class="custom-switch-inner">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch<?= $edit->tarifLainId ?>" <?= ($edit->tarifLainIsAllowedAmount == '1') ? 'checked' : ''; ?> value="<?= ($edit->tarifLainIsAllowedAmount == 0) ? '0' : '1'; ?>" name="tarifLainIsAllowedAmount">
                                    <label class="custom-control-label" for="customSwitch<?= $edit->tarifLainId ?>">
                                        <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                        <span class="switch-icon-right"><i class="fa fa-times"></i></span>
                                    </label>
                                </div>
                            </div>
                            <label>Izinkan Lebih dari Satu Tagihan</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal edit -->

<!-- start modal hapus -->
<?php foreach ($tagihanLain as $hapus) : ?>
    <div class="modal fade" id="hapusTambahan<?= $hapus->tarifLainId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data tarif tambahan <strong><?= $hapus->refJenisBiayaNama ?></strong> di <strong><?= ($hapus->tarifLainProdiId == null) ? 'Semua Prodi' : 'Prodi ' . $hapus->prodiNama; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/keuTarifTambahan/hapus/<?= $hapus->tarifLainId; ?>" method="post">
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