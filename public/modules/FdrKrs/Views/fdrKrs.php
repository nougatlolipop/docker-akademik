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
                        <div class="iq-search-bar device-search float-right">
                            <div class="searchbox">
                                <input type="text" class="text search-input cari" placeholder="Type here to search..." name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                <a class="search-link" style="cursor: pointer;"><i class="ri-search-line"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-responsive-md table-striped ">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">No.</th>
                                        <th>NPM</th>
                                        <th>Nama Lengkap</th>
                                        <th>Kode Mata Kuliah</th>
                                        <th>Mata Kuliah</th>
                                        <th>SKS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($datakrs) > 0) : ?>
                                        <?php $no = 1;
                                        foreach ($tahunAjar as $key => $value) : ?>
                                            <tr>
                                                <td colspan="6"><strong><?= $value ?></strong></td>
                                            </tr>
                                            <?php foreach ($datakrs as $idx => $krs) : ?>

                                                <?php if ($value == $krs->nama_periode) : ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $krs->nim ?></td>
                                                        <td><?= $krs->nama_mahasiswa ?></td>
                                                        <td><?= $krs->kode_mata_kuliah ?></td>
                                                        <td><?= $krs->nama_mata_kuliah ?></td>
                                                        <td><?= $krs->sks_mata_kuliah ?></td>
                                                    </tr>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <tr>
                                            <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
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
</div>
<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>