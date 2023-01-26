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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?= $title; ?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p class="text-left">NPM</p>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="Cari menggunakan NPM..." aria-describedby="basic-addon2" name="npmTranskrip" value="<?= isset($_GET['npm']) ? $_GET['npm'] : "" ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" name="btnCariTranskrip"><span class="las la-search"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Nama</th>
                                    <th>Kode</th>
                                    <th style="text-align:center">Semester</th>
                                    <th style="text-align:center">Nilai</th>
                                    <th style="text-align:center">Bobot</th>
                                    <th style="text-align:center">SKS</th>
                                    <th style="text-align:center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transkrip)) : ?>
                                    <?php $no = 1;
                                    foreach ($group as $grp) : ?>
                                        <?php if (hitungItem($transkrip, $grp->matkulGroupId, 'matkulGroupId') > 0) : ?>
                                            <tr>
                                                <td colspan="8"><strong><?= $grp->matkulGroupKode; ?></strong></td>
                                            </tr>
                                        <?php endif ?>
                                        <?php foreach ($transkrip as $row) : ?>
                                            <?php $mk = getMatkulByMatkul($row->matkulId); ?>
                                            <?php if ($mk) : ?>
                                                <?php if ($grp->matkulGroupId === $mk[0]->matkulGroupId) : ?>
                                                    <tr>
                                                        <td style="text-align:center"><?= $no++; ?></td>
                                                        <td><?= $mk[0]->matkulNama ?></td>
                                                        <td><?= $mk[0]->matkulKode ?></td>
                                                        <td style="text-align:center"><?= $mk[0]->studiLevelKode ?></td>
                                                        <?php if (in_array($mk[0]->matkulId, array_column($nilai, 'matkulId'))) : ?>
                                                            <?php foreach ($nilai as $n) : ?>
                                                                <?php if ($mk[0]->matkulId == $n['matkulId']) : ?>
                                                                    <?php if ($n['status'] == 1) : ?>
                                                                        <td style="text-align:center">
                                                                            <?= getNilaiAngka([$mk[0]->setKurikulumTawarProdiId, $n['gradeId'], nilaiAll($mk[0]->setKurikulumTawarProdiId)])->gradeNilaiKode ?>
                                                                        </td>
                                                                        <td style="text-align:center">
                                                                            <?= $n['nilai'] ?>
                                                                        </td>
                                                                        <td style="text-align:center"><?= $mk[0]->setMatkulKurikulumSks ?></td>
                                                                        <td style="text-align:center">
                                                                            <?= $n['total'] ?>
                                                                        </td>
                                                                    <?php else : ?>
                                                                        <td style="text-align:center">
                                                                            T
                                                                        </td>
                                                                        <td style="text-align:center">
                                                                            0
                                                                        </td>
                                                                        <td style="text-align:center"><?= $mk[0]->setMatkulKurikulumSks ?></td>
                                                                        <td style="text-align:center">
                                                                            0
                                                                        </td>
                                                                    <?php endif ?>
                                                                <?php endif ?>
                                                            <?php endforeach ?>
                                                        <?php else : ?>
                                                            <td style="text-align:center">
                                                                T
                                                            </td>
                                                            <td style="text-align:center">
                                                                0
                                                            </td>
                                                            <td style="text-align:center"><?= $mk[0]->setMatkulKurikulumSks ?></td>
                                                            <td style="text-align:center">
                                                                0
                                                            </td>
                                                        <?php endif ?>
                                                    </tr>
                                                <?php endif ?>
                                            <?php else : ?>
                                                <tr>
                                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 8]); ?>
                                                </tr>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 8]); ?>
                                    </tr>
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
<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>