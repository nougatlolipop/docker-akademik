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
                                        <th>Mata Kuliah</th>
                                        <th>Semester</th>
                                        <th>SKS</th>
                                        <th>Nilai Angka</th>
                                        <th>Nilai Huruf</th>
                                        <th>Nilai Indeks</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($datatranskrip) > 0) : ?>
                                        <?php $no = 1;
                                        foreach ($datatranskrip as $idx => $krs) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $krs->nim ?></td>
                                                <td><?= $krs->nama_mahasiswa ?></td>
                                                <td><?= $krs->nama_mata_kuliah ?></td>
                                                <td><?= $krs->nama_semester ?></td>
                                                <td><?= $krs->sks_mata_kuliah ?></td>
                                                <td><?= $krs->nilai_angka ?></td>
                                                <td><?= $krs->nilai_huruf ?></td>
                                                <td><?= $krs->nilai_indeks ?></td>
                                                <td style="text-align:center">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#lihatTranskrip"><i class="las la-eye"></i></button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Wrapper End-->

<!-- start modal lihat transkrip -->
<div class="modal fade" id="lihatTranskrip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aktivitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal lihat transkrip  -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>