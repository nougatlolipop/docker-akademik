<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/keuTunggakanMhs" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if (empty($mhs) && isset($_GET['npm']) ? $_GET['npm'] != null : ""  && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Biodata Mahasiswa <strong>' . session()->getFlashdata('keterangan') . '</strong> Tidak Ditemukan']]); ?>
        <?php endif; ?>

        <?php if (!empty($tunggak) && !empty($mhs) && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', 'Data ' . $title . ' <strong>' . session()->getFlashdata('keterangan') . '</strong> Berhasil Dimuat!']]); ?>
        <?php elseif (empty($tunggak) && !empty($mhs) && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Data ' . $title . ' <strong>' . session()->getFlashdata('keterangan') . '</strong> Tidak Ditemukan!']]); ?>
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
                        <form action="/keuTunggakanMhs/cari" method="GET" class="searchbox">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="Cari Menggunakan NPM...." name="npm" value="<?= isset($_GET['npm']) ? $_GET['npm'] : '' ?>">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="tahun">
                                        <option value="">Pilih Tahun</option>
                                        <?php for ($i = date("Y"); $i >= 2016; $i--) : ?>
                                            <option value="<?= $i ?>" <?= ($i == $ta) ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary ml-2"><i class="las la-search"></i></button>
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
                                                <h4 class="card-title">Data Tunggakan</h4>
                                            </div>
                                            <?php if (!empty($mhs && $tunggak)) : ?>
                                                <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#cetak" type="button"><i class="las la-print"><span class="pl-1"></span></i>Cetak</button>
                                            <?php endif ?>
                                        </div>
                                        <div class="card-body">
                                            <div class="new-user-info">
                                                <table class="table table-bordered table-responsive-md table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" style="text-align:center">No.</th>
                                                            <th>Tahun Ajaran</th>
                                                            <th>Nama Biaya</th>
                                                            <th>Tahap</th>
                                                            <th>Nominal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (isset($_GET['npm']) && $_GET['npm'] != null && !empty($mhs)) : ?>
                                                            <?php $total = 0;
                                                            $no = 1;
                                                            foreach ($tunggak as $row) : $total = $total + $row->nominal ?>
                                                                <tr>
                                                                    <td style="text-align:center"><?= $no++; ?></td>
                                                                    <td><?= $row->tahunAjar; ?></td>
                                                                    <td><?= $row->jenisBiayaNama; ?></td>
                                                                    <td><?= $row->tahap; ?></td>
                                                                    <td><?= number_to_currency($row->nominal, 'Rp. ', 'id_ID', 0); ?></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                            <tr>
                                                                <td style="text-align:center" colspan="4"><strong>Total</stong>
                                                                </td>
                                                                <td><strong><?= number_to_currency($total, 'Rp. ', 'id_ID', 0) ?></strong></td>
                                                            </tr>
                                                        <?php else : ?>
                                                            <td colspan="5" style="text-align:center ;">Data Tidak Ditemukan</td>
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
<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>