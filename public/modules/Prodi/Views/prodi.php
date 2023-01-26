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
        <?php if ($validation->hasError('prodiKode')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodiKode')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('prodiNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodiNama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('prodiAcronym')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodiAcronym')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('prodiFakultasId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodiFakultasId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('prodiGedungId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodiGedungId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('prodiGelarLulus')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodiGelarLulus')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('prodiKaprodi')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodiKaprodi')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('prodiJenjangId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodiJenjangId')]]); ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
        <?php endif; ?>
        <div id="alert">
        </div>
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
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahProdi"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                            </button>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Akronim</th>
                                    <th>Jenjang</th>
                                    <th width="10%">Fakultas</th>
                                    <th width="10%">Gedung</th>
                                    <th>Gelar lulusan</th>
                                    <th>Data SK Dikti</th>
                                    <th>Data Kontak</th>
                                    <th style="text-align:center">Status</th>
                                    <th width="10%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($prodi)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($prodi as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->prodiKode; ?></td>
                                            <td><?= $row->prodiNama; ?></td>
                                            <td><?= $row->prodiAcronym; ?></td>
                                            <td><?= $row->refJenjangNama; ?></td>
                                            <td><?= $row->fakultasNama; ?></td>
                                            <td><?= $row->refGedungNama; ?></td>
                                            <td><?= $row->prodiGelarLulus; ?></td>
                                            <td><span style="cursor: pointer;" data-toggle="modal" data-target="#detailDiktiProdi<?= $row->prodiId ?>" class=" text-primary">Klik untuk lihat</span></td>
                                            <td><span style="cursor: pointer;" data-toggle="modal" data-target="#detailKontakProdi<?= $row->prodiId ?>" class=" text-primary">Klik untuk lihat</span></td>
                                            <td style="text-align:center"><span class="mt-2 badge border <?= ($row->prodiIsAktif == 1) ? "border-success text-success" : "border-danger text-danger" ?> mt-2"><?= ($row->prodiIsAktif == 1) ? "Aktif" : "Tidak aktif" ?></span></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dosen<?= $row->prodiId ?>"><i class="las la-user"></i></button>
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editProdi<?= $row->prodiId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusProdi<?= $row->prodiId ?>"><i class="las la-trash"></i></button>
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
                        <?= $pager->links('prodi', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start tambah dosen pimpinan -->
<?php foreach ($prodi as $dsn) : ?>
    <div class="modal fade" id="dosen<?= $dsn->prodiId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Pimpinan Prodi <?= $dsn->prodiNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Type here to search..." aria-describedby="basic-addon2" name="cariDsnProdi<?= $dsn->prodiId ?>" onkeyup="cariDsnProdi(<?= $dsn->prodiId ?>)">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="cariDsnProdi(<?= $dsn->prodiId ?>)"><span class="las la-search"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="alertDsnProdi<?= $dsn->prodiId ?>" class="mb-3 mt-3"></div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Cari Dosen</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th width="10%"></th>
                                                <th>Nama Dosen</th>
                                                <th>Jabatan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pilihDsnProdi<?= $dsn->prodiId ?>">
                                            <tr>
                                                <td colspan="3" style="text-align: center;">Data dosen belum dicari</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="float-right" id="updateDsnProdi<?= $dsn->prodiId ?>"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Pimpinan Prodi</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-responsive-md  ">
                                        <tbody>
                                            <?= reformatDosenPimpinan(['prodi', $dsn->prodiKaprodi, $dsn->prodiSekretaris]); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end tambah dosen pimpinan -->

<!-- start modal detail dikti -->
<?php foreach ($prodi as $detail) : ?>
    <div class="modal fade" id="detailDiktiProdi<?= $detail->prodiId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data Dikti <?= $detail->prodiNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-responsive-md table-striped ">
                        <thead>
                            <tr>
                                <th rowspan="2">Nomor SK Dikti</th>
                                <th style="text-align:center" colspan="2">Masa berlaku</th>
                            </tr>
                            <tr>
                                <th style="text-align:center">Tanggal Awal</th>
                                <th style="text-align:center">Tanggal Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $detail->prodiNomorSKDikti; ?></td>
                                <td><?= ($detail->prodiStartDateSKDikti == null) ? '-' : $detail->prodiStartDateSKDikti; ?></td>
                                <td><?= ($detail->prodiEndDateSKDikti == null) ? '-' : $detail->prodiEndDateSKDikti; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal detail dikti -->

<!-- start modal detail kontak -->
<?php foreach ($prodi as $detail) : ?>
    <div class="modal fade" id="detailKontakProdi<?= $detail->prodiId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data Kontak <?= $detail->prodiNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-responsive-md table-striped ">
                        <thead>
                            <tr>
                                <th>Alamat website</th>
                                <th>Alamat email</th>
                                <th>No Telp.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $detail->prodiWebsite; ?></td>
                                <td><?= $detail->prodiEmail; ?></td>
                                <td><?= $detail->prodiNoTelp; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal detail kontak -->

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
            <form action="/prodi/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="prodiKode">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="prodiNama">
                    </div>
                    <div class="form-group">
                        <label>Akronim</label>
                        <input type="text" class="form-control" name="prodiAcronym">
                    </div>
                    <div class="form-group">
                        <label>Jenjang</label>
                        <select class="form-control" name="prodiJenjangId">
                            <option value="">Pilih Jenjang</option>
                            <?php foreach ($jenjang as $option) : ?>
                                <option value="<?= $option->refJenjangId ?>"><?= $option->refJenjangNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <?php if (in_groups('Fakultas')) : ?>
                            <label>Fakultas</label>
                            <input type="text" class="form-control" value="<?= getUserDetail()[0]->fakultasNama ?>" name="prodiFakultasId" disabled>
                        <?php else : ?>
                            <label>Fakultas</label>
                            <select class="form-control" name="prodiFakultasId">
                                <option value="">Pilih Fakultas</option>
                                <?php foreach ($fakultas as $option) : ?>
                                    <option value="<?= $option->fakultasId ?>"><?= $option->fakultasNama ?></option>
                                <?php endforeach ?>
                            </select>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label>Gedung</label>
                        <select class="form-control" name="prodiGedungId">
                            <option value="">Pilih Gedung</option>
                            <?php foreach ($gedung as $option) : ?>
                                <option value="<?= $option->refGedungId ?>"><?= $option->refGedungNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Gelar lulusan</label>
                        <input type="text" class="form-control" name="prodiGelarLulus">
                    </div>
                    <div class="form-group">
                        <label>Nama Kaprodi</label>
                        <input type="text" class="form-control" name="prodiKaprodi">
                    </div>
                    <div class="form-group">
                        <label>Nama Wakaprodi</label>
                        <input type="text" class="form-control" name="prodiWaKaprodi">
                    </div>
                    <div class="form-group">
                        <label>Nama Sekeretaris Prodi</label>
                        <input type="text" class="form-control" name="prodiSekretaris">
                    </div>
                    <div class="form-group">
                        <label>Nama Bendahara Prodi</label>
                        <input type="text" class="form-control" name="prodiBendahara">
                    </div>
                    <div class="form-group">
                        <label>Nomor SK Dikti</label>
                        <input type="text" class="form-control" name="prodiNomorSKDikti">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputdate">Tanggal Awal SK</label>
                        <input type="date" class="form-control" name="prodiStartDateSKDikti" id="exampleInputdate" value="<?= date("Y-m-d") ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputdate">Tanggal Akhir SK</label>
                        <input type="date" class="form-control" name="prodiEndDateSKDikti" id="exampleInputdate" value="<?= date("Y-m-d", strtotime("+1 week")) ?>">
                    </div>
                    <div class="form-group">
                        <label>Alamat website </label>
                        <input type="text" class="form-control" name="prodiWebsite">
                    </div>
                    <div class="form-group">
                        <label>Alamat email </label>
                        <input type="text" class="form-control" name="prodiEmail">
                    </div>
                    <div class="form-group">
                        <label>No Telp.</label>
                        <input type="text" class="form-control" name="prodiNoTelp">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                            <div class="custom-switch-inner">
                                <input type="checkbox" class="custom-control-input" id="customSwitchAdd" checked="" name="prodiIsAktif">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal edit -->
<?php foreach ($prodi as $edit) : ?>
    <div class="modal fade" id="editProdi<?= $edit->prodiId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="prodi/ubah/<?= $edit->prodiId ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name="prodiKode" value="<?= $edit->prodiKode; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="prodiNama" value="<?= $edit->prodiNama; ?>">
                        </div>
                        <div class="form-group">
                            <label>Akronim</label>
                            <input type="text" class="form-control" name="prodiAcronym" value="<?= $edit->prodiAcronym; ?>">
                        </div>
                        <div class="form-group">
                            <label>Jenjang</label>
                            <select class="form-control" name="prodiJenjangId">
                                <option value="">Pilih Jenjang</option>
                                <?php foreach ($jenjang as $option) : ?>
                                    <option value="<?= $option->refJenjangId ?>" <?= ($option->refJenjangId == $edit->prodiJenjangId) ? "selected" : "" ?>><?= $option->refJenjangNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php if (in_groups('Fakultas')) : ?>
                                <label>Fakultas</label>
                                <input type="text" class="form-control" name="prodiFakultasId" value="<?= getUserDetail()[0]->fakultasNama ?>" disabled>
                            <?php else : ?>
                                <label>Fakultas</label>
                                <select class="form-control" name="prodiFakultasId">
                                    <option value="">Pilih Fakultas</option>
                                    <?php foreach ($fakultas as $option) : ?>
                                        <option value="<?= $option->fakultasId ?>" <?= ($option->fakultasId == $edit->prodiFakultasId) ? "selected" : "" ?>><?= $option->fakultasNama ?></option>
                                    <?php endforeach ?>
                                </select>
                            <?php endif ?>
                        </div>
                        <div class="form-group">
                            <label>Gedung</label>
                            <select class="form-control" name="prodiGedungId">
                                <option value="">Pilih Gedung</option>
                                <?php foreach ($gedung as $option) : ?>
                                    <option value="<?= $option->refGedungId ?>" <?= ($option->refGedungId == $edit->prodiGedungId) ? "selected" : "" ?>><?= $option->refGedungNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gelar lulusan</label>
                            <input type="text" class="form-control" name="prodiGelarLulus" value="<?= $edit->prodiGelarLulus; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama Kaprodi</label>
                            <input type="text" class="form-control" name="prodiKaprodi" value="<?= $edit->prodiKaprodi; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama Wakaprodi</label>
                            <input type="text" class="form-control" name="prodiWaKaprodi" value="<?= $edit->prodiWaKaprodi; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama Sekeretaris Prodi</label>
                            <input type="text" class="form-control" name="prodiSekretaris" value="<?= $edit->prodiSekretaris; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama Bendahara Prodi</label>
                            <input type="text" class="form-control" name="prodiBendahara" value="<?= $edit->prodiBendahara; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nomor SK Dikti</label>
                            <input type="text" class="form-control" name="prodiNomorSKDikti" value="<?= $edit->prodiNomorSKDikti; ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputdate">Tanggal Awal SK</label>
                            <input type="date" class="form-control" name="prodiStartDateSKDikti" id="exampleInputdate" value="<?= ($edit->prodiStartDateSKDikti == null) ? $edit->prodiStartDateSKDikti : reformat($edit->prodiStartDateSKDikti); ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputdate">Tanggal Akhir SK</label>
                            <input type="date" class="form-control" name="prodiEndDateSKDikti" id="exampleInputdate" value="<?= ($edit->prodiEndDateSKDikti == null) ? $edit->prodiEndDateSKDikti : reformat($edit->prodiEndDateSKDikti); ?>">
                        </div>
                        <div class="form-group">
                            <label>Alamat website </label>
                            <input type="text" class="form-control" name="prodiWebsite" value="<?= $edit->prodiWebsite; ?>">
                        </div>
                        <div class="form-group">
                            <label>Alamat email </label>
                            <input type="text" class="form-control" name="prodiEmail" value="<?= $edit->prodiEmail; ?>">
                        </div>
                        <div class="form-group">
                            <label>No Telp.</label>
                            <input type="text" class="form-control" name="prodiNoTelp" value="<?= $edit->prodiNoTelp; ?>">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                <div class="custom-switch-inner">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch<?= $edit->prodiId ?>" <?= ($edit->prodiIsAktif == '1') ? 'checked' : ''; ?> value="<?= ($edit->prodiIsAktif == null) ? 0 : 1; ?>" name="prodiIsAktif">
                                    <label class="custom-control-label" for="customSwitch<?= $edit->prodiId ?>">
                                        <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                        <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                    </label>
                                </div>
                            </div>
                            <label>Status (Aktif/Tidak Aktif)</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal edit -->

<!-- start modal hapus -->
<?php foreach ($prodi as $hapus) : ?>
    <div class="modal fade" id="hapusProdi<?= $hapus->prodiId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $hapus->prodiNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data <strong><?= $hapus->prodiNama ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/prodi/hapus/<?= $hapus->prodiId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
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