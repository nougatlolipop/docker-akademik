<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/keuTunggakanDetail" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if (!empty($tagihan) && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?php $angkatan = (session()->getFlashdata('keterangan')[2] == 99) ? 'Semua' : session()->getFlashdata('keterangan')[2];
            $tahap = (session()->getFlashdata('keterangan')[3] == 99) ? 'Semua' : session()->getFlashdata('keterangan')[3] ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', 'Data ' . $title . ' Tahun Ajaran <strong>' . session()->getFlashdata('keterangan')[0] . '</strong> Fakultas <strong>' . session()->getFlashdata('keterangan')[1] . '</strong> Angkatan <strong>' . $angkatan . '</strong> Tunggakan Tahap <strong>' . $tahap . '</strong> Berhasil Dimuat!']]); ?>
        <?php elseif (empty($tagihan) && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?php $angkatan = (session()->getFlashdata('keterangan')[2] == 99) ? 'Semua' : session()->getFlashdata('keterangan')[2];
            $tahap = (session()->getFlashdata('keterangan')[3] == 99) ? 'Semua' : session()->getFlashdata('keterangan')[3] ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Data ' . $title . ' Tahun Ajaran <strong>' . session()->getFlashdata('keterangan')[0] . '</strong> Fakultas <strong>' . session()->getFlashdata('keterangan')[1] . '</strong> Angkatan <strong>' .  $angkatan . '</strong> Tunggakan Tahap <strong>' . $tahap . '</strong> Tidak Ditemukan!']]); ?>
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
                        <div class="col-sm-12 pb-4">
                            <form action="<?= base_url('keuTunggakanDetail/load') ?>" method="GET">
                                <div class="form-row">
                                    <div class="col">
                                        <select class="form-control" name="tahunAjaran">
                                            <option value="">Pilih Tahun Ajaran</option>
                                            <?php if ($tagihan == null) : ?>
                                                <?php foreach ($tahunAjaran as $option) : ?>
                                                    <option value="<?= $option->tahunAjaranId ?>" <?= ($option->tahunAjaranId == $ta) ? 'selected' : '' ?>><?= $option->tahunAjaranNama ?></option>
                                                <?php endforeach ?>
                                            <?php else : ?>
                                                <?php foreach ($tahunAjaran as $option) : ?>
                                                    <option value="<?= $option->tahunAjaranId ?>" <?= ($option->tahunAjaranId == $filter[0]) ? 'selected' : '' ?>><?= $option->tahunAjaranNama ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="fakultas">
                                            <option value="99">Semua Fakultas</option>
                                            <?php foreach ($fakultas as $option) : ?>
                                                <option value="<?= $option->fakultasId ?>" <?= ($option->fakultasId == $filter[1]) ? 'selected' : '' ?>><?= $option->fakultasNama ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="angkatan">
                                            <option value="99">Semua Angkatan</option>
                                            <?php for ($i = date("Y"); $i >= 2016; $i--) : ?>
                                                <option value="<?= $i ?>" <?= ($i == $filter[2]) ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="tahap">
                                            <option value="99">Semua Tahap</option>
                                            <?php $tahap = getKeuTahap(null)[0]->refKeuTahapJumlah;
                                            for ($i = 1; $i <= $tahap; $i++) : ?>
                                                <option value="<?= $i ?>" <?= ($i == $filter[3]) ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-2"><i class="las la-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <?php if ($tagihan == null) : ?>
                            <div style="padding-top:10; padding-bottom:10px">
                                <center>
                                    <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_ufzffgnt.json" background="transparent" speed="1" style="width: 100%; height: 600px;" loop autoplay></lottie-player>
                                </center>
                            </div>
                        <?php else : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="padding-bottom:20px" class="card-header-toolbar d-flex align-items-center float-right">
                                        <button class="btn bg-success" data-toggle="modal" data-target="#cetak"><i class="las la-print"><span class="pl-1"></span></i>Cetak
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php foreach ($prodi as $prd) : ?>
                                        <?php if ($filter[1] != 99) : ?>
                                            <?php if ($prd->prodiFakultasId == $filter[1]) : ?>
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="header-title">
                                                            <h4 class="card-title"><?= $prd->prodiNama; ?></h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="new-user-info">
                                                            <table class="table table-bordered table-responsive-md table-striped ">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%" style="text-align:center">No.</th>
                                                                        <th>NPM</th>
                                                                        <th>Nama Lengkap</th>
                                                                        <th>Angkatan</th>
                                                                        <th>Nama Biaya</th>
                                                                        <th>Tahap</th>
                                                                        <th>Nominal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $total = 0;
                                                                    $no = 1; ?>
                                                                    <?php foreach ($tagihan as $rows) : ?>
                                                                        <?php if ($rows->nominal != 0) : ?>
                                                                            <?php if ($rows->prodiId == $prd->prodiId) : $total = $total + $rows->nominal ?>
                                                                                <tr>
                                                                                    <td width="5%" style="text-align:center"><?= $no++ ?></td>
                                                                                    <td><?= $rows->mahasiswaNpm ?></td>
                                                                                    <td><?= $rows->mahasiswaNamaLengkap ?></td>
                                                                                    <td><?= $rows->mahasiswaAngkatan ?></td>
                                                                                    <td><?= $rows->jenisBiayaNama ?></td>
                                                                                    <td><?= $rows->tahap ?></td>
                                                                                    <td><?= number_to_currency($rows->nominal, 'Rp.', 'en_ID', 0); ?></td>
                                                                                </tr>
                                                                            <?php endif ?>
                                                                        <?php endif ?>
                                                                    <?php endforeach ?>
                                                                    <tr>
                                                                        <td colspan=6 style="text-align: center;"><strong>Total</strong></td>
                                                                        <td><strong><?= number_to_currency($total, 'Rp.', 'en_ID', 0) ?></strong></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        <?php else : ?>
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between">
                                                    <div class="header-title">
                                                        <h4 class="card-title"><?= $prd->prodiNama; ?></h4>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="new-user-info">
                                                        <table class="table table-bordered table-responsive-md table-striped ">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%" style="text-align:center">No.</th>
                                                                    <th>NPM</th>
                                                                    <th>Nama Lengkap</th>
                                                                    <th>Angkatan</th>
                                                                    <th>Nama Biaya</th>
                                                                    <th>Tahap</th>
                                                                    <th>Nominal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $total = 0;
                                                                $no = 1; ?>
                                                                <?php foreach ($tagihan as $rows) : ?>
                                                                    <?php if ($rows->nominal != 0) : ?>
                                                                        <?php if ($rows->prodiId == $prd->prodiId) : $total = $total + $rows->nominal ?>
                                                                            <tr>
                                                                                <td width="5%" style="text-align:center"><?= $no++ ?></td>
                                                                                <td><?= $rows->mahasiswaNpm ?></td>
                                                                                <td><?= $rows->mahasiswaNamaLengkap ?></td>
                                                                                <td><?= $rows->mahasiswaAngkatan ?></td>
                                                                                <td><?= $rows->jenisBiayaNama ?></td>
                                                                                <td><?= $rows->tahap ?></td>
                                                                                <td><?= number_to_currency($rows->nominal, 'Rp.', 'en_ID', 0); ?></td>
                                                                            </tr>
                                                                        <?php endif ?>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                                <tr>
                                                                    <td colspan=6 style="text-align: center;"><strong>Total</strong></td>
                                                                    <td><strong><?= number_to_currency($total, 'Rp.', 'en_ID', 0) ?></strong></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start modal cetak -->
<div class="modal fade" id="cetak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Laporan <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin mencetak <strong><?= $title ?></strong>?</p>
            </div>
            <form action="/keuTunggakanDetail/cetak" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="tahunAjaran" value="<?= $filter[0] ?>">
                <input type="hidden" name="fakultas" value="<?= $filter[1] ?>">
                <input type="hidden" name="angkatan" value="<?= $filter[2] ?>">
                <input type="hidden" name="tahap" value="<?= $filter[3] ?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-success">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal cetak -->

<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>