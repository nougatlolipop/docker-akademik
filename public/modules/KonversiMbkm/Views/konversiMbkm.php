<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item"><a href="/konversiMbkm" class="text-white"><?= $breadcrumb[1]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[2]; ?></li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?= $title ?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="/konversiMbkm/add" method="post" id="syncMbkm">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Mata Kuliah Lama</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p class="text-left">NPM</p>
                                                    <div class="input-group mb-4">
                                                        <input type="text" class="form-control" placeholder="Cari menggunakan NPM..." aria-describedby="basic-addon2" name="npmMbkm">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button" name="btnCariMbkm"><span class="las la-search"></span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="text-left">Nama Mahasiswa</p>
                                                    <div class="input-group mb-4">
                                                        <input type="text" class="form-control" aria-describedby="basic-addon2" name="namaLengkapKonversi" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-bordered table-responsive-md table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th width="15%">Kode</th>
                                                        <th>Nama</th>
                                                        <th width="5%">SKS</th>
                                                        <th width="10%">Nilai Lama</th>
                                                        <th>-</th>
                                                        <th width="30%">Matkul Konversi</th>
                                                        <th width="10%">Nilai Konversi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="namaMk">
                                                    <tr>
                                                        <td style="text-align: center;"><input type='checkbox' name='record'></td>
                                                        <td><input type='type' class='form-control' name='kode[]'></td>
                                                        <td><input type='type' class='form-control' name='nama[]'></td>
                                                        <td><input type='type' class='form-control' name='sks[]'></td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="hidden" class="form-control" id="nilaiLamaSave1" aria-describedby=" basic-addon2" name="nilaiLamaSave[]" readonly>
                                                                <input type="text" class="form-control" id="nilaiLama1" aria-describedby=" basic-addon2" name="nilaiLama[]" readonly>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary" type="button" onclick="btnCariNilaiLama(1)"><span class="las la-search"></span></button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>-</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="hidden" class="form-control" id="mkKonversiSave1" aria-describedby=" basic-addon2" name="mkKonversiSave[]" readonly>
                                                                <input type="text" class="form-control" id="mkKonversi1" aria-describedby=" basic-addon2" name="mkKonversi[]" readonly>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary" type="button" onclick="btnCariMkKonversi(1)"><span class="las la-search"></span></button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="hidden" class="form-control" id="nilaiSave1" aria-describedby=" basic-addon2" name="nilaiSave[]" readonly>
                                                                <input type="text" class="form-control" id="nilai1" aria-describedby=" basic-addon2" name="nilai[]" readonly>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary" type="button" onclick="btnCariNilai(1)"><span class="las la-search"></span></button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-danger" id="hapus"><i class="las la-trash"></i>Hapus Seleksi</button>
                                            <button type="button" class="btn btn-primary" id="btnTambahMk"><i class="las la-plus"></i>Tambah Matkul</button>
                                            <button type="button" class="btn btn-warning float-right" onclick="syncMbkm()">Sync >></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h4 class="card-title">Mata Kuliah Diakui</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty(session()->get('dataSession'))) : ?>
                                            <?= view('layout/templateAlert', ['msg' => ['warning', 'ri-check-line', 'Data konversi MBKM nilai belum tersimpan, masih ada satu tahapan lagi untuk melakukan penyimpan. Tekan tombol <strong>Simpan</strong> untuk menyimpan nilai konversiMbkm']]); ?>
                                        <?php endif ?>
                                        <input type="hidden" name="npmKonv" value="<?= (session()->get('dataSession') != null) ? session()->get('dataSession')['npm'] : "" ?>">

                                        <table class="table table-bordered table-responsive-md table-striped ">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Nama</th>
                                                    <th>SKS</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty(session()->get('dataSession')['matkulkonversi'])) : ?>
                                                    <?php foreach (session()->get('dataSession')['matkulkonversi'] as $dataSync) : ?>
                                                        <?php $mk = getMatkul($dataSync['matkulId'])[0]; ?>
                                                        <?php $nil = getNilaiAngka([session()->get('dataSession')['prodi'], $dataSync['gradeId']])[0]
                                                        ?>
                                                        <tr>
                                                            <td><?= $mk->matkulKode ?></td>
                                                            <td><?= $mk->matkulNama ?></td>
                                                            <td><?= $mk->setMatkulKurikulumSks ?></td>
                                                            <td><?= $nil->gradeNilaiKode ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="4" style="text-align: center;">Mata kuliah konversi Mbkm yang diakui</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <a href="/konversiMbkm/abort" type="button" class="btn btn-danger"><i class="las la-trash"></i>Batal Sync</a>
                                        <a href="/konversiMbkm/proses" type="button" class="btn btn-primary"><i class="las la-plus"></i>Simpan</a>
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

<div class="modal fade" id="cariNilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Nilai Untuk <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-responsive-md table-striped ">
                    <thead>
                        <tr>
                            <th colspan="<?= count($nilai) ?>" style="text-align:center;">Pilih Nilai</th>
                        </tr>
                        <tr>
                            <?php foreach ($nilai as $n) : ?>
                                <th><?= $n->gradeNilaiKode ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody id="nilaiInput">
                        <tr>
                            <?php foreach ($nilai as $n) : ?>
                                <td style=" text-align:center"><input type="radio" name="pilihNilai" value="<?= $n->gradeNilaiId ?>" data-text="<?= $n->gradeNilaiKode ?>"></td>
                            <?php endforeach ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="setNilai()">Pilih</button>
            </div>
        </div>
    </div>
</div>

<div class=" modal fade" id="cariMatkul" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-responsive-md table-striped ">
                    <thead>
                        <tr>
                            <th style="text-align:center">Pilih</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>SKS</th>
                        </tr>
                    </thead>
                    <tbody id="matkulKonversi">
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="setMatkul()">Pilih</button>
            </div>
        </div>
    </div>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>