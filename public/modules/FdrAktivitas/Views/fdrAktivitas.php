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
                                        <th>Jenis</th>
                                        <th>Judul Aktivitas</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($dataaktivitas) > 0) : ?>
                                        <?php $no = 1;
                                        foreach ($dataaktivitas as $idx => $keg) : ?>
                                            <tr>
                                                <td style="text-align:center"><?= $no++ ?></td>
                                                <td><?= $keg->nim ?></td>
                                                <td><?= $keg->nama_mahasiswa ?></td>
                                                <td><?= $keg->nama_jenis_peran ?></td>
                                                <td><?= $keg->judul ?></td>
                                                <td style="text-align:center">
                                                    <button type="button" class="btn btn-primary" onclick="getDetailAktivitas('<?= base64_encode(json_encode($dataaktivitas[$idx])) ?>')"><i class="las la-eye"></i></button>
                                                </td>
                                            </tr>
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

<!-- start modal lihat biodata -->
<div class="modal fade" id="lihatAktivitas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aktivitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contentAktivitas">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal lihat biodata  -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>