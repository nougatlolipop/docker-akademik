<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href=" /tahapPembayaran" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if ($validation->hasError('refKeuTahapJumlah')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('refKeuTahapJumlah')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('refKeuTahapAngkatan')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('refKeuTahapAngkatan')]]); ?>
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
                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="smallPrd" class="custom-control-input" id="customCheck<?= 'prodi' . $i ?>" value="<?= $prodi[$i]->prodiId ?>" <?= in_array($prodi[$i]->prodiId, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
                                                <label class="custom-control-label" for="customCheck<?= 'prodi' . $i ?>"><?= $prodi[$i]->prodiNama; ?></label>
                                            </div>
                                        <?php endfor ?>
                                        <p></p>
                                        <a href="#!" data-toggle="modal" data-target="#prodi" class=" card-link">lainnya</a>
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
                                            <button class="btn btn-sm bg-primary float-right mb-2 tambahProdiProg" data-toggle="modal" data-target="#tambahTahap"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                                            </button>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <?php if (count($filter) > 0) : ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php foreach ($filter as $fil) : ?>
                                                <?php if ($fil['type'] == "pgKuliah") : ?>
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
                                            <th width="5%" style="text-align:center">No.</th>
                                            <th>Prodi</th>
                                            <th>Program Kuliah</th>
                                            <th>Angkatan</th>
                                            <th>Jumlah Tahap</th>
                                            <th width="15%" style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($keuTahap)) : ?>
                                            <?php
                                            $no = 1  + ($numberPage * ($currentPage - 1));
                                            foreach ($keuTahap as $row) : ?>
                                                <tr>
                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                    <td><?= $row->prodiNama; ?></td>
                                                    <td><?= $row->programKuliahNama; ?></td>
                                                    <td><?= $row->refKeuTahapAngkatan; ?></td>
                                                    <td><?= $row->refKeuTahapJumlah; ?></td>
                                                    <td style="text-align:center">
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editTahap<?= $row->refKeuTahapId ?>"><i class="las la-pen"></i></button>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusTahap<?= $row->refKeuTahapId ?>"><i class="las la-trash"></i></button>
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
                                <?= $pager->links('keuTahap', 'pager') ?>
                            </div>
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
                                        <input type="checkbox" name="prd" class="custom-control-input" id="customCheck<?= $prd->prodiId ?>" value="<?= $prd->prodiId ?>" <?= in_array($prd->prodiId, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
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

<!-- start modal tambah -->
<div class="modal fade" id="tambahTahap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/keuTahap/tambah" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="refKeuTahapProdiId" value="<?= isset($_GET['prodi']) ? $_GET['prodi'] : "" ?>">
                <input type="hidden" name="refKeuTahapProgramKuliahId" value="<?= isset($_GET['pgKuliah']) ? $_GET['pgKuliah'] : "" ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Angkatan</label>
                        <input type="number" class="form-control" name="refKeuTahapAngkatan">
                    </div>
                    <div class="form-group">
                        <label>Jumlah Tahap</label>
                        <input type="number" class="form-control" name="refKeuTahapJumlah" id="jumlahTahap">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                            <div class="custom-switch-inner">
                                <input type="checkbox" class="custom-control-input" id="cekHer" value="1" name="refKeuTahapIsHer" onchange="cek_her()">
                                <label class="custom-control-label" for="cekHer">
                                    <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                    <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                </label>
                            </div>
                        </div>
                        <label>Her-Registrasi (Tidak/Ya)</label>
                    </div>
                    <div class="form-group" id="tahap">
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
<?php foreach ($keuTahap as $edit) : ?>
    <div class="modal fade" id="editTahap<?= $edit->refKeuTahapId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $title ?> <?= $edit->prodiNama; ?> <?= $edit->programKuliahNama; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/keuTahap/ubah/<?= $edit->refKeuTahapId ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="refKeuTahapProdiId" value="<?= $edit->refKeuTahapProdiId ?>">
                    <input type="hidden" name="refKeuTahapProgramKuliahId" value="<?= $edit->refKeuTahapProgramKuliahId ?>">
                    <input type="hidden" name="oldRefKeuTahapAngkatan" value="<?= $edit->refKeuTahapAngkatan ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Angkatan</label>
                            <input type="number" class="form-control" name="refKeuTahapAngkatan" value="<?= $edit->refKeuTahapAngkatan ?>">
                        </div>
                        <div class="form-group">
                            <label>Jumlah Tahap</label>
                            <input type="number" class="form-control" name="refKeuTahapJumlah" value="<?= $edit->refKeuTahapJumlah ?>">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                <div class="custom-switch-inner">
                                    <input type="checkbox" class="custom-control-input" id="cekHer<?= $edit->refKeuTahapId ?>" value="1" name="refKeuTahapIsHer" <?= ($edit->refKeuTahapIsHer == 1) ? 'checked' : '' ?> disabled>
                                    <label class="custom-control-label" for="cekHer<?= $edit->refKeuTahapId ?>">
                                        <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                        <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                    </label>
                                </div>
                            </div>
                            <label>Her-Registrasi (Tidak/Ya)</label>
                        </div>
                        <?php if ($edit->refKeuTahapIsHer) : ?>
                            <div class="form-group">
                                <?php for ($tahap = 1; $tahap <= $edit->refKeuTahapJumlah; $tahap++) : ?>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" name="refKeuTahapHer[]" class="custom-control-input" id="tahap<?= $tahap ?>" value="<?= $tahap ?>" <?= (in_array($tahap, json_decode($edit->refKeuTahapHer))) ? 'checked' : ''; ?> disabled>
                                        <label class="custom-control-label" for="tahap<?= $tahap ?>">Tahap <?= $tahap ?></label>
                                    </div>
                                <?php endfor ?>
                            </div>
                        <?php endif ?>
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
<?php foreach ($keuTahap as $hapus) : ?>
    <div class="modal fade" id="hapusTahap<?= $hapus->refKeuTahapId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data tahap pembayaran prodi <strong><?= $hapus->prodiNama; ?></strong>, program kuliah <strong><?= $hapus->programKuliahNama; ?></strong>, angkatan <strong><?= $hapus->refKeuTahapAngkatan; ?></strong> ?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/keuTahap/hapus/<?= $hapus->refKeuTahapId; ?>" method="post">
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

< <!-- Wrapper End-->

    <?= view('layout/templateFooter'); ?>

    <?= $this->endSection(); ?>