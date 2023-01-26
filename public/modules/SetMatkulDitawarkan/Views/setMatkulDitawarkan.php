<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/setMatkulDitawarkan" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if ($validation->hasError('setMatkulTawarTahunAjaranId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulTawarTahunAjaranId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setMatkulTawarKuotaKelas')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulTawarKuotaKelas')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setMatkulTawarDosenId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulTawarDosenId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setMatkulTawarKelasId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulTawarKelasId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setMatkulTawarMatkulKurikulumId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulTawarMatkulKurikulumId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('setMatkulTawarProdiProgramKuliahId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('setMatkulTawarProdiProgramKuliahId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('prodiAkademik')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('prodiAkademik')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('programKuliahAkademik')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('programKuliahAkademik')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tahunAjaran')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tahunAjaran')]]); ?>
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
                                        <h4 class="card-title">Waktu Kuliah</h4>
                                        <?php foreach ($waktuKuliah as $wkt) : ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="wktKuliah" class="custom-control-input" id="waktuKuliah<?= $wkt->waktuId  ?>" value="<?= $wkt->waktuId ?>" <?= in_array($wkt->waktuId, (isset($_GET['wktKuliah']) ? explode(",", $_GET['wktKuliah']) : [])) ? "checked" : "" ?>>
                                                <label class="custom-control-label" for="waktuKuliah<?= $wkt->waktuId ?>"><?= $wkt->waktuNama ?></label>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if (isset($_GET['prodi']) && isset($_GET['pgKuliah'])) : ?>
                                            <button class="btn btn-sm bg-primary float-right mb-2 tambahMatkulTawar" data-toggle="modal" data-target="#tambahMatkul"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
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
                                                <?php elseif ($fil['type'] == "wktKuliah") : ?>
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
                                            <th width="10%">Tahun Ajaran</th>
                                            <th>Mata Kuliah Kurikulum</th>
                                            <th width="6%">Kelas</th>
                                            <th>Kuota</th>
                                            <th width="15%">Roster Kuliah</th>
                                            <th width="15%">Dosen</th>
                                            <th width="13%" style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($setMatkulDitawarkan)) : ?>
                                            <?php
                                            $no = 1  + ($numberPage * ($currentPage - 1));
                                            foreach ($setMatkulDitawarkan as $row) : ?>
                                                <tr>
                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                    <td><?= $row->tahunAjaranNama; ?></td>
                                                    <td><span style="cursor: pointer;" onclick="detailMatkul(<?= $row->setMatkulTawarMatkulKurikulumId ?>)" class=" text-primary"><?= $row->matkulKode; ?> - <?= $row->matkulNama; ?> / <?= $row->kurikulumNama; ?> - <?= $row->studiLevelNama; ?></span></td>
                                                    <td><?= $row->kelasKode; ?> <?= $row->waktuNama ?></td>
                                                    <td><?= $row->setMatkulTawarKuotaKelas; ?></td>
                                                    <?php $dataRoster = (reformatRoster(['list', $row->setMatkulTawarId]) == null) ? 'Belum disetting' : reformatRoster(['list', $row->setMatkulTawarId]); ?>
                                                    <td <?= ($dataRoster == 'Belum disetting') ? 'class="text-danger"' : '' ?>><?= $dataRoster; ?></td>
                                                    <?php $dosen = ($row->setMatkulTawarDosen == null) ? [] : json_decode($row->setMatkulTawarDosen)->data ?>
                                                    <?php $dataDosen = ($row->setMatkulTawarDosen == null) ? 'Belum disetting' : reformatDosenMatkul(['list', $dosen]) ?>
                                                    <td <?= ($dataDosen == 'Belum disetting') ? 'class="text-danger"' : '' ?>><?= $dataDosen; ?></td>
                                                    <td style="text-align:center">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dosen<?= $row->setMatkulTawarId ?>"><i class="las la-user"></i></button>
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editMatkul<?= $row->setMatkulTawarId ?>"><i class="las la-pen"></i></button>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusMatkul<?= $row->setMatkulTawarId ?>"><i class="las la-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <tr>
                                                <?= view('layout/templateEmpty', ['jumlahSpan' => 8]); ?>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                                <?= $pager->links('setMatkulDitawarkan', 'pager') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start detail mata kuliah -->
<div class="modal fade" id="detailMatkul" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Mata Kuliah Kurikulum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="data-matkul">
            </div>
        </div>
    </div>
</div>
<!-- end detail mata kuliah -->

<!-- start tambah dosen -->
<?php foreach ($setMatkulDitawarkan as $lihat) : ?>
    <div class="modal fade" id="dosen<?= $lihat->setMatkulTawarId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Dosen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Type here to search..." aria-describedby="basic-addon2" name="cariDosen<?= $lihat->setMatkulTawarId ?>" onkeyup='cariDosenMatkulTawar(<?= $lihat->setMatkulTawarId ?>,`<?= $lihat->setMatkulTawarDosen ?>`,<?= $lihat->prodiId ?>)'>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"><span class="las la-search" onclick='cariDosenMatkulTawar(<?= $lihat->setMatkulTawarId ?>,`<?= $lihat->setMatkulTawarDosen ?>`,<?= $lihat->prodiId ?>)'></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="alertDosen<?= $lihat->setMatkulTawarId ?>" class="mb-3 mt-3"></div>
                    <div class="row">
                        <div class="col-md-6">
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
                                            </tr>
                                        </thead>
                                        <tbody id="pilihDosen<?= $lihat->setMatkulTawarId ?>">
                                            <tr>
                                                <td colspan="2" style="text-align: center;">Data dosen belum dicari</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="float-right" id="tambahDosen<?= $lihat->setMatkulTawarId ?>"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Daftar Dosen</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-responsive-md  ">
                                        <thead>
                                            <tr>
                                                <th width="10%"></th>
                                                <th>Nama Dosen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $dosen = ($lihat->setMatkulTawarDosen == null) ? [] : json_decode($lihat->setMatkulTawarDosen)->data ?>
                                            <?php if (empty($dosen)) : ?>
                                                <tr>
                                                    <td colspan="2" style="text-align: center;">Data dosen kosong</td>
                                                </tr>
                                            <?php else : ?>
                                                <?= reformatDosenMatkul(['tabel', $dosen, $lihat->setMatkulTawarId]) ?>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                    <?php if (!empty($dosen)) : ?>
                                        <div class="float-right" id="hapusDosen<?= $lihat->setMatkulTawarId ?>" onclick='deleteDosenMatkulTawar(<?= $lihat->setMatkulTawarId ?>,`<?= $lihat->setMatkulTawarDosen ?>`)'><button type="button" class="btn btn-sm btn-danger">Hapus</button></div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end tambah dosen -->

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
<div class="modal fade" id="tambahMatkul" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/setMatkulDitawarkan/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Mata Kuliah Kurikulum</label>
                        <select class="form-control matkulKurikulumAkademik" name="setMatkulTawarMatkulKurikulumId">
                            <option value="">Pilih Mata Kuliah Kurikulum</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Prodi Program Kuliah</label>
                        <select class="form-control prodiProgramKuliahAkademik" name="setMatkulTawarProdiProgramKuliahId">
                            <option value="">Pilih Prodi Program Kuliah</option>
                        </select>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title"><strong>Kelas</strong></p>
                            <div class="form-row">
                                <?php foreach ($kelas as $row) : ?>
                                    <div class="col-md-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="kelas<?= $row->kelasId ?>" name="setMatkulTawarKelasId[]" value="<?= $row->kelasId ?>">
                                            <label class="custom-control-label" for="kelas<?= $row->kelasId ?>"><?= $row->kelasKode ?></label>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <p></p>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="setMatkulTawarSemuaKelas" name="setMatkulTawarSemuaKelas" value="1">
                                <label class="custom-control-label" for="setMatkulTawarSemuaKelas">Tawarkan Silang</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Kuota Kelas</label>
                        <input type="number" class="form-control kuotaKelas" name="setMatkulTawarKuotaKelas">
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
<?php foreach ($setMatkulDitawarkan as $edit) : ?>
    <div class="modal fade" id="editMatkul<?= $edit->setMatkulTawarId ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/setMatkulDitawarkan/ubah/<?= $edit->setMatkulTawarId ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <input type="hidden" name="setMatkulTawarTahunAjaranId" value="<?= $edit->setMatkulTawarTahunAjaranId ?>">
                        <input type="hidden" name="oldSetMatkulTawarMatkulKurikulumId" value="<?= $edit->setMatkulTawarMatkulKurikulumId ?>">
                        <input type="hidden" name="oldSetMatkulTawarProdiProgramKuliahId" value="<?= $edit->setMatkulTawarProdiProgramKuliahId ?>">
                        <input type="hidden" name="oldSetMatkulTawarKelasId" value="<?= $edit->setMatkulTawarKelasId ?>">
                        <div class="form-group">
                            <label>Prodi</label>
                            <select class="form-control prodiAkademik" name="prodi">
                                <option value="">Pilih Prodi</option>
                                <?php if (in_groups('Fakultas')) : ?>
                                    <?php foreach ($prodiBiro as $option) : ?>
                                        <option value="<?= $option->prodiId ?>" <?= ($option->prodiId == $edit->setKurikulumTawarProdiId) ? "selected" : ""; ?>><?= $option->prodiNama ?></option>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?php foreach ($prodi as $option) : ?>
                                        <option value="<?= $option->prodiId ?>" <?= ($option->prodiId == $edit->setKurikulumTawarProdiId) ? "selected" : ""; ?>><?= $option->prodiNama ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Program Kuliah</label>
                            <select class="form-control programKuliahMatkul" name="programKuliah">
                                <option value="<?= $edit->programKuliahId ?>" selected><?= $edit->programKuliahNama ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mata Kuliah Kurikulum</label>
                            <select class="form-control matkulKurikulumEdit" name="setMatkulTawarMatkulKurikulumId">
                                <option value="<?= $edit->setMatkulKurikulumId ?>" selected><?= $edit->matkulKode ?> - <?= $edit->matkulNama; ?> / <?= $edit->kurikulumNama; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Prodi Program Kuliah</label>
                            <select class="form-control prodiProgramKuliahEdit" name="setMatkulTawarProdiProgramKuliahId">
                                <option value="<?= $edit->setMatkulTawarProdiProgramKuliahId ?>" selected><?= $edit->prodiNama ?> / <?= $edit->programKuliahNama; ?> - <?= $edit->waktuNama; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control kelasAkademik" name="setMatkulTawarKelasId">
                                <option value=" ">Pilih Kelas</option>
                                <?php foreach ($kelas as $option) : ?>
                                    <option value="<?= $option->kelasId ?>" <?= ($option->kelasId == $edit->setMatkulTawarKelasId) ? "selected" : ""; ?>><?= $option->kelasKode ?></option>
                                <?php endforeach ?>
                            </select>
                            <p></p>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="setMatkulTawarSemuaKelas<?= $edit->setMatkulTawarId ?>" name="setMatkulTawarSemuaKelas" value="<?= ($edit->setMatkulTawarSemuaKelas == 'null') ? "0" : "1"; ?>" <?= ($edit->setMatkulTawarSemuaKelas == "1") ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="setMatkulTawarSemuaKelas<?= $edit->setMatkulTawarId ?>">Tawarkan Silang</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kuota Kelas</label>
                            <input type="number" class="form-control" value="<?= $edit->setMatkulTawarKuotaKelas ?>" name="setMatkulTawarKuotaKelas">
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
<?php foreach ($setMatkulDitawarkan as $hapus) : ?>
    <div class="modal fade" id="hapusMatkul<?= $hapus->setMatkulTawarId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data <?= $title; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data mata kuliah <strong><?= $hapus->matkulKode; ?> - <?= $hapus->matkulNama; ?></strong> kelas <strong><?= $hapus->kelasKode; ?> - <?= $hapus->waktuNama; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/setMatkulDitawarkan/hapus/<?= $hapus->setMatkulTawarId; ?>" method="post">
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