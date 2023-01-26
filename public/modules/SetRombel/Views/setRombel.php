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
        <div id="alert"></div>
        <?php if ($validation->hasError('setRombelKelasId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setRombelKelasId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setRombelAngkatan')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setRombelAngkatan')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setRombelDosenPA')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setRombelDosenPA')]]); ?>
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
                                            <button class="btn btn-sm bg-primary float-right mb-2 tambahProdiProg" data-toggle="modal" data-target="#tambahDosenPa"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
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
                                            <th>Tahun Ajaran</th>
                                            <th>Prodi</th>
                                            <th>Program Kuliah</th>
                                            <th>Kelas</th>
                                            <th>Angkatan</th>
                                            <th>Dosen PA</th>
                                            <th width="15%" style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($setRombel)) : ?>
                                            <?php
                                            $no = 1  + ($numberPage * ($currentPage - 1));
                                            foreach ($setRombel as $row) : ?>
                                                <tr>
                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                    <td><?= ($row->setRombelTahunAjaranId == null) ? "Belum disetting" : $row->tahunAjaranNama; ?></td>
                                                    <td><?= $row->prodiNama; ?></td>
                                                    <td><?= $row->programKuliahNama; ?></td>
                                                    <td><?= ($row->kelasKode == null) ? '' : $row->kelasKode; ?> <?= $row->waktuNama; ?></td>
                                                    <td><?= $row->setRombelAngkatan; ?></td>
                                                    <td><?= ($row->setRombelDosenPA == null) ? "Belum disetting" : ($row->dosenGelarDepan == null ? "" : $row->dosenGelarDepan) . " " . $row->dosenNama . " " . $row->dosenGelarBelakang; ?></td>
                                                    <td style="text-align:center">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dosen<?= $row->setRombelId ?>"><i class="las la-user"></i></button>
                                                        <button type="button" <?= ($row->setRombelId == null) ? "disabled" : ""; ?> class="btn btn-secondary" data-toggle="modal" data-target="#editDosen<?= $row->setRombelId ?>"><i class="las la-pen"></i></button>
                                                        <button type="button" <?= ($row->setRombelId == null) ? "disabled" : ""; ?> class="btn btn-danger" data-toggle="modal" data-target="#hapusDosen<?= $row->setRombelId ?>"><i class="las la-trash"></i></button>
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
                                <?= $pager->links('setRombel', 'pager') ?>
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

<!-- start modal tambah Dosen -->
<?php foreach ($setRombel as $dosen) : ?>
    <div class="modal fade" id="dosen<?= $dosen->setRombelId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Dosen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Type here to search..." aria-describedby="basic-addon2" name="cariSetRombel<?= $dosen->setRombelId ?>" onkeyup="cariSetRombel(<?= $dosen->setRombelId ?>,<?= $dosen->setRombelProdiProgramKuliahId ?>,<?= $dosen->setRombelDosenPA ?>)" onkeypress="check()">
                                        <div class=" input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"><span class="las la-search" onclick="cariSetRombel(<?= $dosen->setRombelId ?>,<?= $dosen->setRombelProdiProgramKuliahId ?>,<?= $dosen->setRombelDosenPA ?>)"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="alertSetRombel<?= $dosen->setRombelId ?>" class="mb-3">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-responsive-md">
                                <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th>Nama Dosen</th>
                                    </tr>
                                </thead>
                                <tbody id="pilihSetRombel<?= $dosen->setRombelId ?>">
                                    <tr>
                                        <td colspan="2" style="text-align: center;">Data dosen belum dicari</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="updateSetRombel<?= $dosen->setRombelId ?>">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal tambah Dosen -->

<!-- start modal tambah -->
<div class="modal fade" id="tambahDosenPa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/setRombel/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Prodi Program Kuliah</label>
                        <select class="form-control prodiProgRombel" name="setRombelProdiProgramKuliahId">
                            <option value="">Pilih Prodi Program Kuliah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <select class="form-control" name="setRombelKelasId">
                            <option value="">Pilih Kelas</option>
                            <?php foreach ($kelas as $option) : ?>
                                <option value="<?= $option->kelasId ?>"><?= $option->kelasKode; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Angkatan</label>
                        <input type="text" class="form-control" name="setRombelAngkatan">
                    </div>
                    <div class="form-group">
                        <label>Dosen PA</label>
                        <select class="form-control" name="setRombelDosenPA">
                            <option value="">Pilih Dosen PA</option>
                            <?php foreach ($dosenProdi as $option) : ?>
                                <option value="<?= $option->dosenId ?>"><?= ($option->dosenGelarDepan == null) ? "" : $option->dosenGelarDepan; ?> <?= $option->dosenNama; ?> <?= $option->dosenGelarBelakang; ?></option>
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
<!-- end modal tambah -->

<!-- start modal edit -->
<?php foreach ($setRombel as $edit) : ?>
    <div class="modal fade" id="editDosen<?= $edit->setRombelId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $title ?> Kelas <?= $edit->kelasKode; ?> - <?= $edit->waktuNama; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/setRombel/ubah/<?= $edit->setRombelId ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <input type="hidden" name="setRombelProdiProgramKuliahId" value="<?= $edit->setRombelProdiProgramKuliahId ?>">
                        <input type="hidden" name="setRombelTahunAjaranId" value="<?= $edit->setRombelTahunAjaranId ?>">
                        <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control" name="setRombelKelasId">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $option) : ?>
                                    <option value="<?= $option->kelasId ?>" <?= ($option->kelasId == $edit->setRombelKelasId) ? "selected" : ""; ?>><?= $option->kelasKode; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Angkatan</label>
                            <input type="text" class="form-control" name="setRombelAngkatan" value="<?= $edit->setRombelAngkatan ?>">
                        </div>
                        <div class="form-group">
                            <label>Dosen PA</label>
                            <select class="form-control" name="setRombelDosenPA">
                                <option value="">Pilih Dosen PA</option>
                                <?php foreach ($dosenProdi as $option) : ?>
                                    <option value="<?= $option->dosenId ?>" <?= ($option->dosenId == $edit->setRombelDosenPA) ? "selected" : ""; ?>><?= ($option->dosenGelarDepan == null) ? "" : $option->dosenGelarDepan; ?> <?= $option->dosenNama; ?> <?= $option->dosenGelarBelakang; ?></option>
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
<?php endforeach ?>
<!-- end modal edit -->

<!-- start modal hapus -->
<?php foreach ($setRombel as $hapus) : ?>
    <div class="modal fade" id="hapusDosen<?= $hapus->setRombelId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data rombel dosen PA kelas <strong> <?= $hapus->kelasKode; ?> <?= $hapus->waktuNama; ?></strong>, prodi <strong><?= $hapus->prodiNama; ?></strong>, program kuliah <strong><?= $hapus->programKuliahNama; ?></strong> ?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/setRombel/hapus/<?= $hapus->setRombelId; ?>" method="post">
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