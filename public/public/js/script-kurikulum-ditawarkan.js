$(document).ready(function() {
    var prodiAkd;
    var programKuliahAkd;

    var url = new URLSearchParams(window.location.search);
    let nilaiProdi = url.get('prodi');
    let nilaiProgramKuliah = url.get('pgKuliah');
    let nilaiKurikulum = url.get('kurikulum');

    //menampilkan program kuliah di modal edit matkul kurikulum

    $(".prodiAkademik").change(function() {
        prodiAkd = $(this).val();
        $.ajax({
            type: "POST",
            url: "/setKurikulumDitawarkan/programKuliah",
            data: {
                prodiAkademik: prodiAkd
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Program Kuliah</option>";
                if (response.list_program_kuliah.length == 0) {
                    alert('Data Program Kuliah tidak ditemukan');
                    $(".programKuliahAkademik").empty();
                    $(".programKuliahAkademik").append(data);
                } else {
                    $(".programKuliahAkademik").empty();
                    $(".programKuliahAkademik").append(data, response.list_program_kuliah);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    // menampilkan program kuliah di roster

    $(".prodiRoster").change(function() {
        prodiAkd = $(this).val();
        $.ajax({
            type: "POST",
            url: "/setKurikulumDitawarkan/programKuliah",
            data: {
                prodiAkademik: prodiAkd
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Program Kuliah</option>";
                if (response.list_program_kuliah.length == 0) {
                    alert('Data Program Kuliah tidak ditemukan');
                    $(".programKuliahRoster").empty();
                    $(".programKuliahRoster").append(data);
                } else {
                    $(".programKuliahRoster").empty();
                    $(".programKuliahRoster").append(data, response.list_program_kuliah);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    // menampilkan program kuliah di rombel dosen pa

    $(".prodiRombel").change(function() {
        prodiAkd = $(this).val();
        $.ajax({
            type: "POST",
            url: "/setKurikulumDitawarkan/programKuliah",
            data: {
                prodiAkademik: prodiAkd
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Program Kuliah</option>";
                if (response.list_program_kuliah.length == 0) {
                    alert('Data Program Kuliah tidak ditemukan');
                    $(".programKuliahRombel").empty();
                    $(".programKuliahRombel").append(data);
                } else {
                    $(".programKuliahRombel").empty();
                    $(".programKuliahRombel").append(data, response.list_program_kuliah);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan program kuliah di modal edit kurikulum tawarkan

    $(".prodiKurikulum").change(function() {
        prodiAkd = $(this).val();
        $.ajax({
            type: "POST",
            url: "/setKurikulumDitawarkan/programKuliah",
            data: {
                prodiAkademik: prodiAkd
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Program Kuliah</option>";
                if (response.list_program_kuliah.length == 0) {
                    alert('Data Program Kuliah tidak ditemukan');
                    $(".programKuliahKurikulum").empty();
                    $(".programKuliahKurikulum").append(data);
                } else {
                    $(".programKuliahKurikulum").empty();
                    $(".programKuliahKurikulum").append(data, response.list_program_kuliah);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan program kuliah di modal edit matkul tawarkan

    $(".prodiAkademik").change(function() {
        prodiAkd = $(this).val();
        $.ajax({
            type: "POST",
            url: "/setKurikulumDitawarkan/programKuliah",
            data: {
                prodiAkademik: prodiAkd
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Program Kuliah</option>";
                if (response.list_program_kuliah.length == 0) {
                    alert('Data Program Kuliah tidak ditemukan');
                    $(".programKuliahMatkul").empty();
                    $(".programKuliahMatkul").append(data);
                } else {
                    $(".programKuliahMatkul").empty();
                    $(".programKuliahMatkul").append(data, response.list_program_kuliah);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan kurikulum di matkul kurikulum

    $(".programKuliahAkademik").change(function() {
        programKuliahAkd = $(this).val();
        $.ajax({
            type: "POST",
            url: "/setMatkulKurikulum/kurikulum",
            data: {
                prodiAkademik: prodiAkd,
                programKuliahAkademik: programKuliahAkd,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                $(".kurikulumAkademik").html(response.list_kurikulum);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan matkul kurikulum di modal tambah matkul tawarkan

    $(".tambahMatkulTawar").click(function() {
        console.log('matkul kurikulum');
        $.ajax({
            type: "POST",
            url: "/setMatkulDitawarkan/matkulKurikulum",
            data: {
                prodiAkademik: nilaiProdi,
                programKuliahAkademik: nilaiProgramKuliah,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Mata Kuliah Kurikulum</option>";
                if (response.list_matkul_kurikulum.length == 0) {
                    alert('Data Mata Kuliah Kurikulum tidak ditemukan');
                    $(".matkulKurikulumAkademik").empty();
                    $(".matkulKurikulumAkademik").append(data);
                } else {
                    $(".matkulKurikulumAkademik").empty();
                    $(".matkulKurikulumAkademik").append(data, response.list_matkul_kurikulum);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan matkul kurikulum di modal edit matkul tawarkan

    $(".programKuliahMatkul").change(function() {
        programKuliahAkd = $(this).val();
        console.log(prodiAkd, programKuliahAkd);
        $.ajax({
            type: "POST",
            url: "/setMatkulDitawarkan/matkulKurikulum",
            data: {
                prodiAkademik: prodiAkd,
                programKuliahAkademik: programKuliahAkd,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Mata Kuliah Kurikulum</option>";
                if (response.list_matkul_kurikulum.length == 0) {
                    alert('Data Mata Kuliah Kurikulum tidak ditemukan');
                    $(".matkulKurikulumEdit").empty();
                    $(".matkulKurikulumEdit").append(data);
                } else {
                    $(".matkulKurikulumEdit").empty();
                    $(".matkulKurikulumEdit").append(data, response.list_matkul_kurikulum);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan prodi program kuliah di modal tambah matkul tawarkan

    $(".matkulKurikulumAkademik").change(function() {
        console.log(nilaiProdi, nilaiProgramKuliah);
        $.ajax({
            type: "POST",
            url: "/setMatkulDitawarkan/prodiProgramKuliah",
            data: {
                prodiAkademik: nilaiProdi,
                programKuliahAkademik: nilaiProgramKuliah,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Prodi Program Kuliah</option>";
                if (response.list_prodi_program_kuliah.length == 0) {
                    alert('Data Prodi Program Kuliah tidak ditemukan');
                    $(".prodiProgramKuliahAkademik").empty();
                    $(".prodiProgramKuliahAkademik").append(data);
                } else {
                    $(".prodiProgramKuliahAkademik").empty();
                    $(".prodiProgramKuliahAkademik").append(data, response.list_prodi_program_kuliah);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan prodi program kuliah di modal edit matkul tawarkan

    $(".matkulKurikulumEdit").change(function() {
        $.ajax({
            type: "POST",
            url: "/setMatkulDitawarkan/prodiProgramKuliahEdit",
            data: {
                prodiAkademik: prodiAkd,
                programKuliahAkademik: programKuliahAkd,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Prodi Program Kuliah</option>";
                if (response.list_prodi_program_kuliah.length == 0) {
                    alert('Data Prodi Program Kuliah tidak ditemukan');
                    $(".prodiProgramKuliahEdit").empty();
                    $(".prodiProgramKuliahEdit").append(data);
                } else {
                    $(".prodiProgramKuliahEdit").empty();
                    $(".prodiProgramKuliahEdit").append(data, response.list_prodi_program_kuliah);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan kurikulum ditawarkan di modal tambah matkul kurikulum

    $(".tambahMatkulKurikulum").click(function() {
        $.ajax({
            type: "POST",
            url: "/setMatkulKurikulum/kurikulumDitawarkan",
            data: {
                prodiAkademik: nilaiProdi,
                programKuliahAkademik: nilaiProgramKuliah,
                kurikulumAkademik: nilaiKurikulum,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Kurikulum Ditawarkan</option>";
                if (response.list_kurikulum.length == 0) {
                    alert('Data Kurikulum Ditawarkan tidak ditemukan');
                    $(".kurikulumAkademik").empty();
                    $(".kurikulumAkademik").append(data);
                } else {
                    $(".kurikulumAkademik").append(data, response.list_kurikulum);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan kurikulum ditawarkan di modal edit matkul kurikulum

    $(".programKuliahAkademik").change(function() {
        $.ajax({
            type: "POST",
            url: "/setMatkulKurikulum/kurikulumDitawarkanEdit",
            data: {
                prodiAkademik: prodiAkd,
                programKuliahAkademik: programKuliahAkd,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Kurikulum Ditawarkan</option>";
                if (response.list_kurikulum.length == 0) {
                    alert('Data Kurikulum Ditawarkan tidak ditemukan COK');
                    $(".kurikulumDitawarkanAkademik").empty();
                    $(".kurikulumDitawarkanAkademik").append(data);
                } else {
                    $(".kurikulumDitawarkanAkademik").empty();
                    $(".kurikulumDitawarkanAkademik").append(data, response.list_kurikulum);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan matkul ditawarkan di modal edit matkul kurikulum

    $(".kelompokMatkul").change(function() {
        $.ajax({
            type: "POST",
            url: "/setMatkulKurikulum/matkulProdi",
            data: {
                prodiAkademik: prodiAkd,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Mata Kuliah</option>";
                if (response[0].length == 0) {
                    alert('Data Mata Kuliah tidak ditemukan');
                    $(".matkulProdiAkademik").empty();
                    $(".matkulProdiAkademik").append(data);
                } else {
                    response[0].forEach(element => {
                        data += "<option value='" + element.matkulId + "'>" + element.matkulKode + " - " + element.matkulNama + "</option>";
                    });
                    $(".matkulProdiAkademik").empty();
                    $(".matkulProdiAkademik").append(data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan matkul di modal tambah matkul kurikulum

    $(".studiLevelAkademik").change(function() {
        var url = new URLSearchParams(window.location.search);
        let nilaiProdi = url.get('prodi');
        $.ajax({
            type: "POST",
            url: "/setMatkulKurikulum/matkulProdi",
            data: {
                prodiAkademik: nilaiProdi,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                if (response[0].length == 0) {
                    alert("Data Mata Kuliah tidak ditemukan");
                } else {
                    var data = "";
                    var no = 0;
                    response[0].forEach(prd => {
                        data += "<tr>";
                        data += "<td style='text-align:center'><div class='custom-control custom-checkbox'><input name='urut[]' value='" + no + "' type='checkbox' class='custom-control-input' id='customCheckMatkul" + no + "'><label class='custom-control-label' for='customCheckMatkul" + no + "'></label></div></td>";
                        data += "<td><input type='hidden' value='" + prd.matkulId + "' class='form-control' name='setMatkulKurikulumMatkulId[" + no + "]'>" + prd.matkulKode + " - " + prd.matkulNama + "</td>";
                        data += "<td><select class='form-control' name='setMatkulKurikulumMatkulGroupId[]'><option value=''>Pilih Kelompok Mata Kuliah</option>"
                        response[1].forEach(grp => {
                            data += "<option value='" + grp.matkulGroupId + "'>" + grp.matkulGroupNama + " (" + grp.matkulGroupKode + ") </option>"
                        })
                        "</select></td>"
                        data += "<td style='text-align:center'><input type='text' class='form-control' name='setMatkulKurikulumSks[" + no + "]'></td>";
                        data += "</tr>";
                        no++;
                    });
                    $(".matkulProdi").empty();
                    $(".matkulProdi").append(data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    //menampilkan prodi program kuliah di modal tambah rombel dosen pa

    $(".tambahProdiProg").click(function() {
        console.log(nilaiProdi, nilaiProgramKuliah);
        $.ajax({
            type: "POST",
            url: "/setMatkulDitawarkan/prodiProgramKuliah",
            data: {
                prodiAkademik: nilaiProdi,
                programKuliahAkademik: nilaiProgramKuliah,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                data += "<option value=''>Pilih Prodi Program Kuliah</option>";
                if (response.list_prodi_program_kuliah.length == 0) {
                    alert('Data Prodi Program Kuliah tidak ditemukan');
                    $(".prodiProgRombel").empty();
                    $(".prodiProgRombel").append(data);
                } else {
                    console.log(response.list_prodi_program_kuliah);
                    $(".prodiProgRombel").empty();
                    $(".prodiProgRombel").append(data, response.list_prodi_program_kuliah);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});

function detailMatkul(matkulKurikulumId) {
    $.ajax({
        type: "POST",
        url: "/setMatkulKurikulum/detail/" + matkulKurikulumId,
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            let html = ''
            response.forEach(data => {
                html += '<table class="table table-bordered table-responsive-md table-striped ">';
                html += '<tbody>';
                html += '<tr>';
                html += '<th>Mata Kuliah</th>';
                html += '<td>' + data.matkulKode + ' - ' + data.matkulNama + ' (' + data.matkulGroupKode + ') ' + data.setMatkulKurikulumSks + ' SKS' + '</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<th>Kurikulum</th>';
                html += '<td>' + data.kurikulumNama + '</td>';
                html += '</tr>';
                html += '<tr>';
                html += '<th>Studi Level</th>';
                html += '<td>' + data.studiLevelNama + '</td>';
                html += '</tr>';
                html += '</tbody>';
                html += '</table>';
            })
            $('[id="detailMatkul"]').modal('show');
            $('[id="data-matkul"]').empty();
            $('[id="data-matkul"]').append(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}