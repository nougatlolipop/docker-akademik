function showDetailMahasiswa(idMhs) {
    $.ajax({
        type: "POST",
        url: "/fdrMahasiswa",
        data: {
            id: idMhs
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            let data = response[0][0];
            let prestasi = response[1];
            let perkuliahan = response[2];
            console.log(perkuliahan);
            let body = ``
            body += `<div class="row">`;
            body += `<div class="col-md-12">`;
            body += `<button type="button" class="float-right btn btn-outline-primary mb-3"><i class="las la-pen"></i> Edit</button>`
            body += `</div>`;
            body += `</div>`;
            body += `<div class="row">`;
            body += `<div class="col-md-12">`
            body += `<div class="table-responsive">`
            body += `<table class="table table-bordered table-responsive-md table-striped">`
            body += `<thead>`
            body += `<tr>`
            body += `<th>NIK</th>`
            body += `<th>NISN</th>`
            body += `<th>Jenis Kelamin</th>`
            body += `<th>Tempat/Tanggal Lahir</th>`
            body += `<th>Alamat</th>`
            body += `</tr>`
            body += `</thead>`
            body += `<tbody>`
            body += `<tr>`
            body += `<td>${data.nik}</td>`
            body += `<td>${data.nisn}</td>`
            body += `<td>${data.jenis_kelamin}</td>`
            body += `<td>${data.tempat_lahir}, ${data.tanggal_lahir}</td>`
            body += `<td>${data.jalan}</td>`
            body += `</tr>`
            body += `</tbody>`
            body += `</table>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `<hr>`
            body += `<div class="row">`;
            body += `<div class="col-md-12">`;
            body += `<button type="button" class="float-right btn btn-outline-primary mb-3"><i class="las la-pen"></i> Edit</button>`
            body += `</div>`;
            body += `</div>`;
            body += `<div class="row">`
            body += `<div class="col-md-12">`
            body += `<div class="row">`
            body += ` <div class="col-md-6">`
            body += `<div class="table-responsive">`
            body += `<table class="table table-bordered table-responsive-md table-striped">`
            body += `<tbody>`
            body += `<tr>`
            body += `<th>Nama Ayah</th>`
            body += `<td>${data.nama_ayah}</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Tanggal Lahir Ayah</th>`
            body += `<td>${data.tanggal_lahir_ayah}</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Pendidikan Ayah</th>`
            body += `<td>${data.nama_pekerjaan_ayah}</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Pekerjaan Ayah</th>`
            body += `<td>${data.nama_pekerjaan_ayah}</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Penghasilan Ayah</th>`
            body += `<td>${data.nama_penghasilan_ayah}</td>`
            body += `</tr>`
            body += `</tbody>`
            body += `</table>`
            body += `</div>`
            body += `</div>`
            body += `<div class="col-md-6">`
            body += `<table class="table table-bordered table-responsive-md table-striped">`
            body += `<tbody>`
            body += `<tr>`
            body += `<th>Nama Ibu</th>`
            body += `<td>${data.nama_ibu_kandung}</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Tanggal Lahir Ibu</th>`
            body += `<td>${data.tanggal_lahir_ibu}</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Pendidikan Ibu</th>`
            body += `<td>${data.nama_pendidikan_ibu}</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Pekerjaan Ibu</th>`
            body += `<td>${data.nama_pekerjaan_ibu}</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Penghasilan Ibu</th>`
            body += `<td>${data.nama_penghasilan_ibu}</td>`
            body += `</tr>`
            body += `</tbody>`
            body += `</table>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `<hr>`
            body += `<div class="accordion" id="accordionExample1">`
            body += `<div class="card">`
            body += `<div class="card-header" id="headingOne1">`
            body += `<div class="row">`
            body += `<div class="col-md-12">`
            body += `<button class="btn btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">`
            body += `Riwayat Perkuliahan`
            body += `</button>`
            body += `<button type="button" class="float-right btn btn-outline-primary"><i class="las la-pen"></i> Edit</button>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `<div id="collapseOne1" class="collapse" aria-labelledby="headingOne1" data-parent="#accordionExample1">`
            body += `<div class="card-body">`
            body += `<div class="table-responsive">`
            body += `<table class="table table-bordered table-responsive-md table-striped ">`
            body += `<thead>`
            body += `<tr>`
            body += `<th>Tahun Ajaran</th>`
            body += `<th>IP Semester</th>`
            body += `<th>IP Komulatif</th>`
            body += `</tr>`
            body += `</thead>`
            body += `<tbody>`
            if (perkuliahan.length == 0) {
                body += `<tr>`
                body += `<td style="text-align:center" colspan = "3">Mahasiswa belum mempunyai riwayat perkuliahan</td>`
                body += `</tr>`
            } else {
                perkuliahan.forEach(pres => {
                    body += `<tr>`
                    body += `<td>` + pres.nama_semester + `</td>`
                    body += `<td>` + pres.ips + `</td>`
                    body += `<td>` + pres.ipk + `</td>`
                    body += `</tr>`
                });
            }
            body += `</tbody>`
            body += `</table>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `<hr>`
            body += `<div class="accordion" id="accordionExample">`
            body += `<div class="card">`
            body += `<div class="card-header" id="headingOne">`
            body += `<div class="row">`
            body += `<div class="col-md-12">`
            body += `<button class="btn btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">`
            body += `Prestasi Mahasiswa`
            body += `</button>`
            body += `<button type="button" class="float-right btn btn-outline-primary"><i class="las la-pen"></i> Edit</button>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">`
            body += `<div class="card-body">`
            body += `<div class="table-responsive">`
            body += `<table class="table table-bordered table-responsive-md table-striped ">`
            body += `<thead>`
            body += `<tr>`
            body += `<th>Nama Prestasi</th>`
            body += `<th>Jenis</th>`
            body += `<th>Tingkat</th>`
            body += `<th>Penyelenggara</th>`
            body += `<th>Tahun</th>`
            body += `<th>Peringkat</th>`
            body += `</tr>`
            body += `</thead>`
            body += `<tbody>`
            if (prestasi.length == 0) {
                body += `<tr>`
                body += `<td style="text-align:center" colspan = "6">Mahasiswa tidak memiliki prestasi</td>`
                body += `</tr>`
            } else {
                prestasi.forEach(pres => {
                    body += `<tr>`
                    body += `<td>` + pres.nama_prestasi + `</td>`
                    body += `<td>` + pres.nama_jenis_prestasi + `</td>`
                    body += `<td>` + pres.nama_tingkat_prestasi + `</td>`
                    body += `<td>` + pres.penyelenggara + `</td>`
                    body += `<td>` + pres.tahun_prestasi + `</td>`
                    body += `<td>` + pres.peringkat + `</td>`
                    body += `</tr>`
                });
            }
            body += `</tbody>`
            body += `</table>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            $('#contentBiodata').empty()
            $('#contentBiodata').append(body)
            $('#lihatBiodata').modal('show')
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function showTranskrip(idRegMhs) {
    $.ajax({
        type: "POST",
        url: "/fdrTranskrip",
        data: {
            id: idRegMhs
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            console.log(response);
            let data = response
            let body = ``
            let no = 1
            data.forEach(nilai => {
                body += `<tr>`
                body += `<td>` + no++ + `</td>`
                body += `<td>` + nilai.nama_mata_kuliah + `</td>`
                body += `<td>` + nilai.kode_mata_kuliah + `</td>`
                body += `<td>` + nilai.sks_mata_kuliah + `</td>`
                body += `<td>` + nilai.nilai_angka + `</td>`
                body += `<td>` + nilai.nilai_huruf + `</td>`
                body += `<td>` + nilai.nilai_indeks + `</td>`
                body += `</tr>`
            });
            $('#contentNilai').empty()
            $('#contentNilai').append(body)
            $('#lihatTranskrip').modal('show')
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function getDetailAktivitas(akt) {
    let aktivitas = JSON.parse(atob(akt))
    let idAkt = aktivitas.id_aktivitas
    $.ajax({
        type: "POST",
        url: "/fdrAktivitas",
        data: {
            id: idAkt
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            let data = response
            let body = ``
            let pembimbing = data[0]
            let detail = data[1][0]
            body += `<div class="row">`;
            body += `<div class="col-md-12">`;
            body += `<button type="button" class="float-right btn btn-outline-primary mb-3"><i class="las la-pen"></i> Edit</button>`
            body += `</div>`;
            body += `</div>`;
            body += `<div class="table-responsive">`
            body += `<table class="table table-bordered table-responsive-md table-striped ">`
            body += `<tbody>`
            body += `<tr>`
            body += `<th>Prodi</th>`
            body += `<td>` + detail.nama_prodi + `</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Semester</th>`
            body += `<td>` + detail.nama_semester + `</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Jenis Aktivitas</th>`
            body += `<td>` + detail.nama_jenis_aktivitas + `</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Judul Aktivitas</th>`
            body += `<td>` + detail.judul + `</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Lokasi</th>`
            body += `<td>` + detail.lokasi + `</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Surat Keterangan</th>`
            body += `<td>` + detail.sk_tugas + `</td>`
            body += `</tr>`
            body += `<tr>`
            body += `<th>Tanggal SK</th>`
            body += `<td>` + detail.tanggal_sk_tugas + `</td>`
            body += `</tr>`
            body += `</tbody>`
            body += `</table>`
            body += `</div>`
            body += `<div class="accordion" id="accordionExample">`
            body += `<div class="card">`
            body += `<div class="card-header" id="headingOne">`
            body += `<div class="row">`
            body += `<div class="col-md-12">`
            body += `<button class="btn btn-link  text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">`
            body += `Pembimbing Aktivitas`
            body += `</button>`
            body += `<button type="button" class="float-right btn btn-outline-primary"><i class="las la-pen"></i> Edit</button>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">`
            body += `<div class="card-body">`
            body += `<div class="table-responsive">`
            body += `<table class="table table-bordered table-responsive-md table-striped ">`
            body += `<thead>`
            body += `<tr>`
            body += `<th>NIDN</th>`
            body += `<th widetailh="20%">Nama Dosen</th>`
            body += `<th>Kategori Kegiatan</th>`
            body += `</tr>`
            body += `</thead>`
            body += `<tbody>`
            if (pembimbing.length == 0) {
                body += `<tr>`
                body += `<td style="text-align:center" colspan="3"> Mahasiswa tidak mempunyai dosen pembimbing</td>`
                body += `</tr>`
            } else {
                pembimbing.forEach(pmb => {
                    body += `<tr>`
                    body += `<td>` + pmb.nidn + `</td>`
                    body += `<td>` + pmb.nama_dosen + `</td>`
                    body += `<td>` + pmb.nama_kategori_kegiatan + `</td>`
                    body += `</tr>`
                });
            }
            body += `</tbody>`
            body += `</table>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            body += `</div>`
            $('#contentAktivitas').empty()
            $('#contentAktivitas').append(body)
            $('#lihatAktivitas').modal('show')
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}