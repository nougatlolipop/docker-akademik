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
        <?php if ($validation->hasError('setJadwalAkademikTahunAjaranId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setJadwalAkademikTahunAjaranId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('jadwalMulaiPengisianKRS')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jadwalMulaiPengisianKRS')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('jadwalAkhirPengisianKRS')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jadwalAkhirPengisianKRS')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('jadwalMulaiInputNilaiUTS')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jadwalMulaiInputNilaiUTS')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('jadwalAkhirInputNilaiUTS')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jadwalAkhirInputNilaiUTS')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('jadwalMulaiInputNilaiUAS')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jadwalMulaiInputNilaiUAS')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('jadwalAkhirInputNilaiUAS')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('jadwalAkhirInputNilaiUAS')]]); ?>
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
                                        <h4 class="card-title">Tahun Ajaran</h4>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-primary dropone dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="las la-calendar font-size-20"></i></button>
                                                <input type="text" class="form-control" name="thnAjar" maxlength="4" aria-label=" Default" aria-describedby="inputGroup-sizing-default" value="<?= isset($_GET['thnAjar']) ? $_GET['thnAjar'] : "" ?>">
                                            </div>
                                        </div>
                                        <hr>
                                        <h4 class="card-title">Prodi dari Fakultas</h4>
                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="smallPrd" class="custom-control-input" id="customCheck<?= 'prodi' . $i ?>" value="<?= $prodi[$i]->prodiId ?>" <?= in_array($prodi[$i]->prodiId, (isset($_GET['prodi']) ? explode(",", $_GET['prodi']) : [])) ? "checked" : "" ?>>
                                                <label class="custom-control-label" for="customCheck<?= 'prodi' . $i ?>"><?= $prodi[$i]->prodiNama; ?></label>
                                            </div>
                                        <?php endfor ?>
                                        <p></p>
                                        <a href="#!" data-toggle="modal" data-target="#prodi" class=" card-link">lainnya</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if (isset($_GET['prodi']) && !in_groups('Fakultas')) : ?>
                                            <div style="padding-bottom:20px" class="card-header-toolbar d-flex align-items-center float-right">
                                                <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahJadwal"><i class="las la-plus"><span class="pl-1"></span></i>Tambah</button>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <?php if (count($filter) > 0) : ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php foreach ($filter as $fil) : ?>
                                                <?php if ($fil['type'] == "prodi") : ?>
                                                    <span class="mt-2 badge border border-primary text-primary mt-2 mb-3"><?= $fil['value'] ?> <span class="badge badge-primary ml-2" name="filter" data-name="<?= $fil['type'] ?>" data-val="<?= $fil['id'] ?>" style="cursor: pointer;">x</span></span>
                                                <?php elseif ($fil['type'] == "thnAjar") : ?>
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
                                            <th>Tahun Ajaran</th>
                                            <th>Pengisian KRS</th>
                                            <th>Input Nilai UTS</th>
                                            <th>Input Nilai UAS</th>
                                            <?php if (!in_groups('Fakultas')) : ?>
                                                <th width="10%" style="text-align:center">Action</th>
                                            <?php endif ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($jadwal)) : ?>
                                            <?php
                                            $no = 1  + ($numberPage * ($currentPage - 1));
                                            foreach ($jadwal as $row) : ?>
                                                <tr>
                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                    <td><?= $row->prodiNama; ?></td>
                                                    <td><?= $row->tahunAjaranNama; ?></td>
                                                    <td class="<?= ($row->setJadwalAkademikKrsForceAktif == 0) ? 'text-success' : 'text-danger' ?>"><?= reformat($row->setJadwalAkademikKrsStartDate); ?> s/d <?= reformat($row->setJadwalAkademikKrsEndDate); ?></td>
                                                    <td class="<?= ($row->setJadwalAkademikUtsForceAktif == 0) ? 'text-success' : 'text-danger' ?>"><?= reformat($row->setJadwalAkademikUtsStartDate); ?> s/d <?= reformat($row->setJadwalAkademikUtsEndDate); ?></td>
                                                    <td class="<?= ($row->setJadwalAkademikUasForceAktif == 0) ? 'text-success' : 'text-danger' ?>"><?= reformat($row->setJadwalAkademikUasStartDate); ?> s/d <?= reformat($row->setJadwalAkademikUasEndDate); ?></td>
                                                    <?php if (!in_groups('Fakultas')) : ?>
                                                        <td style="text-align:center">
                                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editJadwal<?= $row->setJadwalAkademikId; ?>"><i class="las la-pen"></i></button>
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusJadwal<?= $row->setJadwalAkademikId; ?>"><i class="las la-trash"></i></button>
                                                        </td>
                                                    <?php endif ?>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <tr>
                                                <?= view('layout/templateEmpty', ['jumlahSpan' => (in_groups('Fakultas')) ? 6 : 7]); ?>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                                <?= $pager->links('jadwalAkademik', 'pager') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Wrapper End-->

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

<?php if (!in_groups('Fakultas')) : ?>
    <!-- start modal tambah -->
    <div class="modal fade" id="tambahJadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/setJadwalAkademik/tambah" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="setJadwalAkademikProdiId" value="<?= isset($_GET['prodi']) ? $_GET['prodi'] : "" ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <select class="form-control" name="setJadwalAkademikTahunAjaranId">
                                <option value="">Pilih Tahun Ajaran</option>
                                <?php foreach ($tahunAjaran as $option) : ?>
                                    <option value="<?= $option->tahunAjaranId ?>"><?= $option->tahunAjaranNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Pengisian KRS</th>
                                    <td><input type="date" class="form-control" name="jadwalMulaiPengisianKRS" id="exampleInputdate" value=""></td>
                                    <td><input type="date" class="form-control" name="jadwalAkhirPengisianKRS" id="exampleInputdate" value=""></td>
                                </tr>
                                <tr>
                                    <th>Input Nilai UTS</th>
                                    <td><input type="date" class="form-control" name="jadwalMulaiInputNilaiUTS" id="exampleInputdate" value=""></td>
                                    <td><input type="date" class="form-control" name="jadwalAkhirInputNilaiUTS" id="exampleInputdate" value=""></td>
                                </tr>
                                <tr>
                                    <th>Input Nilai UAS</th>
                                    <td><input type="date" class="form-control" name="jadwalMulaiInputNilaiUAS" id="exampleInputdate" value=""></td>
                                    <td><input type="date" class="form-control" name="jadwalAkhirInputNilaiUAS" id="exampleInputdate" value=""></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal tambah -->

    <!-- start modal edit -->
    <?php foreach ($jadwal as $edit) : ?>
        <div class="modal fade" id="editJadwal<?= $edit->setJadwalAkademikId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Jadwal <?= $edit->prodiNama ?> - <?= $edit->tahunAjaranNama; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/setJadwalAkademik/ubah/<?= $edit->setJadwalAkademikId ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="setJadwalAkademikTahunAjaranId" value=" <?= $edit->setJadwalAkademikTahunAjaranId ?>">
                        <input type="hidden" name="setJadwalAkademikProdiId" value=" <?= $edit->setJadwalAkademikProdiId ?>">
                        <div class="modal-body">
                            <table class="table table-bordered table-responsive-md table-striped">
                                <thead>
                                    <tr>
                                        <th>Kegiatan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <?php if (!in_groups('Fakultas')) : ?>
                                            <th>Status</th>
                                        <?php endif ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Pengisian KRS</th>
                                        <td><input type="date" class="form-control" name="jadwalMulaiPengisianKRS" id="exampleInputdate" value="<?= reformat($edit->setJadwalAkademikKrsStartDate); ?>"></td>
                                        <td><input type="date" class="form-control" name="jadwalAkhirPengisianKRS" id="exampleInputdate" value="<?= reformat($edit->setJadwalAkademikKrsEndDate); ?>"></td>
                                        <?php if (!in_groups('Fakultas')) : ?>
                                            <td style=" text-align:center">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                                        <div class="custom-switch-inner">
                                                            <input type="checkbox" class="custom-control-input" id="customSwitch1<?= $edit->setJadwalAkademikId ?>" <?= ($edit->setJadwalAkademikKrsForceAktif == '1') ? 'checked' : ''; ?> value="<?= ($edit->setJadwalAkademikKrsForceAktif == null) ? 0 : 1; ?>" name="pengisianKRSAktif">
                                                            <label class="custom-control-label" for="customSwitch1<?= $edit->setJadwalAkademikId ?>">
                                                                <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                                                <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        <?php endif ?>
                                    </tr>
                                    <tr>
                                        <th>Input Nilai UTS</th>
                                        <td><input type="date" class="form-control" name="jadwalMulaiInputNilaiUTS" id="exampleInputdate" value="<?= reformat($edit->setJadwalAkademikUtsStartDate); ?>"></td>
                                        <td><input type="date" class="form-control" name="jadwalAkhirInputNilaiUTS" id="exampleInputdate" value="<?= reformat($edit->setJadwalAkademikUtsEndDate); ?>"></td>
                                        <?php if (!in_groups('Fakultas')) : ?>
                                            <td></td>
                                        <?php endif ?>
                                    </tr>
                                    <tr>
                                        <th>Input Nilai UAS</th>
                                        <td><input type="date" class="form-control" name="jadwalMulaiInputNilaiUAS" id="exampleInputdate" value="<?= reformat($edit->setJadwalAkademikUasStartDate); ?>"></td>
                                        <td><input type="date" class="form-control" name="jadwalAkhirInputNilaiUAS" id="exampleInputdate" value="<?= reformat($edit->setJadwalAkademikUasEndDate); ?>"></td>
                                        <?php if (!in_groups('Fakultas')) : ?>
                                            <td style=" text-align:center">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                                        <div class="custom-switch-inner">
                                                            <input type="checkbox" class="custom-control-input" id="customSwitch6<?= $edit->setJadwalAkademikId ?>" <?= ($edit->setJadwalAkademikUasForceAktif >= 1) ? 'checked' : ''; ?> value="<?= ($edit->setJadwalAkademikUasForceAktif == null) ? 0 : 1; ?>" name="penginputanNilaiUASAKtif">
                                                            <label class="custom-control-label" for="customSwitch6<?= $edit->setJadwalAkademikId ?>">
                                                                <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                                                <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        <?php endif ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class=" modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- end modal edit -->

    <!-- start modal delete -->
    <?php foreach ($jadwal as $hapus) : ?>
        <div class="modal fade" id="hapusJadwal<?= $hapus->setJadwalAkademikId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/setJadwalAkademik/hapus/<?= $hapus->setJadwalAkademikId ?>" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <p>Apakah anda yakin ingin menghapus data <strong><?= $hapus->prodiNama ?></strong> Tahun Ajaran <strong><?= $hapus->tahunAjaranNama ?></strong>?</p>
                            <p class="text-warning"><small>This action cannot be undone</small></p>
                        </div>
                        <div class=" modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- end modal delete -->
<?php endif ?>


<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>