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
        <?php if ($validation->hasError('dosenNama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenNama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenUsername')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenUsername')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenPassword')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenPassword')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenNip')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenNip')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenNIDN')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenNIDN')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenNUPTK')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenNUPTK')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenNoSerdos')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenNoSerdos')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenStatusDosen')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenStatusDosen')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenStatusAktif')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenStatusAktif')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenGelarDepan')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenGelarDepan')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenGelarBelakang')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenGelarBelakang')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenJenjangPendidikan')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenJenjangPendidikan')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenTempatLahir')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenTempatLahir')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenTanggalLahir')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenTanggalLahir')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenJenisKelamin')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenJenisKelamin')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenAgama')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenAgama')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenGolDarah')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenGolDarah')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenKecamatan')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenKecamatan')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenAlamat')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenAlamat')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenStatusNikah')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenStatusNikah')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenNIK')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenNIK')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenNoNBM')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenNoNBM')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenNoNPWP')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenNoNPWP')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenEmailCorporate')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenEmailCorporate')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenEmailGeneral')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenEmailGeneral')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenNoHandphone')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenNoHandphone')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenFoto')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenFoto')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenDokumenKTP')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenDokumenKTP')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenDokumenNBM')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenDokumenNBM')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenDokumenNPWP')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenDokumenNPWP')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenDokumenSerdos')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenDokumenSerdos')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenSertifikatKeahlian')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenSertifikatKeahlian')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('dosenDokumenIjazah')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('dosenDokumenIjazah')]]); ?>
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
                        <!-- <div style="padding-bottom:20px" class="card-header-toolbar d-flex align-items-center float-right">
                            <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#tambahDosen"><i class="las la-plus"><span class="pl-1"></span></i>Tambah
                            </button>
                        </div> -->
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Foto</th>
                                    <th>NIP</th>
                                    <th>NIDN</th>
                                    <th>Nama</th>
                                    <th>Gelar Depan</th>
                                    <th>Gelar Belakang</th>
                                    <th>Email</th>
                                    <th>No. Handphone</th>
                                    <th width="15%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dosen)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($dosen as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><span style="cursor:pointer" data-toggle="modal" data-target="#fotoDosen<?= $row->dosenId ?>" class=" text-primary">Klik untuk lihat</span></td>
                                            <td><?= $row->dosenNip; ?></td>
                                            <td><?= $row->dosenNIDN; ?></td>
                                            <td><?= $row->dosenNama; ?></td>
                                            <td><?= $row->dosenGelarDepan; ?></td>
                                            <td><?= $row->dosenGelarBelakang; ?></td>
                                            <td><?= $row->dosenEmailCorporate; ?></td>
                                            <td><?= $row->dosenNoHandphone; ?></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editDosen<?= $row->dosenId ?>"><i class="las la-pen"></i></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusDosen<?= $row->dosenId ?>"><i class="las la-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('dosen', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start modal tambah -->
<div class="modal fade" id="tambahDosen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/dosen/tambah" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label><strong>Identitas Pribadi</strong></label>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Foto Dosen</label>
                                    <div class="custom-file">
                                        <input name="dosenFoto" type="file" accept="image/png, image/gif, image/jpeg" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>NIK</label>
                                    <input type="number" class="form-control" name="dosenNIK">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>KTP</label>
                                    <div class="custom-file">
                                        <input name="dosenDokumenKTP" type="file" accept="image/png, image/gif, image/jpeg" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="dosenNama">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Gelar Depan</label>
                                    <input type="text" class="form-control" name="dosenGelarDepan">
                                </div>
                                <div class="col">
                                    <label>Gelar Belakang</label>
                                    <input type="text" class="form-control" name="dosenGelarBelakang">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" name="dosenTempatLahir">
                                </div>
                                <div class="col">
                                    <label for="exampleInputdate">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="dosenTanggalLahir" id="exampleInputdate" value="">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Agama</label>
                                    <select class="form-control" name="dosenAgama">
                                        <option value="">Pilih Agama</option>
                                        <?php foreach ($agama as $option) : ?>
                                            <option value="<?= $option->refAgamaId; ?>"><?= $option->refAgamaNama; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control" name="dosenJenisKelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <?php foreach ($kelamin as $option) : ?>
                                            <option value="<?= $option->refJkId; ?>"><?= $option->refJkNama; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Gol. Darah</label>
                                    <select class="form-control" name="dosenGolDarah">
                                        <option value="">Pilih Gol. Darah</option>
                                        <?php foreach ($golDarah as $option) : ?>
                                            <option value="<?= $option->refGolDarahId; ?>"><?= $option->refGolDarahKode; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Kecamatan</label>
                                    <select class="form-control" name="dosenKecamatan">
                                        <option value="">Pilih Kecamatan</option>
                                        <?php foreach ($kecamatan as $option) : ?>
                                            <option value="<?= $option->refKecamatanId; ?>"><?= $option->refKecamatanNama; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Alamat</label>
                                    <textarea class="form-control" rows="2" name="dosenAlamat"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Status Nikah</label>
                                    <select class="form-control" name="dosenStatusNikah">
                                        <option value="">Pilih Status Nikah</option>
                                        <?php foreach ($statusNikah as $option) : ?>
                                            <option value="<?= $option->refStatusNikahId; ?>"><?= $option->refStatusNikahNama; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Jenjang Pendidikan</label>
                                    <select class="form-control" name="dosenJenjangPendidikan">
                                        <option value="">Pilih Jenjang Pendidikan</option>
                                        <?php foreach ($jenjangPendidikan as $option) : ?>
                                            <option value="<?= $option->refJenjangId; ?>"><?= $option->refJenjangNama; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Ijazah</label>
                                    <div class="custom-file">
                                        <input name="dosenDokumenIjazah" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Sertifikat Keahlian</label>
                                    <div class="custom-file">
                                        <input name="dosenSertifikatKeahlian" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>NBM</label>
                                    <input type="number" class="form-control" name="dosenNoNBM">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Dokumen NBM</label>
                                    <div class="custom-file">
                                        <input name="dosenDokumenNBM" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>NPWP</label>
                                    <input type="number" class="form-control" name="dosenNoNPWP">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Dokumen NPWP</label>
                                    <div class="custom-file">
                                        <input name="dosenDokumenNPWP" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label><strong>Kontak</strong></label>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Email Universitas</label>
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon4"><i class="las la-envelope font-size-20"></i></span>
                                        </div>
                                        <input type="text" name="dosenEmailCorporate" class="form-control" aria-describedby="basic-addon4">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Email Pribadi</label>
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5"><i class="las la-envelope font-size-20"></i></span>
                                        </div>
                                        <input type="text" name="dosenEmailGeneral" class="form-control" aria-describedby="basic-addon5">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>No. Handphone</label>
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5"><i class="las la-phone font-size-20"></i></span>
                                        </div>
                                        <input type="number" name="dosenNoHandphone" class="form-control" aria-describedby="basic-addon5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label><strong>Data Kepegawaian/Pengajar</strong></label>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="dosenUsername">
                                </div>
                                <div class="col">
                                    <label>Password</label>
                                    <input type="text" class="form-control" name="dosenPassword">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>NIP</label>
                                    <input type="number" class="form-control" name="dosenNip">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>NIDN</label>
                                    <input type="number" class="form-control" name="dosenNIDN">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>NUPTK</label>
                                    <input type="number" class="form-control" name="dosenNUPTK">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>No. Serdos</label>
                                    <input type="text" class="form-control" name="dosenNoSerdos">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Dokumen Serdos</label>
                                    <div class="custom-file">
                                        <input name="dosenDokumenSerdos" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Status Dosen</label>
                                    <select class="form-control" name="dosenStatusDosen">
                                        <option value="">Pilih Status Dosen</option>
                                        <?php foreach ($statusDosen as $option) : ?>
                                            <option value="<?= $option->refStatusDosenId; ?>"><?= $option->refStatusDosenNama; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label>Status Aktif</label>
                                    <select class="form-control" name="dosenStatusAktif">
                                        <option value="">Pilih Status Aktif</option>
                                        <?php foreach ($statusAktif as $option) : ?>
                                            <option value="<?= $option->refStatusAktifId; ?>"><?= $option->refStatusAktifNama; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
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
<?php foreach ($dosen as $edit) : ?>
    <div class="modal fade" id="editDosen<?= $edit->dosenId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data <?= ($row->dosenGelarDepan == null ? "" : $row->dosenGelarDepan) . " " . $row->dosenNama . " " . $row->dosenGelarBelakang; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/dosen/ubah/<?= $edit->dosenId ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="dosenFotoLama" value="<?= $edit->dosenFoto; ?>">
                    <input type="hidden" name="dosenDokumenKTPLama" value="<?= $edit->dosenDokumenKTP; ?>">
                    <input type="hidden" name="dosenDokumenNBMLama" value="<?= $edit->dosenDokumenNBM; ?>">
                    <input type="hidden" name="dosenDokumenNPWPLama" value="<?= $edit->dosenDokumenNPWP; ?>">
                    <input type="hidden" name="dosenDokumenSerdosLama" value="<?= $edit->dosenDokumenSerdos; ?>">
                    <input type="hidden" name="dosenDokumenIjazahLama" value="<?= $edit->dosenDokumenIjazah; ?>">
                    <input type="hidden" name="dosenSertifikatKeahlianLama" value="<?= $edit->dosenSertifikatKeahlian; ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label><strong>Identitas Pribadi</strong></label>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Foto Dosen</label>
                                        <div class="custom-file">
                                            <input name="dosenFoto" type="file" accept="image/png, image/gif, image/jpeg" class="custom-file-input" value="<?= $edit->dosenFoto; ?>" id="customFile<?= $edit->dosenId; ?>" onchange="labelDokumen(<?= $edit->dosenId; ?>)">
                                            <label class="custom-file-label custom-file-label<?= $edit->dosenId; ?>" for="customFile<?= $edit->dosenId; ?>"><?= $edit->dosenFoto; ?></label>
                                        </div>
                                        <button type="button" class="mt-2 btn btn-primary" data-toggle="modal" data-target="#fotoDosen<?= $edit->dosenId ?>"><i class=" ri-eye-fill"></i>lihat</button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>NIK</label>
                                        <input type="number" class="form-control" name="dosenNIK" value="<?= $edit->dosenNIK; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>KTP</label>
                                        <div class="custom-file">
                                            <input name="dosenDokumenKTP" type="file" accept="image/png, image/gif, image/jpeg" class="custom-file-input" value="<?= $edit->dosenDokumenKTP; ?>" id="customFile<?= $edit->dosenId; ?>" onchange="labelDokumen(<?= $edit->dosenId; ?>)">
                                            <label class="custom-file-label custom-file-label<?= $edit->dosenId; ?>" for="customFile"><?= $edit->dosenDokumenKTP; ?></label>
                                        </div>
                                        <button type="button" class="mt-2 btn btn-primary" data-toggle="modal" data-target="#ktp<?= $edit->dosenId ?>"><i class=" ri-eye-fill"></i>lihat</button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" name="dosenNama" value="<?= $edit->dosenNama; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Gelar Depan</label>
                                        <input type="text" class="form-control" name="dosenGelarDepan" value="<?= $edit->dosenGelarDepan; ?>">
                                    </div>
                                    <div class="col">
                                        <label>Gelar Belakang</label>
                                        <input type="text" class="form-control" name="dosenGelarBelakang" value="<?= $edit->dosenGelarBelakang; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Tempat Lahir</label>
                                        <input type="text" class="form-control" name="dosenTempatLahir" value="<?= $edit->dosenTempatLahir; ?>">
                                    </div>
                                    <div class="col">
                                        <label for="exampleInputdate<?= $edit->dosenId; ?>">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="dosenTanggalLahir" id="exampleInputdate<?= $edit->dosenId; ?>" value="<?= ($edit->dosenTanggalLahir == null) ? $edit->dosenTanggalLahir : reformat($edit->dosenTanggalLahir); ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Agama</label>
                                        <select class="form-control" name="dosenAgama">
                                            <option value="">Pilih Agama</option>
                                            <?php foreach ($agama as $option) : ?>
                                                <option value="<?= $option->refAgamaId; ?>" <?= ($option->refAgamaId == $edit->dosenAgama) ? "selected" : ""; ?>><?= $option->refAgamaNama; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control" name="dosenJenisKelamin">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <?php foreach ($kelamin as $option) : ?>
                                                <option value="<?= $option->refJkId; ?>" <?= ($option->refJkId == $edit->dosenJenisKelamin) ? "selected" : ""; ?>><?= $option->refJkNama; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Gol. Darah</label>
                                        <select class="form-control" name="dosenGolDarah">
                                            <option value="">Pilih Gol. Darah</option>
                                            <?php foreach ($golDarah as $option) : ?>
                                                <option value="<?= $option->refGolDarahId; ?>" <?= ($option->refGolDarahId == $edit->dosenGolDarah) ? "selected" : ""; ?>><?= $option->refGolDarahKode; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Kecamatan</label>
                                        <select class="form-control" name="dosenKecamatan">
                                            <option value="">Pilih Kecamatan</option>
                                            <?php foreach ($kecamatan as $option) : ?>
                                                <option value="<?= $option->refKecamatanId; ?>" <?= ($option->refKecamatanId == $edit->dosenKecamatan) ? "selected" : ""; ?>><?= $option->refKecamatanNama; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Alamat</label>
                                        <textarea class="form-control" rows="2" name="dosenAlamat"><?= $edit->dosenAlamat; ?></textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Status Nikah</label>
                                        <select class="form-control" name="dosenStatusNikah">
                                            <option value="">Pilih Status Nikah</option>
                                            <?php foreach ($statusNikah as $option) : ?>
                                                <option value="<?= $option->refStatusNikahId; ?>" <?= ($option->refStatusNikahId == $edit->dosenStatusNikah) ? "selected" : ""; ?>><?= $option->refStatusNikahNama; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Jenjang Pendidikan</label>
                                        <select class="form-control" name="dosenJenjangPendidikan">
                                            <option value="">Pilih Jenjang Pendidikan</option>
                                            <?php foreach ($jenjangPendidikan as $option) : ?>
                                                <option value="<?= $option->refJenjangId; ?>" <?= ($option->refJenjangId == $edit->dosenJenjangPendidikan) ? "selected" : ""; ?>><?= $option->refJenjangNama; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Ijazah</label>
                                        <div class="custom-file">
                                            <input name="dosenDokumenIjazah" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        <button type="button" class="mt-2 btn btn-primary" data-toggle="modal" data-target="#ijazah<?= $edit->dosenId ?>"><i class=" ri-eye-fill"></i>lihat</button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Sertifikat Keahlian</label>
                                        <div class="custom-file">
                                            <input name="dosenSertifikatKeahlian" type="file" accept="application/pdf" class="custom-file-input" id="customFile" onchange="labelDokumen()">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        <button type="button" class="mt-2 btn btn-primary" data-toggle="modal" data-target="#sertifikat<?= $edit->dosenId ?>"><i class=" ri-eye-fill"></i>lihat</button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>NBM</label>
                                        <input type="number" class="form-control" name="dosenNoNBM" value="<?= $edit->dosenNoNBM; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Dokumen NBM</label>
                                        <div class="custom-file">
                                            <input name="dosenDokumenNBM" type="file" accept="application/pdf" class="custom-file-input" value="<?= $edit->dosenDokumenNBM; ?>" id="customFile<?= $edit->dosenId; ?>" onchange="labelDokumen(<?= $edit->dosenId; ?>)">
                                            <label class="custom-file-label custom-file-label<?= $edit->dosenId; ?>" for="customFile<?= $edit->dosenId; ?>"><?= $edit->dosenDokumenNBM; ?></label>
                                        </div>
                                        <?php if ($edit->dosenDokumenNBM != null) : ?>
                                            <button type="button" class="mt-2 btn btn-primary" data-toggle="modal" data-target="#nbm<?= $edit->dosenId ?>"><i class=" ri-eye-fill"></i>lihat</button>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>NPWP</label>
                                        <input type="number" class="form-control" name="dosenNoNPWP" value="<?= $edit->dosenNoNPWP; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Dokumen NPWP</label>
                                        <div class="custom-file">
                                            <input name="dosenDokumenNPWP" type="file" accept="application/pdf" class="custom-file-input" value="<?= $edit->dosenDokumenNPWP; ?>" id="customFile<?= $edit->dosenId; ?>" onchange="labelDokumen(<?= $edit->dosenId; ?>)">
                                            <label class="custom-file-label custom-file-label<?= $edit->dosenId; ?>" for="customFile<?= $edit->dosenId; ?>"><?= $edit->dosenDokumenNPWP; ?></label>
                                        </div>
                                        <?php if ($edit->dosenDokumenNPWP != null) : ?>
                                            <button type="button" class="mt-2 btn btn-primary" data-toggle="modal" data-target="#npwp<?= $edit->dosenId ?>"><i class=" ri-eye-fill"></i>lihat</button>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><strong>Kontak</strong></label>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Email Universitas</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon4"><i class="las la-envelope font-size-20"></i></span>
                                            </div>
                                            <input type="text" name="dosenEmailCorporate" class="form-control" aria-describedby="basic-addon4" value="<?= $edit->dosenEmailCorporate; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Email Pribadi</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon5"><i class="las la-envelope font-size-20"></i></span>
                                            </div>
                                            <input type="text" name="dosenEmailGeneral" class="form-control" aria-describedby="basic-addon5" value="<?= $edit->dosenEmailGeneral; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>No. Handphone</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon5"><i class="las la-phone font-size-20"></i></span>
                                            </div>
                                            <input type="number" name="dosenNoHandphone" class="form-control" aria-describedby="basic-addon5" value="<?= $edit->dosenNoHandphone; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><strong>Data Kepegawaian/Pengajar</strong></label>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="dosenUsername" value="<?= $edit->dosenUsername; ?>">
                                    </div>
                                    <div class="col">
                                        <label>Password</label>
                                        <input type="text" class="form-control" name="dosenPassword" value="<?= $edit->dosenPassword; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>NIP</label>
                                        <input type="number" class="form-control" name="dosenNip" value="<?= $edit->dosenNip; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>NIDN</label>
                                        <input type="number" class="form-control" name="dosenNIDN" value="<?= $edit->dosenNIDN; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>NUPTK</label>
                                        <input type="number" class="form-control" name="dosenNUPTK" value="<?= $edit->dosenNUPTK; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>No. Serdos</label>
                                        <input type="text" class="form-control" name="dosenNoSerdos" value="<?= $edit->dosenNoSerdos; ?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Dokumen Serdos</label>
                                        <div class="custom-file">
                                            <input name="dosenDokumenSerdos" type="file" accept="application/pdf" class="custom-file-input" value="<?= $edit->dosenDokumenSerdos; ?>" id="customFile<?= $edit->dosenId; ?>" onchange="labelDokumen(<?= $edit->dosenId; ?>)">
                                            <label class="custom-file-label custom-file-label<?= $edit->dosenId; ?>" for="customFile<?= $edit->dosenId; ?>"><?= $edit->dosenDokumenSerdos; ?></label>
                                        </div>
                                        <?php if ($edit->dosenDokumenNBM != null) : ?>
                                            <button type="button" class="mt-2 btn btn-primary" data-toggle="modal" data-target="#serdos<?= $edit->dosenId ?>"><i class=" ri-eye-fill"></i>lihat</button>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Status Dosen</label>
                                        <select class="form-control" name="dosenStatusDosen">
                                            <option value="">Pilih Status Dosen</option>
                                            <?php foreach ($statusDosen as $option) : ?>
                                                <option value="<?= $option->refStatusDosenId; ?>" <?= ($option->refStatusDosenId == $edit->dosenStatusDosen) ? "selected" : ""; ?>><?= $option->refStatusDosenNama; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label>Status Aktif</label>
                                        <select class="form-control" name="dosenStatusAktif">
                                            <option value="">Pilih Status Aktif</option>
                                            <?php foreach ($statusAktif as $option) : ?>
                                                <option value="<?= $option->refStatusAktifId; ?>" <?= ($option->refStatusAktifId == $edit->dosenStatusAktif) ? "selected" : ""; ?>><?= $option->refStatusAktifNama; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
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

<!-- start modal hapus -->
<?php foreach ($dosen as $hapus) : ?>
    <div class="modal fade" id="hapusDosen<?= $hapus->dosenId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $title; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data <strong><?= ($row->dosenGelarDepan == null ? "" : $row->dosenGelarDepan) . " " . $row->dosenNama . " " . $row->dosenGelarBelakang; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/dosen/hapus/<?= $hapus->dosenId; ?>" method="post">
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

<!-- start modal foto dosen -->
<?php foreach ($dosen as $foto) : ?>
    <div class="modal fade" id="fotoDosen<?= $foto->dosenId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Foto <?= ($foto->dosenGelarDepan == null ? "" : $foto->dosenGelarDepan) . " " . $foto->dosenNama . " " . $foto->dosenGelarBelakang; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="<?= base_url() . ($foto->dosenFoto == null) ? "/assets/images/layouts/layout-3/avatar-3.png" : "/Dokumen/fotoDosen/" . $foto->dosenFoto; ?>" class="img-fluid" alt="Responsive image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal foto dosen -->

<!-- start modal ktp -->
<?php foreach ($dosen as $ktp) : ?>
    <div class="modal fade" id="ktp<?= $ktp->dosenId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">KTP <?= ($ktp->dosenGelarDepan == null ? "" : $ktp->dosenGelarDepan) . " " . $ktp->dosenNama . " " . $ktp->dosenGelarBelakang; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="<?= base_url() ?>/Dokumen/ktpDosen/<?= $ktp->dosenDokumenKTP; ?>" class="img-fluid" alt="Responsive image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal ktp -->

<!-- start modal nbm -->
<?php foreach ($dosen as $nbm) : ?>
    <?php if ($nbm->dosenDokumenNBM != null) : ?>
        <div class="modal fade" id="nbm<?= $nbm->dosenId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">NBM <?= ($nbm->dosenGelarDepan == null ? "" : $nbm->dosenGelarDepan) . " " . $nbm->dosenNama . " " . $nbm->dosenGelarBelakang; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="<?= base_url() ?>/Dokumen/nbmDosen/<?= $nbm->dosenDokumenNBM; ?>" class="img-fluid" alt="Responsive image">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endforeach ?>
<!-- end modal nbm -->

<!-- start modal npwp -->
<?php foreach ($dosen as $npwp) : ?>
    <?php if ($npwp->dosenDokumenNPWP != null) : ?>
        <div class="modal fade" id="npwp<?= $npwp->dosenId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">NPWP <?= ($npwp->dosenGelarDepan == null ? "" : $npwp->dosenGelarDepan) . " " . $npwp->dosenNama . " " . $npwp->dosenGelarBelakang; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="<?= base_url() ?>/Dokumen/npwpDosen/<?= $npwp->dosenDokumenNPWP; ?>" class="img-fluid" alt="Responsive image">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endforeach ?>
<!-- end modal npwp -->

<!-- start modal serdos -->
<?php foreach ($dosen as $serdos) : ?>
    <?php if ($serdos->dosenDokumenSerdos != null) : ?>
        <div class="modal fade" id="serdos<?= $serdos->dosenId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Serdos <?= ($serdos->dosenGelarDepan == null ? "" : $serdos->dosenGelarDepan) . " " . $serdos->dosenNama . " " . $serdos->dosenGelarBelakang; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <embed src="<?= base_url() ?>/Dokumen/serdosDosen/<?= $serdos->dosenDokumenSerdos; ?>" frameborder="0" width="100%" height="500px">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endforeach ?>
<!-- end modal serdos -->

<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>