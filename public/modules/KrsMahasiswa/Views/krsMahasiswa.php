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
        <?= view('layout/templateAlert', ['msg' => ['primary', 'ri-information-line', '<strong>Informasi !!!</strong> Aplikasi membaca tahun ajaran berjalan adalah : ' . '<strong>' . getTahunAjaranBerjalan()[0]->tahunAjaranNama . '</strong>']]); ?>
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('danger'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-check-line', session()->getFlashdata('danger')]]); ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('mktersedia'))) : ?>
            <?php foreach (session()->getFlashdata('mktersedia') as $value) : ?>
                <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-information-line', $value]]); ?>
            <?php endforeach; ?>
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
                                        <hr>
                                        <h4 class="card-title">Angkatan</h4>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-primary  dropone dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="las la-angle-right font-size-20"></i></button>
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
                                        <button type="button" class="btn btn-sm btn-primary float-right mb-3" data-toggle="modal" data-target="#tambah"><i class="las la-plus"></i> Tambah</button>
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
                                                <?php elseif ($fil['type'] == "pgKuliah") : ?>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-responsive-md table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center">No.</th>
                                                        <th style="text-align:center">Action</th>
                                                        <th>Tahun Ajaran</th>
                                                        <th width="65%">Nama/NPM</th>
                                                        <th style="text-align:center">KRS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($krs)) : ?>
                                                        <?php $no = 1  + ($numberPage * ($currentPage - 1));
                                                        foreach ($krs as $row) : ?>
                                                            <tr>
                                                                <td style="text-align:center"><?= $no++; ?></td>
                                                                <td style="text-align:center">
                                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cetak<?= $row->krsId ?>"><i class="las la-print"></i></button>
                                                                </td>
                                                                <td><?= $row->tahunAjaranNama; ?></td>
                                                                <td><?= $row->mahasiswaNamaLengkap; ?> (<?= $row->krsMahasiswaNpm; ?>)</td>
                                                                <td style="text-align:center"><span style="cursor:pointer" data-toggle="modal" data-target="#lihat<?= $row->krsId ?>" class="text-primary"> Lihat Krs <span class="las la-search"></span></span></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <?= view('layout/templateEmpty', ['jumlahSpan' => 5]); ?>
                                                        </tr>
                                                    <?php endif ?>
                                                </tbody>
                                            </table>
                                            <?= $pager->links('krs', 'pager') ?>
                                        </div>
                                    </div>
                                </div>
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
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah <?= $title; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-left">NPM</p>
                <div class="input-group mb-4">
                    <input type="text" class="form-control" placeholder="Cari menggunakan NPM..." aria-describedby="basic-addon2" name="npm">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"><span class="las la-search" name="btnCari"></span></button>
                    </div>
                </div>
                <p class="text-left">Nama Mahasiswa</p>
                <div class="input-group mb-4">
                    <input type="text" class="form-control" aria-describedby="basic-addon2" name="namaLengkap">
                </div>
                <div class="alert alert-warning" role="alert">
                    <div class="iq-alert-icon">
                        <i class="ri-check-line"></i>
                    </div>
                    <div class="iq-alert-text sksMax">Mahasiswa Belum Dipilih</div>
                </div>
                <form action="krsMahasiswa/tambah" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="npmKrs">
                    <p class="text-left">Mata Kuliah Ditawarkan</p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Pilih</th>
                                    <th>Mata Kuliah</th>
                                    <th>Kelas</th>
                                    <th>Kuota Kelas</th>
                                    <th>Kuota Tersedia</th>
                                    <th>SKS</th>
                                </tr>
                            </thead>
                            <tbody id="dataMK">
                                <tr>
                                    <td colspan="6" style="text-align:center">Mahasiswa Belum Dicari</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-sm btn-primary" value="simpan">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal cetak -->
<?php foreach ($krs as $cetak) : ?>
    <div class="modal fade" id="cetak<?= $cetak->krsId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cetak <?= $title; ?> <?= $cetak->mahasiswaNamaLengkap; ?> (<?= $cetak->krsMahasiswaNpm; ?>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    apakah kamu yakin akan mencetak krs ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="cetakKrs(<?= $cetak->krsMahasiswaNpm ?>,<?= $cetak->krsTahunAjaranId ?>)">Cetak</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal cetak -->

<!-- start modal lihat -->
<?php foreach ($krs as $lihat) : ?>
    <div class="modal fade" id="lihat<?= $lihat->krsId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $title; ?> <?= $lihat->mahasiswaNamaLengkap; ?> (<?= $lihat->krsMahasiswaNpm; ?>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Action</th>
                                    <th>Kode</th>
                                    <th>Mata Kuliah</th>
                                    <th>SKS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (json_decode($lihat->krsMatkulTawarkan)->data as $data) :
                                ?>
                                    <tr class="baris<?= $lihat->krsMahasiswaNpm . $data->matkulId; ?>">
                                        <?php $mk = getMatkul($data->matkulId)[0]; ?>
                                        <td style="text-align:center">
                                            <button type="button" class="btn btn-danger hapusMK" data-id="<?= $data->matkulId; ?>" data-npm="<?= $lihat->krsMahasiswaNpm; ?>"><i class="las la-trash"></i></button>
                                        </td>
                                        <td><?= $mk->matkulKode ?></td>
                                        <td><?= $mk->matkulNama ?></td>
                                        <td><?= $mk->setMatkulKurikulumSks ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal lihat -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>