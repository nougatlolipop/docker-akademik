<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/setMatkulKurikulum" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if ($validation->hasError('setMatkulKurikulumKurikulumTawarId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulKurikulumKurikulumTawarId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setMatkulKurikulumMatkulId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulKurikulumMatkulId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setMatkulKurikulumMatkulGroupId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulKurikulumMatkulGroupId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setMatkulKurikulumStudiLevelId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulKurikulumStudiLevelId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setMatkulKurikulumSks')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulKurikulumSks')]]); ?>
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
                                        <hr>
                                        <h4 class="card-title">Kurikulum</h4>
                                        <select class="form-control" name="kurikulum">
                                            <option value="">Pilih Salah Satu</option>
                                            <?php foreach ($kurikulum as $krl) : ?>
                                                <option value="<?= $krl->kurikulumId; ?>" <?= ($krl->kurikulumId == (isset($_GET['kurikulum']) ? $_GET['kurikulum'] : "")) ? "selected" : "" ?>><?= $krl->kurikulumNama ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if (isset($_GET['prodi']) && isset($_GET['pgKuliah']) && isset($_GET['kurikulum'])) : ?>
                                            <button class="btn btn-sm bg-primary float-right mb-2 tambahMatkulKurikulum" data-toggle="modal" data-target="#tambahProdi"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
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
                                                <?php elseif ($fil['type'] == "kurikulum") : ?>
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
                                            <th width="13%">Program Kuliah</th>
                                            <th>Mata Kuliah</th>
                                            <th>SKS</th>
                                            <th>Kurikulum</th>
                                            <th>Studi Level</th>
                                            <th width="15%" style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($setMatkulKurikulum)) : ?>
                                            <?php
                                            $no = 1  + ($numberPage * ($currentPage - 1));
                                            foreach ($setMatkulKurikulum as $row) : ?>
                                                <tr>
                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                    <td><?= $row->prodiNama; ?></td>
                                                    <td><?= $row->programKuliahNama; ?></td>
                                                    <td><?= $row->matkulKode; ?> - <?= $row->matkulNama; ?> (<?= $row->matkulGroupKode; ?>)</td>
                                                    <td><?= $row->setMatkulKurikulumSks; ?></td>
                                                    <td><?= $row->kurikulumNama; ?></td>
                                                    <td><?= $row->studiLevelNama; ?></td>
                                                    <td style="text-align:center">
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editMatkul<?= $row->setMatkulKurikulumId ?>"><i class="las la-pen"></i></button>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusMatkul<?= $row->setMatkulKurikulumId ?>"><i class="las la-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <tr>
                                                <?= view('layout/templateEmpty', ['jumlahSpan' => 11]); ?>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                                <?= $pager->links('setMatkulKurikulum', 'pager') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
            <form action="/setMatkulKurikulum/tambah" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kurikulum Ditawarkan</label>
                        <select class="form-control kurikulumAkademik" name="setMatkulKurikulumKurikulumTawarId">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Studi Level</label>
                        <select class="form-control studiLevelAkademik" name="setMatkulKurikulumStudiLevelId">
                            <option value="">Pilih Studi Level</option>
                            <?php foreach ($studiLevel as $option) : ?>
                                <option value="<?= $option->studiLevelId ?>"><?= $option->studiLevelNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mata Kuliah</label>
                        <table class="table table-bordered table-responsive-md table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" style=" text-align:center">Pilih</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th width="40%">Kelompok</th>
                                    <th width="10%" style=" text-align:center">SKS</th>
                                </tr>
                            </thead>
                            <tbody class="matkulProdi">
                                <tr>
                                    <td colspan="4" style="text-align:center">Mata Kuliah Belum Dicari</td>
                                </tr>
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
<!-- end modal tambah -->

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

<!-- start modal edit -->
<?php foreach ($setMatkulKurikulum as $edit) : ?>
    <div class="modal fade" id="editMatkul<?= $edit->setMatkulKurikulumId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/setMatkulKurikulum/ubah/<?= $edit->setMatkulKurikulumId ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="oldSetMatkulKurikulumKurikulumTawarId" value="<?= $edit->setMatkulKurikulumKurikulumTawarId ?>">
                    <input type="hidden" name="oldSetMatkulKurikulumStudiLevelId" value="<?= $edit->setMatkulKurikulumStudiLevelId ?>">
                    <input type="hidden" name="oldSetMatkulKurikulumMatkulId" value="<?= $edit->setMatkulKurikulumMatkulId ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Prodi</label>
                            <select class="form-control prodiAkademik" name="prodi">
                                <option value="">Pilih Prodi</option>
                                <?php if (in_groups('Fakultas')) : ?>
                                    <?php foreach ($prodiBiro as $option) : ?>
                                        <option value="<?= $option->prodiId ?>" <?= ($option->prodiId == $edit->setKurikulumTawarProdiId) ? "selected" : "" ?>><?= $option->prodiNama ?></option>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?php foreach ($prodi as $option) : ?>
                                        <option value="<?= $option->prodiId ?>" <?= ($option->prodiId == $edit->setKurikulumTawarProdiId) ? "selected" : "" ?>><?= $option->prodiNama ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Program Kuliah</label>
                            <select class="form-control programKuliahAkademik" name="programKuliah">
                                <option value="<?= $edit->programKuliahId ?>" selected><?= $edit->programKuliahNama ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kurikulum Ditawarkan</label>
                            <select class="form-control kurikulumDitawarkanAkademik" name="setMatkulKurikulumKurikulumTawarId">
                                <option value="<?= $edit->setKurikulumTawarId ?>" selected><?= $edit->kurikulumNama ?> - Angkatan <?= $edit->setKurikulumTawarAngkatan ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Studi Level</label>
                            <select class="form-control" name="setMatkulKurikulumStudiLevelId">
                                <option value="">Pilih Studi Level</option>
                                <?php foreach ($studiLevel as $option) : ?>
                                    <option value="<?= $option->studiLevelId ?>" <?= ($option->studiLevelId == $edit->setMatkulKurikulumStudiLevelId) ? "selected" : "" ?>><?= $option->studiLevelNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelompok Mata Kuliah</label>
                            <select class="form-control kelompokMatkul" name="setMatkulKurikulumMatkulGroupId">
                                <option value="">Pilih Kelompok Mata Kuliah</option>
                                <?php foreach ($matkulGroup as $option) : ?>
                                    <option value="<?= $option->matkulGroupId ?>" <?= ($option->matkulGroupId == $edit->setMatkulKurikulumMatkulGroupId) ? "selected" : "" ?>><?= $option->matkulGroupNama ?> (<?= $option->matkulGroupKode; ?>)</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mata Kuliah</label>
                            <select class="form-control matkulProdiAkademik" name="setMatkulKurikulumMatkulId">
                                <option value="<?= $edit->matkulId ?>" selected><?= $edit->matkulKode ?> - <?= $edit->matkulNama; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah SKS</label>
                            <input type="number" class="form-control" name="setMatkulKurikulumSks" value="<?= $edit->setMatkulKurikulumSks ?>">
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
<?php foreach ($setMatkulKurikulum as $hapus) : ?>
    <div class="modal fade" id="hapusMatkul<?= $hapus->setMatkulKurikulumId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data <strong>Mata Kuliah <?= $hapus->matkulNama; ?> <?= $hapus->kurikulumNama; ?>, <?= $hapus->prodiNama; ?>/<?= $hapus->programKuliahNama; ?> Untuk <?= $hapus->studiLevelNama; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/setMatkulKurikulum/hapus/<?= $hapus->setMatkulKurikulumId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="url" value="<?= $_SERVER['REQUEST_URI'] ?>">
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