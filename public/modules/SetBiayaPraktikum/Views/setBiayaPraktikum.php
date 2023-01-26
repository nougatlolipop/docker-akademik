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
        <?php if ($validation->hasError('matkulKurikulum')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('matkulKurikulum')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tarifLainDeskripsi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tarifLainDeskripsi')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tarifLainNominal')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tarifLainNominal')]]); ?>
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
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Kelompok Kuliah</h4>
                                        <select class="form-control" name="kelKuliah">
                                            <option value="">Pilih Salah Satu</option>
                                            <?php foreach ($kelompokKuliah as $prg) : ?>
                                                <option value="<?= $prg->kelompokKuliahId; ?>" <?= ($prg->kelompokKuliahId == (isset($_GET['kelKuliah']) ? $_GET['kelKuliah'] : "")) ? "selected" : "" ?>><?= $prg->kelompokKuliahNama ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <hr>
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
                                        <?php if (isset($_GET['kelKuliah']) && isset($_GET['prodi']) && isset($_GET['pgKuliah'])) : ?>
                                            <button class="btn btn-sm bg-primary float-right mb-2 <?= isset($_GET['prodi']) ? "tambahPrak" : "" ?>" data-toggle="modal" data-target="#tambah"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
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
                                                <?php elseif ($fil['type'] == "pgKuliah") : ?>
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
                                            <th width="3%" style="text-align:center">No</th>
                                            <th>Prodi</th>
                                            <th width="13%">Kelompok Kuliah</th>
                                            <th>Mata Kuliah Ditawarkan</th>
                                            <th>Nominal</th>
                                            <th>Tahap</th>
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
                                                    <td><?= $row->matkulKode; ?> - <?= $row->matkulNama; ?> (<?= $row->matkulGroupKode; ?>) / <?= $row->kurikulumNama; ?> - <?= $row->studiLevelNama; ?> / <?= $row->kelasKode . $row->waktuNama ?></td>
                                                    <td><?= number_to_currency($row->tarifLainNominal, 'Rp. ', 'id_ID', 2); ?></td>
                                                    <td><?= ($row->tarifLainIncludeTahap == 0) ? 'Lunas' : $row->tarifLainIncludeTahap; ?></td>
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
                                <?= $pager->links('setBiayaPraktikum', 'pager') ?>
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
    <div class="modal-dialog modal-dialog-centered  modal-xl" role="document">
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
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
            <form action="/setBiayaPraktikum/tambah" method="post">
                <?= csrf_field() ?>
                <div class=" modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tarifLainKelompokKuliahId" value="<?= isset($_GET['kelKuliah']) ? $_GET['kelKuliah'] : "" ?>">
                    <input type="hidden" name="tarifLainProdiId" value="<?= isset($_GET['prodi']) ? $_GET['prodi'] : "" ?>">
                    <div class="form-group">
                        <label>Mata Kuliah Kurikulum</label>
                        <select class="form-control matkulPrak" name="matkulKurikulum">
                            <option value="">Pilih Matkul Kurikulum</option>
                        </select>
                    </div>
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
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="2" name="tarifLainDeskripsi"></textarea>
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
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <form action="/setBiayaPraktikum/ubah/<?= $edit->tarifLainId ?>" method="post">
                    <?= csrf_field() ?>
                    <div class=" modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= ($edit->tarifLainProdiId == null) ? 'Semua Prodi' : 'Prodi ' . $edit->prodiNama; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="tarifLainProdiId" value="<?= $edit->tarifLainProdiId ?>">
                        <input type="hidden" name="tarifLainKelompokKuliahId" value="<?= $edit->tarifLainKelompokKuliahId ?>">
                        <input type="hidden" name="tarifLainMatkulTawarId" value="<?= $edit->tarifLainMatkulTawarId ?>">
                        <input type="hidden" name="tarifLainMatkulTawarId" value="<?= $edit->tarifLainMatkulTawarId ?>">
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
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" rows="2" name="tarifLainDeskripsi"><?= $edit->tarifLainDeskripsi; ?></textarea>
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
                <form action="/setBiayaPraktikum/hapus/<?= $hapus->tarifLainId; ?>" method="post">
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