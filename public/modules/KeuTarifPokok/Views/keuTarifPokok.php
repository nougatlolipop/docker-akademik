<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/keuTarifPokok" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('gagalSave'))) : ?>
            <?php if (count(session()->getFlashdata('gagalSave')) > 0) : ?>
                <?php foreach (session()->getFlashdata('gagalSave') as $msg) : ?>
                    <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Kegagalan proses penyimpanan data <strong>' . $msg . '</strong>!']]); ?>
                <?php endforeach ?>
            <?php else : ?>
                <?= view('layout/templateAlert', ['msg' => ['succes', 'ri-check-line', 'Tarif Pokok Berhasil Disimpan!']]); ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('denyInsert'))) : ?>
            <?php foreach (session()->getFlashdata('denyInsert') as $msg) : ?>
                <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line',  $msg]]); ?>
            <?php endforeach ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <?= view('layout/templateAlert', ['msg' => ['warning', 'ri-alert-line', 'Ceklis semua prodi program kuliah hanya berlaku di halaman yang di buka, untuk memastikan hanya ada 1 halaman silahkan scroll sampai bawah untuk melihat jumlah halaman !!']]); ?>
                <?php if (!empty(session()->getFlashdata('errorSave'))) : ?>
                    <?php if (session()->getFlashdata('errorSave')[0] > 0) : ?>
                        <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Proses penyimpanan jadwal gagal!']]); ?>
                    <?php else : ?>
                        <?= view('layout/templateAlert', ['msg' => ['success', 'ri-alert-line', 'Proses penyimpanan jadwal berhasil!']]); ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!empty(session()->getFlashdata('errorSave'))) : ?>
                    <?php if (session()->getFlashdata('errorSave')[1] > 0) : ?>
                        <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Proses penyimpanan tagihan gagal!']]); ?>
                    <?php else : ?>
                        <?= view('layout/templateAlert', ['msg' => ['success', 'ri-alert-line', 'Proses penyimpanan tagihan berhasil!']]); ?>
                    <?php endif; ?>
                <?php endif; ?>
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
                                        <h4 class="card-title">Angkatan</h4>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-primary dropone dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="las la-angle-right font-size-20"></i></button>
                                                <input type="text" class="form-control" name="angkatanMin" maxlength="4" aria-label=" Default" aria-describedby="inputGroup-sizing-default" value="<?= isset($_GET['angMin']) ? $_GET['angMin'] : "" ?>">
                                            </div>
                                        </div>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-primary  dropone dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="las la-angle-left font-size-20"></i></button>
                                                <input type="text" class="form-control" name="angkatanMax" maxlength="4" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?= isset($_GET['angMax']) ? $_GET['angMax'] : "" ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-sm bg-primary float-right mb-2" id="btnMdlHitung"><i class="las la-plus"><span class="pl-1"></span></i>Hitung Tagihan
                                        </button>
                                    </div>
                                </div>
                                <?php if (count($filter) > 0) : ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php foreach ($filter as $fil) : ?>
                                                <?php if ($fil['type'] == "angMin") : ?>
                                                    <span class="mt-2 badge border border-primary text-primary mt-2 mb-3"><?= $fil['value'] ?> <span class="badge badge-primary ml-2" name="filter" data-name="<?= $fil['type'] ?>" data-val="<?= $fil['id'] ?>" style="cursor: pointer;">x</span></span>
                                                <?php elseif ($fil['type'] == "angMax") : ?>
                                                    <span class="mt-2 badge border border-primary text-primary mt-2 mb-3"><?= $fil['value'] ?> <span class="badge badge-primary ml-2" name="filter" data-name="<?= $fil['type'] ?>" data-val="<?= $fil['id'] ?>" style="cursor: pointer;">x</span></span>
                                                <?php elseif ($fil['type'] == "prodi") : ?>
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
                                            <th style="text-align:center"><input type="checkbox" name="selectAll" id="selectAll"></th>
                                            <th width=" 5%" style="text-align:center">No</th>
                                            <th>Prodi</th>
                                            <th>Program Kuliah</th>
                                            <th>Angkatan</th>
                                            <th>Kurikulum</th>
                                            <th style="text-align:center">Jumlah Tahap</th>
                                            <th style="text-align:center">Tahun Hitung</th>
                                            <th style="text-align:center">Status Tarif</th>
                                            <th width="15%" style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($setKurikulumDitawarkan)) : ?>
                                            <?php
                                            $no = 1  + ($numberPage * ($currentPage - 1));
                                            foreach ($setKurikulumDitawarkan as $row) :
                                                $datas = getTarifDetail([$row->setKurikulumTawarProdiId, $row->setKurikulumTawarProgramKuliahId, $row->setKurikulumTawarAngkatan]);
                                                $tahunMax = getTahunHitungMax([$row->setKurikulumTawarProdiId, $row->setKurikulumTawarProgramKuliahId, $row->setKurikulumTawarAngkatan])[0];
                                                $val = (count($datas) > 0) ? [$datas[0]->tarifProdiId, $datas[0]->tarifProgramKuliahId, $datas[0]->tarifAngkatan] : 0; ?>
                                                <tr>
                                                    <td style="text-align:center"><input type="checkbox" class='<?= (count($datas) > 0) ? "checkitem" : "" ?>' name="record" <?= (count($datas) > 0) ? "" : "disabled" ?> value='<?= (count($datas) > 0) ? json_encode($val) : "" ?>' data-jlhtahap='<?= $row->refKeuTahapJumlah ?>' data-isher="<?= $row->refKeuTahapIsHer ?>" data-her="<?= $row->refKeuTahapHer ?>" data-prodi='<?= $row->prodiId; ?>'></td>
                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                    <td><?= $row->prodiNama; ?></td>
                                                    <td><?= $row->programKuliahNama; ?></td>
                                                    <td><?= $row->setKurikulumTawarAngkatan  ?></td>
                                                    <td><?= $row->kurikulumNama; ?></td>
                                                    <td style="text-align:center" class="<?= ($row->refKeuTahapJumlah == null) ? 'text-danger' : '' ?>"><?= ($row->refKeuTahapJumlah == null) ? 'Belum disetting' : $row->refKeuTahapJumlah ?></td>
                                                    <td style="text-align:center"><span class="badge border <?= ($tahunMax->jadwalTagihanTahun != null) ? "border-success text-success" : "border-danger text-danger" ?> "><?= ($tahunMax->jadwalTagihanTahun == null) ? "UnCount" : $tahunMax->jadwalTagihanTahun ?></span></td>
                                                    <td style="text-align:center">
                                                        <span class="badge border <?= (count($datas) > 0) ? "border-success text-success" : "border-danger text-danger" ?> "><?= (count($datas) > 0) ? "IsSet" : "UnSet" ?></span>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <?php if (count($datas) > 0) : ?>
                                                            <button type="button" data-toggle="modal" data-target="#edit<?= $row->setKurikulumTawarProdiId . $row->setKurikulumTawarProgramKuliahId . $row->setKurikulumTawarId ?>" class="btn btn-secondary"><span class="las la-pen"></span></button>
                                                            <button type="button" data-toggle="modal" data-target="#hapus<?= $row->setKurikulumTawarProdiId . $row->setKurikulumTawarProgramKuliahId . $row->setKurikulumTawarId ?>" class="btn btn-danger"><span class="las la-trash"></span></button>
                                                        <?php else : ?>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#setting<?= $row->setKurikulumTawarProdiId . $row->setKurikulumTawarProgramKuliahId . $row->setKurikulumTawarId ?>"><span class="las la-cog"></span></button>
                                                        <?php endif ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <tr>
                                                <?= view('layout/templateEmpty', ['jumlahSpan' => 10]); ?>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                                <?= $pager->links('keuTarifPokok', 'pager') ?>
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


<?php foreach ($setKurikulumDitawarkan as $add) : ?>
    <div class="modal fade" id="setting<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form action="/keuTarifPokok/tambah" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="prodiId" value="<?= $add->setKurikulumTawarProdiId ?>">
                    <input type="hidden" name="programKuliahId" value="<?= $add->setKurikulumTawarProgramKuliahId ?>">
                    <input type="hidden" name="angkatan" value="<?= $add->setKurikulumTawarAngkatan ?>">
                    <input type="hidden" name="url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <div class=" modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Setting <?= $title ?> <?= $add->prodiNama ?> - <?= $add->programKuliahNama ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-responsive-md table-striped">
                            <thead>
                                <tr>
                                    <th>Tahap</th>
                                    <th>Alokasi</th>
                                    <th style="width:40%">Jenis Biaya</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($add->refKeuTahapId == null) : ?>
                                    <tr>
                                        <td colspan="4" style="text-align:center">Data tidak ditemukan</td>
                                    </tr>
                                <?php else : ?>
                                    <?php if ($add->refKeuTahapIsHer) : ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" class="form-control" id="tahap<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . '0' ?>" aria-describedby=" basic-addon2" name="tahap[]" value="0" readonly>
                                                <?= 'Her Reg' ?>
                                            </td>
                                            <td>
                                                <input type="hidden" name="tahapher" value="<?= $add->refKeuTahapHer ?>">
                                                <?php foreach (json_decode($add->refKeuTahapHer) as $idx => $t) : ?>
                                                    <?= 'Tahap ' . $t ?>
                                                    <?= ($idx < count(json_decode($add->refKeuTahapHer)) - 1) ? ',' : ''  ?>
                                                <?php endforeach ?>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="hidden" class="form-control" id="itemSave<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . '0' ?>" aria-describedby=" basic-addon2" name="itemSave[]" readonly>
                                                    <input type="text" class="form-control" id="item<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . '0' ?>" aria-describedby=" basic-addon2" name="item[]" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="openmodal(<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . ',', '0' ?>)"><span class="las la-search"></span></button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="hidden" class="form-control" id="nominalTahapSave<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . '0' ?>" name="nominalTahapSave[]"><input type="text" class="form-control" id="nominalTahap<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . '0' ?>" name="nominalTahap[]"></td>
                                        </tr>
                                    <?php endif ?>
                                    <?php for ($i = 1; $i <= $add->refKeuTahapJumlah; $i++) : ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" class="form-control" id="tahap<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . $i ?>" aria-describedby=" basic-addon2" name="tahap[]" value="<?= $i ?>" readonly>
                                                <?= 'Tahap ' . $i ?>
                                            </td>
                                            <td>
                                                <select name="smtr[]" class="form-control">
                                                    <option value="1">Ganjil</option>
                                                    <option value="2">Genap</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="hidden" class="form-control" id="itemSave<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . $i ?>" aria-describedby=" basic-addon2" name="itemSave[]" readonly>
                                                    <input type="text" class="form-control" id="item<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . $i ?>" aria-describedby=" basic-addon2" name="item[]" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" onclick="openmodal(<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . ',', $i ?>)"><span class="las la-search"></span></button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="hidden" class="form-control" id="nominalTahapSave<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . $i ?>" name="nominalTahapSave[]"><input type="text" class="form-control" id="nominalTahap<?= $add->setKurikulumTawarProdiId . $add->setKurikulumTawarProgramKuliahId .  $add->setKurikulumTawarId . $i ?>" name="nominalTahap[]"></td>
                                        </tr>
                                    <?php endfor ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                        <?php if ($add->refKeuTahapId) : ?>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        <?php endif ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal fakultas -->

<div class="modal fade" id="set2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Setting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-responsive-md table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Jenis Biaya</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody id="namaTarif">
                        <?php $no = 0;
                        foreach ($tagihan as $tagih) : $no++ ?>
                            <tr>
                                <td style="text-align:center"><input type='checkbox' name='record' data-id="<?= $tagih->refJenisBiayaId ?>" data-index="<?= $no ?>" value="<?= $tagih->refJenisBiayaKode  ?>"></td>
                                <td><?= $tagih->refJenisBiayaNama  ?></td>
                                <td><input type="number" class="form-control" name="nominalTagihan<?= $no ?>"></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" onclick="goback()" class="btn btn-sm btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?php foreach ($setKurikulumDitawarkan as $edit) : ?>
    <div class="modal fade" id="edit<?= $edit->setKurikulumTawarProdiId . $edit->setKurikulumTawarProgramKuliahId . $edit->setKurikulumTawarId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit <strong><?= $edit->prodiNama; ?> - <?= $edit->programKuliahNama; ?> (<?= $edit->setKurikulumTawarAngkatan; ?>)</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/keuTarifPokok/ubah" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="prodi" value="<?= $edit->setKurikulumTawarProdiId ?>">
                    <input type="hidden" name="programKuliah" value="<?= $edit->setKurikulumTawarProgramKuliahId ?>">
                    <input type="hidden" name="angkatan" value="<?= $edit->setKurikulumTawarAngkatan ?>">
                    <div class="modal-body">
                        <table class="table table-bordered table-responsive-md table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center ;">No</th>
                                    <th>Jenis Biaya</th>
                                    <th>Semester</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $dtTarif = getTarifDetail(
                                    [$edit->setKurikulumTawarProdiId, $edit->setKurikulumTawarProgramKuliahId, $edit->setKurikulumTawarAngkatan]
                                );
                                $no = 0;
                                foreach ($dtTarif as $tarif) : $no++ ?>
                                    <input type="hidden" name="tahap[]" value="<?= $tarif->tahap ?>">
                                    <input type="hidden" name="semester[]" value="<?= $tarif->semester ?>">
                                    <input type="hidden" name="item[]" value="<?= $tarif->item ?>">
                                    <tr>
                                        <td style="text-align:center ;"><?= $no; ?></td>
                                        <td><?= $tarif->refJenisBiayaKode . (($tarif->refJenisBiayaId != '25') ? ' (Tahap ' . $tarif->tahap . ')' : '') ?></td>
                                        <td><?= ($tarif->semester == 1) ? 'Ganjil' : 'Genap' ?></td>
                                        <td><input class="form-control" type="number" name="nominal[]" value="<?= $tarif->nominal ?>"></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
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

<?php foreach ($setKurikulumDitawarkan as $hapus) : ?>
    <div class="modal fade" id="hapus<?= $hapus->setKurikulumTawarProdiId . $hapus->setKurikulumTawarProgramKuliahId . $hapus->setKurikulumTawarId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus <strong>Tarif Pokok</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data tarif pokok prodi <strong><?= $hapus->prodiNama; ?> - <?= $hapus->programKuliahNama; ?> (<?= $hapus->setKurikulumTawarAngkatan; ?>)</strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/keuTarifPokok/hapus" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="prodi" value="<?= $hapus->setKurikulumTawarProdiId ?>">
                    <input type="hidden" name="programKuliah" value="<?= $hapus->setKurikulumTawarProgramKuliahId ?>">
                    <input type="hidden" name="angkatan" value="<?= $hapus->setKurikulumTawarAngkatan ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>

<div class="modal fade" id="hitungTagihanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="/keuTarifPokok/hitung" id="formulirhitung" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hitung Tagihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="peringatan"></div>
                    <div class="formhitung">
                        <input type="hidden" name="url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                        <div class="form-group">
                            <label>Tahun Tagihan</label>
                            <select name="tahun" class='form-control' required>
                                <option selected disabled value="">Pilih Tahun Tagihan</option>
                                <?php $thn = date("Y") - 1; ?>
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <option value="<?= $thn ?>"><?= $thn ?></option>
                                    <?php $thn++ ?>
                                <?php endfor ?>
                            </select>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center"></th>
                                    <th style="text-align:center">Tanggal Mulai</th>
                                    <th style="text-align:center">Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <tbody id="herRegistrasi">
                            </tbody>
                        </table>
                        <table class="table table-bordered table-responsive-md table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Tahap</th>
                                    <th style="text-align:center">Tanggal Mulai</th>
                                    <th style="text-align:center">Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <tbody id="tglTahap">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary btnSimpanHitung">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>