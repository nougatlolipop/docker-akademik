$(document).ready(function() {
    let klikPertama = false;
    let urut = 1;
    let prodi;
    let programKuliah;
    let kurikulumTawar;
    let kelas;
    let waktuKuliah;

    $("#tambahRule").click(function() {
        console.log('tambahRule');

        var data = "";
        data += "<tr>";
        data += "<td><input type='type' class='form-control' name='minIpk[]'></td>";
        data += "<td><input type='type' class='form-control' name='maxIpk[]'></td>";
        data += "<td><input type='type' class='form-control' name='allow[]'></td>";
        data += "</tr>";
        if (!klikPertama) {
            $('#sks').empty();
            klikPertama = true;
        }
        $('#sks').append(data);
    });

    $("#btnTambahMk").click(function() {
        urut++;
        var data = "";
        data += "<tr>";
        data += "<td style='text-align:center';><input type='checkbox' name='record'></td>";
        data += "<td><input type='type' class='form-control' name='kode[]'></td>";
        data += "<td><input type='type' class='form-control' name='nama[]'></td>";
        data += "<td><input type='type' class='form-control' name='sks[]'></td>";
        data += "<td><div class='input-group'><input type='hidden' class='form-control' id='nilaiLamaSave" + urut + "' aria-describedby='basic-addon2' name='nilaiLamaSave[]' readonly><input type='text' class='form-control' id='nilaiLama" + urut + "' aria-describedby='basic-addon2' name='nilaiLama[]' readonly><div class='input-group-append'><button class='btn btn-outline-secondary' type='button' onclick='btnCariNilaiLama(" + urut + ")'><span class='las la-search' name='btnCariNilai'></span></button></div></div></td>";
        data += "<td>-</td>";
        data += "<td><div class='input-group'><input type='hidden' class='form-control' id='mkKonversiSave" + urut + "' aria-describedby='basic-addon2' name='mkKonversiSave[]' readonly><input type='text' class='form-control' id='mkKonversi" + urut + "' aria-describedby='basic-addon2' name='mkKonversi[]' readonly><div class='input-group-append'><button class='btn btn-outline-secondary' type='button' onclick='btnCariMkKonversi(" + urut + ")'><span class='las la-search' ></span></button></div></div></td>";
        data += "<td><div class='input-group'><input type='hidden' class='form-control' id='nilaiSave" + urut + "' aria-describedby='basic-addon2' name='nilaiSave[]' readonly><input type='text' class='form-control' id='nilai" + urut + "' aria-describedby='basic-addon2' name='nilai[]' readonly><div class='input-group-append'><button class='btn btn-outline-secondary' type='button' onclick='btnCariNilai(" + urut + ")'><span class='las la-search' name='btnCariNilai'></span></button></div></div></td>";

        data += "</tr>";
        $('#namaMk').append(data);
    });


    $("#hapus").click(function() {
        $("#namaMk").find('input[name="record"]').each(function() {
            if ($(this).is(":checked")) {
                $(this).parents("tr").remove();
            }
        });
    });

    $("input[name=npmKonversi]").keyup(function(e) {
        if (e.keyCode == 13) {
            cariMahasiswa($(this).val(), 'konversi');
        }
    });

    $("[name=btnCariKonversi]").click(function(e) {
        cariMahasiswa($("input[name=npmKonversi]").val(), 'konversi');
    });

    $("input[name=npmMbkm]").keyup(function(e) {
        if (e.keyCode == 13) {
            cariMahasiswa($(this).val(), 'mbkm');
        }
    });

    $("[name=btnCariMbkm]").click(function(e) {
        cariMahasiswa($("input[name=npmMbkm]").val(), 'mbkm');
    });

    function cariMahasiswa(npm, type) {
        $.ajax({
            type: "POST",
            url: "/mahasiswa/cari",
            data: {
                npm: npm,
                type: type,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                if (response.length == 0) {
                    alert("Data tidak ditemukan");
                } else {
                    if (type == 'konversi') {
                        $("input[name=namaLengkapKonversi]").val(response[0].mahasiswaNamaLengkap);
                        prodi = response[0].setProdiProgramKuliahProdiId;
                        programKuliah = response[0].setProdiProgramKuliahProgramKuliahId;
                        kelas = response[0].mahasiswaKelasId;
                        waktuKuliah = response[0].setProdiProgramKuliahWaktuKuliahId
                        cariKurikulum([prodi, programKuliah]);
                    } else if (type == 'mbkm') {
                        $("input[name=namaLengkapKonversi]").val(response[0].mahasiswaNamaLengkap);
                        prodi = response[0].setProdiProgramKuliahProdiId;
                        programKuliah = response[0].setProdiProgramKuliahProgramKuliahId;
                        kelas = response[0].mahasiswaKelasId;
                        waktuKuliah = response[0].setProdiProgramKuliahWaktuKuliahId
                        cariKrs([npm]);
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function cariKurikulum(data) {
        console.log(data);
        $.ajax({
            type: "POST",
            url: "mahasiswa/kurikulum",
            data: {
                prodi: data[0],
                programKuliah: data[1]
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
                response.forEach(element => {
                    data += "<option value='" + element.setKurikulumTawarId + "'>" + element.kurikulumNama + " - " + element.setKurikulumTawarAngkatan + "</option>";
                });
                $("[name=kurikulumKonversi]").empty();
                $("[name=kurikulumKonversi]").append(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function cariKrs(data) {
        console.log(data);
        $.ajax({
            type: "POST",
            url: "krsMahasiswa/krsMahasiswa",
            data: {
                npm: data[0],
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                console.log(response);
                var data = "";
                response.forEach(element => {
                    data += "<tr>";
                    data += "<td style='text-align:center'><input type='radio' name='matkul' value='" + element.matkulId + "' data-text = '" + element.kode + " - " + element.nama + "' ></td>";
                    data += "<td>" + element.kode + "</td>";
                    data += "<td>" + element.nama + "</td>";
                    data += "<td>" + element.sks + "</td>";
                    data += "</tr>";
                });
                $("#matkulKonversi").empty();
                $("#matkulKonversi").append(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $("[name=kurikulumKonversi]").change(function(e) {
        kurikulumTawar = $(this).val();
        $.ajax({
            type: "POST",
            url: "mahasiswa/matkul",
            data: {
                prodi: prodi,
                programKuliah: programKuliah,
                kurikulum: kurikulumTawar,
                kelas: kelas,
                waktuKuliah: waktuKuliah
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                console.log(response);
                var data = "";
                if (response.length == 0) {
                    data += "<tr>";
                    data += "<td style='text-align:center' colspan='4'>Mata kuliah belum ditawarkan</td>";
                    data += "</tr>";
                } else {
                    response.forEach(element => {
                        data += "<tr>";
                        data += "<td style='text-align:center'><input type='radio' name='matkul' value='" + element.setMatkulTawarId + "' data-text = '" + element.matkulKode + " - " + element.matkulNama + "'></td>";
                        data += "<td>" + element.matkulKode + "</td>";
                        data += "<td>" + element.matkulNama + "</td>";
                        data += "<td>" + element.setMatkulKurikulumSks + "</td>";
                        data += "</tr>";
                    });
                }
                $("#matkulKonversi").empty();
                $("#matkulKonversi").append(data);
            }
        });
    });

});

let urutNilai;
let isNew = false;

function btnCariNilai(urut) {
    isNew = true;
    modalNilai(urut);
}

function btnCariNilaiLama(urut) {
    isNew = false;
    modalNilai(urut);
}

function btnCariMkKonversi(urut) {
    modalMatkul(urut);
}

function modalNilai(urut) {
    $("#cariNilai").modal('show');
    urutNilai = 0;
    urutNilai = urut;

}

function modalMatkul(urut) {
    $("#cariMatkul").modal('show');
    urutNilai = 0;
    urutNilai = urut;
}

function setNilai() {
    if (isNew) {
        $("#nilaiInput").find('input[name="pilihNilai"]').each(function() {
            if ($(this).is(":checked")) {
                document.getElementById("nilaiSave" + urutNilai).value = $(this).val();
                document.getElementById("nilai" + urutNilai).value = $(this).data("text");
                $("#cariNilai").modal('hide');
            }
        });
    } else {
        $("#nilaiInput").find('input[name="pilihNilai"]').each(function() {
            if ($(this).is(":checked")) {
                document.getElementById("nilaiLamaSave" + urutNilai).value = $(this).val();
                document.getElementById("nilaiLama" + urutNilai).value = $(this).data("text");
                $("#cariNilai").modal('hide');
            }
        });
    }
}

function setMatkul() {
    $("#matkulKonversi").find('input[name="matkul"]').each(function() {
        if ($(this).is(":checked")) {
            document.getElementById("mkKonversiSave" + urutNilai).value = $(this).val();
            document.getElementById("mkKonversi" + urutNilai).value = $(this).data("text");
            $("#cariMatkul").modal('hide');
            // console.log($(this).val(), urutNilai);
        }
    });
}

function sync() {
    document.getElementById("sync").submit();
}

function syncMbkm() {
    document.getElementById("syncMbkm").submit();
}

function loadMahasiswa(matkulTawarId, where) {
    // console.log(matkulTawarId, where);
    $("#isiNilai").modal('show');
    $.ajax({
        type: "POST",
        url: "/khsKelas/getTakenKrs",
        data: {
            matkulTawarId: matkulTawarId,
            where: where,
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            console.log(response);
            var data = "";
            var no = 0;

            if (response.length > 0) {
                response.forEach(element => {
                    no++;
                    data += "<tr>";
                    data += "<td style='text-align:center'>" + no + "</td>";
                    data += "<td>" + element.mahasiswaNpm + "</td>";
                    data += "<td>" + element.mahasiswaNamaLengkap + "</td>";
                    element.formNilai.forEach(nilai => {
                        let cek = (element.nilai == nilai.gradeNilaiId) ? 'checked' : '';
                        data += "<td style='text-align:center'><input type='radio' name='npm[" + element.mahasiswaNpm + "]' value='" + nilai.gradeNilaiId + "' " + cek + "></td>";
                    });
                    data += "</tr>";
                });
                $('#mkKelas').empty();
                $('#mkKelas').append(response[0].matkulNama);
                $('input[name=tahunAjaran]').val(response[0].tahunAjar);
                $('input[name=matkulId]').val(response[0].matkulTawarId);
            } else {
                $('#mkKelas').empty();
                $('input[name=tahunAjaran]').val('');
                $('input[name=matkulId]').val('');
                data += "<tr>";
                data += "<td style='text-align:center'colspan='12'>Data Mahasiswa Tidak Ditemukan</td>";
                data += "<tr>";
            }
            $('#mhsDitawarkan').empty();
            $('#mhsDitawarkan').append(data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function getNilai() {
    $.ajax({
        type: "GET",
        url: "/khsKelas/getNilai",
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            console.log(response);
            // return response;
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}