<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/keuBayarTotal" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <?php if (!empty($pemb) && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?php $tahap = (session()->getFlashdata('keterangan')[1] == 99) ? 'Semua' : session()->getFlashdata('keterangan')[1];
            $bnk = (session()->getFlashdata('keterangan')[2] == 99) ? 'Semua' : session()->getFlashdata('keterangan')[2]
            ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', 'Data ' . $title . ' Tahun Ajaran <strong>' . session()->getFlashdata('keterangan')[0] . '</strong> Pembayaran Tahap <strong>' . $tahap . '</strong> Pada Bank <strong>' . $bnk . ' </strong> Berhasil Dimuat!']]); ?>
        <?php elseif (empty($pemb) && !empty(session()->getFlashdata('keterangan'))) : ?>
            <?php $tahap = (session()->getFlashdata('keterangan')[1] == 99) ? 'Semua' : session()->getFlashdata('keterangan')[1];
            $bnk = (session()->getFlashdata('keterangan')[2] == 99) ? 'Semua' : session()->getFlashdata('keterangan')[2]
            ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-alert-line', 'Data ' . $title . ' Tahun Ajaran <strong>' . session()->getFlashdata('keterangan')[0] . '</strong> Pembayaran Tahap <strong>' . $tahap . '</strong> Pada Bank <strong>' . $bnk . ' </strong> Tidak Ditemukan!']]); ?>
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
                            <form action="<?= base_url('keuBayarTotal/load') ?>" method="GET">
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <select class="form-control" name="tahunAjaran">
                                            <option value="">Pilih Tahun Ajaran</option>
                                            <?php if ($pemb == null) : ?>
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
                                    <div class="col-md-2">
                                        <select class="form-control" name="tahap">
                                            <option value="">Pilih Tahap</option>
                                            <?php $tahap = getKeuTahap(null)[0]->refKeuTahapJumlah;
                                            for ($i = 1; $i <= $tahap; $i++) : ?>
                                                <option value="<?= $i ?>" <?= ($i == $filter[1]) ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="bank">
                                            <option value="">Pilih Bank</option>
                                            <?php foreach ($bank as $option) : ?>
                                                <option value="<?= $option->bankId ?>" <?= ($option->bankId == $filter[2]) ? 'selected' : '' ?>><?= $option->bankKode ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-2"><i class="las la-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <?php if ($pemb == null) : ?>
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
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title"><?= $title; ?></h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="new-user-info">
                                                <table class="table table-bordered table-responsive-md table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" style="text-align:center">No.</th>
                                                            <th style="text-align:center">Fakultas / Prodi</th>
                                                            <th colspan=<?= count($angkatan) ?> style="text-align:center">Angkatan</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <?php $a = [];
                                                            foreach ($angkatan as $ang) : ?>
                                                                <?php
                                                                $a[$ang] = 0;
                                                                ?>
                                                                <th style="text-align:center"><?= $ang; ?></th>
                                                            <?php endforeach ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($fakultas as $fak) : ?>
                                                            <tr>
                                                                <td></td>
                                                                <td><strong><?= $fak->fakultasNama; ?></strong></td>
                                                                <?php foreach ($angkatan as $ang) : ?>
                                                                    <td></td>
                                                                <?php endforeach ?>
                                                            </tr>
                                                            <?php $no = 1;
                                                            foreach ($prodi as $prd) : ?>
                                                                <?php if ($fak->fakultasId == $prd->prodiFakultasId) : ?>
                                                                    <tr>
                                                                        <td><?= $no++; ?></td>
                                                                        <td><?= $prd->prodiNama; ?></td>
                                                                        <?php foreach ($angkatan as $ang) : ?>
                                                                            <?php $nilai = 0;
                                                                            foreach ($pemb as $pmb) : ?>
                                                                                <?php ($ang == $pmb->angkatan && $prd->prodiNama == $pmb->prodiNama) ? $nilai = $pmb->nominal : $nilai = $nilai ?>
                                                                                <?php if ($ang == $pmb->angkatan && $prd->prodiNama == $pmb->prodiNama) : ?>
                                                                                    <?php $a[$ang] = $a[$ang] + $pmb->nominal; ?>
                                                                                <?php endif ?>
                                                                            <?php endforeach ?>
                                                                            <td><?= number_to_currency($nilai, 'Rp.', 'en_ID', 0); ?></td>
                                                                        <?php endforeach ?>
                                                                    </tr>
                                                                <?php endif ?>
                                                            <?php endforeach ?>
                                                        <?php endforeach ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><strong>Pembayaran Per Angkatan</strong></td>
                                                            <?php foreach ($angkatan as $ang) : ?>
                                                                <td><?= number_to_currency($a[$ang], 'Rp.', 'en_ID', 0); ?></td>
                                                            <?php endforeach ?>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td><strong>Total Bayar</strong></td>
                                                            <?php $totalBayar = 0;
                                                            foreach ($angkatan as $ang) : ?>
                                                                <?php $totalBayar = $totalBayar + $a[$ang] ?>
                                                            <?php endforeach ?>
                                                            <td colspan="<?= count($angkatan); ?>" style="text-align:center"><strong><?= number_to_currency($totalBayar, 'Rp.', 'en_ID', 0); ?></strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
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
            <form action="/keuBayarTotal/cetak" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="tahunAjaran" value="<?= $filter[0] ?>">
                <input type="hidden" name="tahap" value="<?= $filter[1] ?>">
                <input type="hidden" name="bank" value="<?= $filter[2] ?>">
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