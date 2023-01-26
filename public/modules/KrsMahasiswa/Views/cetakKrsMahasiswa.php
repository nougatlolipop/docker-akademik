<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KartuRencanaStudi_<?= $mahasiswa[0]->npmMhs ?>_<?= $tahunAjaran ?></title>
    <style>
        body {
            font-family: "Calibri";
        }

        .big {
            font-size: 12px;
        }

        .small {
            font-size: 10px;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .space-ttd {
            margin: 0px 0px 70px 0px;
        }

        .space-clear {
            margin: 0px 0px 0px 0px;
        }

        .black {
            border: 1px solid black;
        }

        .dinamis {
            border: 1px solid black;
            padding: 5px;
        }

        .statis {
            font-weight: bold;
            padding: 5px;
        }

        div.logo {
            float: left;
            width: 70px;
            height: 70px;
        }

        div.header {
            float: left;
            width: 350px;
            font-weight: bold;
            margin: 0px 0px 0px 10px;
            padding: 10px 0px 10px 0px;
        }

        div.kartu {
            width: 100%;
            margin: 5px 0px 0px 0px;
            font-weight: bold;
        }

        div.biodata {
            float: left;
            position: relative;
            margin: 20px 0px 0px 0px;
            width: 90%;
        }

        div.foto {
            float: right;
            position: relative;
            margin: -40px 0px 0px 0px;
            height: 90px;
            width: 70px;
        }

        div.matkul {
            margin: 10px 0px 0px 0px;
            width: 100%;
        }

        div.matkul table {
            border-collapse: collapse;
            width: 100%;
        }

        div.matkul table tr th {
            border: 1px solid black;
            padding: 5px;
        }

        div.ttd-mhs {
            float: left;
            width: 20%;
            margin: 25px 0px 100px 0px;
        }

        div.ttd-wd {
            float: right;
            width: 20%;
            margin: -15px 0px 100px 0px;
        }

        div.ttd-pa {
            float: left;
            width: 20%;
            margin: 15px 0px 0px 350px;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="<?= FCPATH . 'assets/images/logo-umsu-white.png' ?>" alt="logo-umsu">
    </div>
    <div class="header center">
        <p class="big space-clear">MAJELIS PENDIDIKAN TINGGI MUHAMMADIYAH</p>
        <p class="big space-clear">UNIVERSITAS MUHAMMADIYAH SUMATERA UTARA</p>
        <p class="big space-clear"><?= ($mahasiswa[0]->fakultasKode == '20') ? strtoupper($mahasiswa[0]->prodiNama) : strtoupper($mahasiswa[0]->fakultasNama); ?></p>
    </div>
    <div class="kartu center">
        <p class="big space-clear">KARTU RENCANA STUDI</p>
        <p class="big space-clear"><?= $tahunAjaran ?></p>
    </div>
    <div class="biodata">
        <table>
            <tr>
                <td class="big left">NPM</td>
                <td class="big left"></td>
                <td class="big left"> : <?= $mahasiswa[0]->npmMhs; ?></td>
            </tr>
            <tr>
                <td class="big left">Nama Mahasiswa</td>
                <td class="big left"></td>
                <td class="big left"> : <?= $mahasiswa[0]->namaMhs; ?></td>
            </tr>
            <tr>
                <td class="big left">Program Studi</td>
                <td class="big left"></td>
                <td class="big left"> : <?= $mahasiswa[0]->prodiNama; ?> - <?= $mahasiswa[0]->programKuliahNama; ?></td>
            </tr>
        </table>
    </div>
    <div class="foto black">
        <?php $file_header = @get_headers("https://mahasiswa.umsu.ac.id/FotoMhs/20" . substr($mahasiswa[0]->npmMhs, 0, 2) . "/" . $mahasiswa[0]->npmMhs . ".jpg"); ?>
        <?= (!$file_header || $file_header[0] == 'HTTP/1.1 404 Not Found') ? '' : '<img src="https://mahasiswa.umsu.ac.id/FotoMhs/20' . substr($mahasiswa[0]->npmMhs, 0, 2) . '/' . $mahasiswa[0]->npmMhs . '.jpg" alt="logo-umsu">' ?>
    </div>
    <div class="matkul">
        <table>
            <thead>
                <tr>
                    <th class="big center" rowspan="2">No.</th>
                    <th class="big center" rowspan="2">Mata Kuliah</th>
                    <th class="big center" rowspan="2">SKS</th>
                    <th class="big center" rowspan="2">Kelas</th>
                    <th class="big center" rowspan="2">Jadwal</th>
                    <th class="big center" rowspan="2">Dosen</th>
                    <th class="big center" colspan="2">Paraf</th>
                </tr>
                <tr>
                    <th class="big center">UTS</th>
                    <th class="big center">UAS</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php $jmlSks = [] ?>
                <?php foreach ($matkul as $row) : ?>
                    <?php $jmlSks[] = $row->setMatkulKurikulumSks ?>
                    <tr>
                        <td class="small dinamis center"><?= $no++ ?></td>
                        <td class="small dinamis left"><?= $row->matkulKode ?> <?= $row->matkulNama; ?></td>
                        <td class="small dinamis center"><?= $row->setMatkulKurikulumSks ?></td>
                        <td class="small dinamis center"><?= $row->kelasKode ?><?= $row->waktuNama; ?></td>
                        <td class="small dinamis left"><?= reformatRoster(['list', $row->setMatkulTawarId]); ?></td>
                        <td class="small dinamis left"><?= reformatDosenMatkul(['paragraf', json_decode($row->setMatkulTawarDosen)->data]); ?></td>
                        <td class="small dinamis left"></td>
                        <td class="small dinamis left"></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td class="big statis"></td>
                    <td class="big statis right">Jumlah :</td>
                    <td class="big statis center"><?= array_sum($jmlSks); ?>.00</td>
                    <td class="big statis"></td>
                    <td class="big statis"></td>
                    <td class="big statis"></td>
                    <td class="big statis"></td>
                    <td class="big statis"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="ttd-mhs">
        <p class="big space-ttd">Mahasiswa Ybs,</p>
        <p class="big space-clear"><?= $mahasiswa[0]->namaMhs; ?></p>
        <p class="big space-clear">NPM. <?= $mahasiswa[0]->npmMhs; ?></p>
    </div>
    <div class="ttd-wd">
        <p class="big space-clear">Medan, <?= reformatTanggalIndo(date('d-m-Y')); ?></p>
        <?php if ($mahasiswa[0]->fakultasKode == '20') : ?>
            <p class="big space-ttd">Ketua Prodi</p>
            <p class="big space-clear"><?= ($mahasiswa[0]->kaprodiGelarDepan == null) ? '' : $mahasiswa[0]->kaprodiGelarDepan; ?> <?= $mahasiswa[0]->kaprodiNama; ?> <?= $mahasiswa[0]->kaprodiGelarBelakang; ?></p>
        <?php else : ?>
            <p class="big space-ttd">Wakil Dekan 1</p>
            <p class="big space-clear"><?= ($mahasiswa[0]->wd1GelarDepan == null) ? '' : $mahasiswa[0]->wd1GelarDepan; ?> <?= $mahasiswa[0]->wd1Nama; ?> <?= $mahasiswa[0]->wd1GelarBelakang; ?></p>
        <?php endif ?>
    </div>
    <?php if ($mahasiswa[0]->fakultasKode != '20') : ?>
        <div class="ttd-pa">
            <p class="big space-ttd">Dosen Pembimbing</p>
            <p class="big"><?= ($mahasiswa[0]->paGelarDepan == null) ? '' : $mahasiswa[0]->paGelarDepan; ?> <?= $mahasiswa[0]->paNama; ?> <?= $mahasiswa[0]->paGelarBelakang; ?></p>
        </div>
    <?php endif ?>
</body>

</html>