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
        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', 'ri-check-line', session()->getFlashdata('error')]]); ?>
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
                        <form action="/keuTeller/cari" method="GET" class="searchbox">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control npm" placeholder="Cari Menggunakan NPM...." name="npm" value="<?= isset($_GET['npm']) ? $_GET['npm'] : '' ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit"><span class="las la-search"></span></button>
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
                                                    <input type="text" class="form-control" value="<?= ($mhs != []) ? $mhs[0]->mahasiswaNpm : '-' ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" value="<?= ($mhs != []) ? $mhs[0]->mahasiswaNamaLengkap : "-" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Fakultas</label>
                                                    <input type="text" class="form-control" value="<?= ($mhs != []) ? $mhs[0]->fakultasNama : "-" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Prodi</label>
                                                    <input type="text" class="form-control" value="<?= ($mhs != []) ? $mhs[0]->prodiNama : "-" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Program Kuliah</label>
                                                    <input type="text" class="form-control" value="<?= ($mhs != []) ? $mhs[0]->programKuliahNama : "-" ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kelas</label>
                                                    <input type="text" class="form-control" value="<?= ($mhs != []) ? $mhs[0]->waktuNama : "-" ?>" readonly>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-8">
                                    <?php if (isset($_GET['npm'])) : ?>
                                        <?php if (count($jadwalLunas) > 0) : ?>
                                            <?= view('layout/templateAlert', ['msg' => ['warning', 'ri-check-line', 'Batas pemilihan metode pembayaran lunas berakhir pada tanggal <strong>' . $jadwalLunas[0]->selesai . '</strong>']]); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Data Tagihan</h4>
                                            </div>
                                            <?php if (isset($_GET['npm'])) : ?>
                                                <?php if ($isLunas[0]->tagihMetodeLunas == '0') : ?>
                                                    <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#konfirmasiLunas" type="button">Lunas</button>
                                                <?php elseif ($isLunas[0]->tagihMetodeLunas == '1') : ?>
                                                    <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#konfirmasiTahap" type="button">Tahap</button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body">
                                            <div class="new-user-info">
                                                <table class="table table-bordered table-responsive-md table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" style="text-align:center"></th>
                                                            <th>Tagihan - Tahun Ajaran</th>
                                                            <th>Tahap</th>
                                                            <th>Tanggal Tempo</th>
                                                            <th>Diskon</th>
                                                            <th>Nominal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (isset($_GET['npm'])) {
                                                            $saldoDompet =  getSaldoDompet(['savingMahasiswaNpm' => $_GET['npm']])[0]->savingNominal;
                                                            $saldoDompet = ($saldoDompet == null) ? 0 : $saldoDompet;
                                                        } else {
                                                            $saldoDompet = 0;
                                                        }
                                                        ?>
                                                        <?php $total = 0;
                                                        if (count($tagihan) > 0) : ?>
                                                            <?php
                                                            foreach ($tagihan as $tagih) :  ?>
                                                                <?php if ($tagih->forceToPay == '1') {
                                                                    $total = $total + $tagih->nominal;
                                                                } ?>
                                                                <tr>
                                                                    <td style="text-align:center"><input type="checkbox" class="tagihItem" data-id="<?= ($tagih->jenisBiayaId == 3 || $tagih->jenisBiayaId == 2 || $tagih->jenisBiayaId == 25) ? $tagih->idTagihan . ',' . $tagih->tahap . ',' . $tagih->jenisBiayaId  : $tagih->idTagihan . ',' . $tagih->jenisBiayaId . ',' . $tagih->jenisBiayaId; ?>" name=" tagihItem[]" <?= ($tagih->forceToPay == '0') ? "" : "checked" ?> <?= (reformat($tagih->endDate) < date('Y-m-d')) ? "disabled" : "" ?> <?= ($isLunas[0]->tagihMetodeLunas == '1') ? "disabled" : "" ?>></td>
                                                                    <td><?= $tagih->jenisBiayaKode . ' - ' . $tagih->tahunAjar ?></td>
                                                                    <td><?= $tagih->tahap ?></td>
                                                                    <td><?= reformat($tagih->startDate) . ' s/d ' . reformat($tagih->endDate) ?></td>
                                                                    <td><?= number_to_currency($tagih->diskon, 'Rp.', 'en_ID', 0); ?> <?= ($tagih->diskonPersen > 0) ? '(' . $tagih->diskonPersen . ' %)' : '' ?> </td>
                                                                    <td><?= number_to_currency($tagih->nominal, 'Rp.', 'en_ID', 0); ?></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                            <?php $grandTotal = $total - $saldoDompet; ?>
                                                            <tr>
                                                                <td colspan="5"><strong>Sub Tagihan</strong></td>
                                                                <td><strong><?= number_to_currency($total, 'Rp.', 'en_ID', 0); ?></strong></td>
                                                            </tr>
                                                            <?php if ($saldoDompet > 0) : ?>
                                                                <tr>
                                                                    <td colspan="5"><strong>Saldo Dompet (Saving)</strong></td>
                                                                    <td><strong><?= number_to_currency($saldoDompet, 'Rp.', 'en_ID', 0); ?></strong></td>
                                                                </tr>
                                                            <?php endif ?>
                                                            <tr>
                                                                <td colspan="5"><strong>Total Tagihan</strong></td>
                                                                <td><strong><?= number_to_currency($grandTotal, 'Rp.', 'en_ID', 0); ?></strong></td>
                                                            </tr>
                                                        <?php else : ?>
                                                            <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
                                                        <?php endif ?>
                                                    </tbody>
                                                </table>
                                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#bayar">Bayar</button>
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
</div>

<div class="modal fade" id="bayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin menerima uang sejumlah <strong><?= number_to_currency((isset($grandTotal)) ? $grandTotal : 0, 'Rp.', 'en_ID', 0); ?></strong>?</p>
                <p class="text-warning"><small>This action cannot be undone</small></p>
            </div>
            <form action="/keuTeller/create" method="get">
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary" name="npm" value="<?= isset($_GET['npm']) ? $_GET['npm'] : ""; ?>">Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="konfirmasiLunas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (isset($_GET['npm'])) : ?>
                    <?php
                    $mhsNpm = $_GET['npm'];
                    $tahun = getTahunAjaranBerjalan()[0]->tahunAjaranKode;
                    ?>
                    <?php if (count(cekPaymentExist($mhsNpm, $tahun)) >= 1) : ?>
                        <?php if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) : ?>
                            <p>System menemukan riwayat pembayaran ditahun berjalan, <strong>diskon</strong> pembayaran <strong>lunas</strong> masih dapat digunakan. Untuk proses selanjutnya klik <strong>setuju</strong>!!</p>
                        <?php else : ?>
                            <p>System menemukan riwayat pembayaran ditahun berjalan, <strong>diskon</strong> pembayaran <strong>lunas</strong> sudah tidak berlaku. Tombol <strong>setuju</strong> hanya untuk menghitung tagihan tidak termasuk diskon. Untuk proses selanjutnya klik <strong>setuju</strong>!!</p>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) : ?>
                            <p><strong>Diskon</strong> pembayaran <strong>lunas</strong> masih dapat digunakan. Untuk proses selanjutnya klik <strong>setuju</strong>!!</p>
                        <?php else : ?>
                            <p><strong>Diskon</strong> pembayaran <strong>lunas</strong> sudah tidak berlaku. Tombol <strong>setuju</strong> hanya untuk menghitung tagihan tidak termasuk diskon. Untuk proses selanjutnya klik <strong>setuju</strong>!!</p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <form action="/keuTeller/setLunas" method="post">
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary" name="npm" value="<?= isset($_GET['npm']) ? $_GET['npm'] : ""; ?>" W>Setuju</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="konfirmasiTahap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (isset($_GET['npm'])) : ?>
                    <?php
                    $mhsNpm = $_GET['npm'];
                    $tahun = getTahunAjaranBerjalan()[0]->tahunAjaranKode;
                    ?>
                    <?php if (count(cekPaymentExist($mhsNpm, $tahun)) >= 1) : ?>
                        <?php if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) : ?>
                            <p><strong>Diskon</strong> pembayaran <strong>lunas</strong> masih dapat digunakan. Klik setuju untuk pindah ke metode <strong>tahap</strong>!!</p>
                        <?php else : ?>
                            <p><strong>Diskon</strong> pembayaran <strong>lunas</strong> sudah tidak berlaku. Klik setuju untuk pindah ke metode <strong>tahap</strong>!!</p>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if (reformat($jadwalLunas[0]->mulai) <= date('Y-m-d') && reformat($jadwalLunas[0]->selesai) >= date('Y-m-d')) : ?>
                            <p><strong>Diskon</strong> pembayaran <strong>lunas</strong> masih dapat digunakan. Klik setuju untuk pindah ke metode <strong>tahap</strong>!!</p>
                        <?php else : ?>
                            <p><strong>Diskon</strong> pembayaran <strong>lunas</strong> sudah tidak berlaku. Klik setuju untuk pindah ke metode <strong>tahap</strong>!!</p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <form action="/keuTeller/setTahap" method="post">
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary" name="npm" value="<?= isset($_GET['npm']) ? $_GET['npm'] : ""; ?>" W>Setuju</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>