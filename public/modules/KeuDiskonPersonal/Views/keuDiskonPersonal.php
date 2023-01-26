<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/keuDiskonPersonal" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if ($validation->hasError('tagihPersonalTahun')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tagihPersonalTahun')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tagihPersonalJenisBiayaId')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tagihPersonalJenisBiayaId')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tagihPersonalTahapLunas')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tagihPersonalTahapLunas')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tagihPersonalDiskonPersentase')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tagihPersonalDiskonPersentase')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('tagihPersonalKeterangan')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', "<strong>Failed ! </strong>" . $validation->getError('tagihPersonalKeterangan')]]); ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
        <?php endif; ?>

        <?php if (empty($mhs) && isset($_GET['npm']) ? $_GET['npm'] != null : ""  && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Biodata Mahasiswa <strong>' . session()->getFlashdata('keterangan') . '</strong> Tidak Ditemukan']]); ?>
        <?php endif; ?>

        <?php if (!empty($tgh) && !empty($mhs) && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', 'Data Tagihan Mahasiswa <strong>' . session()->getFlashdata('keterangan') . '</strong> Berhasil Dimuat!']]); ?>
        <?php elseif (empty($tgh) && !empty($mhs) && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Data Tagihan Mahasiswa <strong>' . session()->getFlashdata('keterangan') . '</strong> Tidak Ditemukan!']]); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?= $title; ?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="/keuDiskonPersonal/cari" method="get" class="searchbox">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari Menggunakan NPM...." name="npm" value="<?= isset($_GET['npm']) ? $_GET['npm'] : "" ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary"><span class="las la-search"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div style="padding-top:20px; padding-bottom:10px">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Biodata</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div class="form-group">
                                                    <div class="crm-profile-img-edit">
                                                        <img class="crm-profile-pic rounded-circle avatar-100" src="<?= base_url() ?>/assets/images/layouts/layout-3/avatar-3.png" alt="profile-pic">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>NPM</label>
                                                    <input type="text" class="form-control" value="<?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->mahasiswaNpm : "-" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" value="<?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->mahasiswaNamaLengkap : "-" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Fakultas</label>
                                                    <input type="text" class="form-control" value="<?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->fakultasNama : "-" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Prodi</label>
                                                    <input type="text" class="form-control" value="<?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->prodiNama : "-" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Program Kuliah</label>
                                                    <input type="text" class="form-control" value="<?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->programKuliahNama : "-" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kelas</label>
                                                    <input type="text" class="form-control" value="<?= (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) ? $mhs[0]->waktuNama : "-" ?>" readonly>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-8">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Data Tagihan</h4>
                                            </div>
                                            <?php if (!empty($tgh) && !empty($mhs) && !empty(session()->getFlashdata('keterangan'))) : ?>
                                                <button class="btn btn-sm bg-primary" data-toggle="modal" data-target="#setting"><i class="las la-edit"><span class="pl-1"></span></i>Setting
                                                </button>
                                            <?php endif ?>
                                        </div>
                                        <div class="card-body">
                                            <div class="new-user-info">
                                                <table class="table table-bordered table-responsive-md table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" style="text-align:center">No</th>
                                                            <th>Tahun Ajaran</th>
                                                            <th>Nama Tagihan</th>
                                                            <th>Tahap</th>
                                                            <th>Diskon</th>
                                                            <th>Nominal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) : ?>
                                                            <?php $total = 0;
                                                            $no = 1;
                                                            foreach ($tgh as $data) : $total = $total + $data->nominal ?>
                                                                <tr>
                                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                                    <td><?= $data->tahunAjar; ?></td>
                                                                    <td><?= $data->jenisBiayaNama; ?></td>
                                                                    <td><?= $data->tahap; ?></td>
                                                                    <td><?= $data->diskonPersen; ?> %</td>
                                                                    <td><?= number_to_currency($data->nominal, 'Rp. ', 'id_ID', 2); ?></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                            <tr>
                                                                <td style="text-align:center" colspan="5"><strong>Total</stong>
                                                                </td>
                                                                <td><strong><?= number_to_currency($total, 'Rp. ', 'id_ID', 2) ?></strong></td>
                                                            </tr>
                                                        <?php else : ?>
                                                            <td colspan="6" style="text-align:center ;">Data Tidak Ditemukan</td>
                                                        <?php endif ?>
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
            </div>
        </div>
    </div>
</div>

<!-- start modal setting  -->
<div class="modal fade" id="setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Setting <?= $title ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/keuDiskonPersonal/setting" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="tagihPersonalMahasiswaNpm" value="<?= isset($_GET['npm']) ? $_GET['npm'] : ""  ?>">
                    <div class="form-group">
                        <label>Tahun Tagihan</label>
                        <select name="tagihPersonalTahun" class='form-control'>
                            <option selected value="">Pilih Tahun Tagihan</option>
                            <?php $thn = date("Y") - 1; ?>
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <option value="<?= $thn ?>"><?= $thn ?></option>
                                <?php $thn++ ?>
                            <?php endfor ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Tagihan</label>
                        <?php foreach ($tagihan as $tgh) : ?>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="tagihPersonalJenisBiayaId" class="custom-control-input" id="customCheck<?= $tgh->refJenisBiayaId ?>" value="<?= $tgh->refJenisBiayaId ?>">
                                <label class="custom-control-label" for="customCheck<?= $tgh->refJenisBiayaId ?>"><?= $tgh->refJenisBiayaNama ?> (<?= $tgh->refJenisBiayaKode ?>)</label>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pembayaran</label>
                        <br>
                        <?php for ($i = 0; $i <= 1; $i++) : ?>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="jenis<?= $i ?>" value="<?= $i; ?>" name="tagihPersonalTahapLunas" class="custom-control-input">
                                <label class="custom-control-label" for="jenis<?= $i ?>"><?= ($i == 0) ? "Lunas" : "Tahapan"; ?></label>
                            </div>
                        <?php endfor ?>
                    </div>
                    <div class="form-group tahap">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Diskon (Persentase/Nominal)</label>
                        <input type="number" name="tagihPersonalDiskonPersentase" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Keterangan</label>
                        <textarea class="form-control" rows="2" name="tagihPersonalKeterangan"></textarea>
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
<!-- end modal setting  -->

<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>