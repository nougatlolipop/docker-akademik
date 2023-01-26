// cari dosen matkul tawar

function cariDosenMatkulTawar(matkulTawarId, dosenId, prodiId) {
    let cariDosen = $('[name="cariDosen' + matkulTawarId + '"]').val()
    $.ajax({
        url: "/setDosenProdi/cari",
        type: "POST",
        data: {
            dosenId: dosenId,
            prodiId: prodiId,
            cariDosen: cariDosen,
        },
        success: function(response) {
            var data = "";
            var btn = "";
            var alert = "";
            if (response.length > 2 && response != 'null') {
                JSON.parse(response).forEach(dosen => {
                    data += "<tr>";
                    data += "<td style='text-align:center'><div class='custom-control custom-checkbox'><input name='dosen[]' value='" + dosen.dosenId + "' type='checkbox' class='custom-control-input' id='customCheckDosen" + dosen.dosenId + matkulTawarId + "'><label class='custom-control-label' for='customCheckDosen" + dosen.dosenId + matkulTawarId + "'></label></div></td>";
                    data += "<td>" + ((dosen.dosenGelarDepan == null) ? " " : dosen.dosenGelarDepan) + " " + dosen.dosenNama + " " + dosen.dosenGelarBelakang + "</td>"
                    data += "</tr>";
                });
                btn += "<button type='button' class='btn btn-sm btn-primary' id='tambahDosen" + matkulTawarId + "' onclick='insertDosenMatkulTawar(" + matkulTawarId + "," + "`" + dosenId + "`" + ")'>Tambah</button>"
                if (JSON.parse(response).length >= 25) {
                    alert += "<div class='alert alert-warning' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data dosen terlalu banyak, gunakan keyword yang lebih detail!</div></div>"
                }
            } else if (response == 'null') {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' >Masukkan keyword terlebih dahulu</td>";
                data += "</tr>";
            } else {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' class='text-danger'>Data dosen tidak ditemukan</td>";
                data += "</tr>";
            }
            $('[id="alertDosen' + matkulTawarId + '"]').empty();
            $('[id="alertDosen' + matkulTawarId + '"]').append(alert);
            $('[id="tambahDosen' + matkulTawarId + '"]').empty();
            $('[id="tambahDosen' + matkulTawarId + '"]').append(btn);
            $('[id="pilihDosen' + matkulTawarId + '"]').empty();
            $('[id="pilihDosen' + matkulTawarId + '"]').append(data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
}

// insert dosen matkul tawar

function insertDosenMatkulTawar(matkulTawarId, dosenOld) {
    let email = $('[name="sessionEmail"]').val();
    let dosenNew = [];
    $.each($("input[name='dosen[]']:checked"), function() {
        dosenNew.push($(this).val());
    });
    console.log(matkulTawarId, dosenOld, dosenNew);
    if (dosenNew.length == 0) {
        alert('Pilih dosen terlebih dahulu!')
    } else {
        $.ajax({
            type: "POST",
            url: "/setMatkulDitawarkan/tambahDosen/" + matkulTawarId,
            data: {
                matkulTawarId: matkulTawarId,
                dosenOld: dosenOld,
                dosenNew: dosenNew,
                email: email,
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
                window.location.reload(true);
                if (response == 1) {
                    data += "<div class='alert alert-success' role='alert'><div class='iq-alert-icon'><i class='ri-check-line'></i></div><div class='iq-alert-text'>Data Dosen Berhasil Dimasukkan!</div></div>"
                } else {
                    data += "<div class='alert alert-danger' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data Dosen Gagal Dimasukkan!</div></div>"
                }
                $("#alert").empty();
                $("#alert").append(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
}

// delete dosen matkul tawar

function deleteDosenMatkulTawar(matkulTawarId, dosenOld) {
    let email = $('[name="sessionEmail"]').val();
    let dosenNew = [];
    $.each($("input[name='hapusDosen[]']:checked"), function() {
        dosenNew.push($(this).val());
    });
    if (dosenNew.length == 0) {
        alert('Pilih dosen terlebih dahulu!')
    } else {
        $.ajax({
            type: "POST",
            url: "/setMatkulDitawarkan/hapusDosen/" + matkulTawarId,
            data: {
                matkulTawarId: matkulTawarId,
                dosenOld: dosenOld,
                dosenNew: dosenNew,
                email: email,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                window.location.reload(true);
                if (response == 1) {
                    data += "<div class='alert alert-success' role='alert'><div class='iq-alert-icon'><i class='ri-check-line'></i></div><div class='iq-alert-text'>Data Dosen Berhasil Dihapus!</div></div>"
                } else {
                    data += "<div class='alert alert-danger' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data Dosen Gagal Dihapus!</div></div>"
                }
                $("#alert").empty();
                $("#alert").append(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
}

// cari dosen prodi

function cariDosenProdi(prodiId) {
    let cariDosen = $('[name="cariDsnPrd"]').val()
    $.ajax({
        url: "/dosen/cari",
        type: "POST",
        data: {
            prodiId: prodiId,
            cariDosen: cariDosen,
        },
        success: function(response) {
            var data = "";
            var btn = "";
            var alert = "";
            if (response.length > 2 && response != 'null') {
                JSON.parse(response).forEach(dosen => {
                    data += "<tr>";
                    data += "<td style='text-align:center'><div class='custom-control custom-checkbox'><input name='dosen[]' value='" + dosen.dosenId + "' type='checkbox' class='custom-control-input' id='customCheckDosen" + dosen.dosenId + "'><label class='custom-control-label' for='customCheckDosen" + dosen.dosenId + "'></label></div></td>";
                    data += "<td>" + ((dosen.dosenGelarDepan == null) ? " " : dosen.dosenGelarDepan) + " " + dosen.dosenNama + " " + dosen.dosenGelarBelakang + "</td>"
                    data += "</tr>";
                });
                btn += "<button type='button' class='btn btn-sm btn-secondary' data-dismiss='modal'>Tutup</button>"
                btn += "<button type='button' class='btn btn-sm btn-primary' onClick='insertDosenProdi(" + prodiId + ")'>Simpan</button>"
                if (JSON.parse(response).length >= 25) {
                    alert += "<div class='alert alert-warning' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data dosen terlalu banyak, gunakan keyword yang lebih detail!</div></div>"
                }
            } else if (response == 'null') {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' >Masukkan keyword terlebih dahulu</td>";
                data += "</tr>";
                btn += "<button type='button' class='btn btn-sm btn-secondary' data-dismiss='modal'>Tutup</button>"
            } else {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' class='text-danger'>Data dosen tidak ditemukan</td>";
                data += "</tr>";
                btn += "<button type='button' class='btn btn-sm btn-secondary' data-dismiss='modal'>Tutup</button>"
            }
            $("#alertDosen").empty();
            $("#alertDosen").append(alert);
            $("#tambahDsnPrd").empty();
            $("#tambahDsnPrd").append(btn);
            $("#pilihDsnPrd").empty();
            $("#pilihDsnPrd").append(data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
}

// insert dosen prodi

function insertDosenProdi(prodiId) {
    let email = $('[name="sessionEmail"]').val();
    let dosenId = [];
    $.each($("input[name='dosen[]']:checked"), function() {
        dosenId.push($(this).val());
    });
    if (dosenId.length == 0) {
        alert('Pilih dosen terlebih dahulu!')
    } else {
        $.ajax({
            type: "POST",
            url: "/setDosenProdi/tambah",
            data: {
                prodiId: prodiId,
                dosenId: dosenId,
                email: email,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                window.location.reload(true);
                if (response == 1) {
                    data += "<div class='alert alert-success' role='alert'><div class='iq-alert-icon'><i class='ri-check-line'></i></div><div class='iq-alert-text'>Data Dosen Prodi Berhasil Ditambahkan!</div></div>"
                } else {
                    data += "<div class='alert alert-danger' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data Dosen Prodi Gagal Ditambahkan!</div></div>"
                }
                $("#alert").empty();
                $("#alert").append(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
}

// cari pimpinan fakultas

function cariDsnFakultas(fakultasId, fakultasKode) {
    let cariDosen = $('[name="cariDsnFakultas' + fakultasId + '"]').val()
    console.log(fakultasId, cariDosen);
    $.ajax({
        url: "/dosen/cari/fakultas",
        type: "POST",
        data: {
            fakultasId: fakultasId,
            cariDosen: cariDosen,
        },
        success: function(response) {
            var data = "";
            var btn = "";
            var alert = "";
            if (response.length > 2 && response != 'null') {
                JSON.parse(response).forEach(dosen => {
                    data += "<tr>";
                    data += "<td style='text-align:center'><div class='custom-control custom-radio'><input name='dosen' value='" + dosen.dosenId + "' type='radio' class='custom-control-input' id='customCheckDosen" + dosen.dosenId + fakultasId + "'><label class='custom-control-label' for='customCheckDosen" + dosen.dosenId + fakultasId + "'></label></div></td>";
                    data += "<td>" + ((dosen.dosenGelarDepan == null) ? " " : dosen.dosenGelarDepan) + " " + dosen.dosenNama + " " + dosen.dosenGelarBelakang + "</td>";
                    data += "<td><select class='form-control' name='jabatan" + dosen.dosenId + fakultasId + "'><option value=''>Pilih Jabatan</option>"
                    if (fakultasKode == '20') {
                        data += "<option value='dekan'>Direktur</option>"
                        data += "<option value='wdI'>Wakil Direktur</option>"
                    } else {
                        data += "<option value='dekan'>Dekan</option>"
                        data += "<option value='wdI'>Wakil Dekan I</option>"
                        data += "<option value='wdIII'>Wakil Dekan III</option>"
                    }
                    data += "</select></td>"
                    data += "</tr>";
                });
                btn += "<button type='button' class='btn btn-sm btn-primary' id='updateDsnFakultas" + fakultasId + "' onclick='updateDsnFakultas(" + fakultasId + ")'>Perbarui</button>"
                if (JSON.parse(response).length >= 25) {
                    alert += "<div class='alert alert-warning' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data dosen terlalu banyak, gunakan keyword yang lebih detail!</div></div>"
                }
            } else if (response == 'null') {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' >Masukkan keyword terlebih dahulu</td>";
                data += "</tr>";
            } else {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' class='text-danger'>Data dosen tidak ditemukan</td>";
                data += "</tr>";
            }
            $('[id="alertDsnFakultas' + fakultasId + '"]').empty();
            $('[id="alertDsnFakultas' + fakultasId + '"]').append(alert);
            $('[id="updateDsnFakultas' + fakultasId + '"]').empty();
            $('[id="updateDsnFakultas' + fakultasId + '"]').append(btn);
            $('[id="pilihDsnFakultas' + fakultasId + '"]').empty();
            $('[id="pilihDsnFakultas' + fakultasId + '"]').append(data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
}

// update pimpinan fakultas

function updateDsnFakultas(fakultasId) {
    let email = $('[name="sessionEmail"]').val();
    let dosenId = $("input[name='dosen']:checked").val()
    let jabatan = $('[name="jabatan' + dosenId + fakultasId + '"]').val()
    if (dosenId == null || jabatan == null) {
        alert('Pilih dosen atau jabatan terlebih dahulu!')
    } else {
        $.ajax({
            type: "POST",
            url: "/fakultas/dosen/" + fakultasId,
            data: {
                email: email,
                dosenId: dosenId,
                jabatan: jabatan,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                window.location.reload(true);
                if (response == 1) {
                    data += "<div class='alert alert-success' role='alert'><div class='iq-alert-icon'><i class='ri-check-line'></i></div><div class='iq-alert-text'>Data Fakultas Berhasil Diupdate!</div></div>"
                } else {
                    data += "<div class='alert alert-danger' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data Fakultas Gagal Diupdate!</div></div>"
                }
                $("#alert").empty();
                $("#alert").append(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
}

// cari pimpinan prodi

function cariDsnProdi(prodiId) {
    let cariDosen = $('[name="cariDsnProdi' + prodiId + '"]').val()
    console.log(prodiId, cariDosen);
    $.ajax({
        url: "/dosen/cari/prodi",
        type: "POST",
        data: {
            prodiId: prodiId,
            cariDosen: cariDosen,
        },
        success: function(response) {
            var data = "";
            var btn = "";
            var alert = "";
            if (response.length > 2 && response != 'null') {
                JSON.parse(response).forEach(dosen => {
                    data += "<tr>";
                    data += "<td style='text-align:center'><div class='custom-control custom-radio'><input name='dosen' value='" + dosen.dosenId + "' type='radio' class='custom-control-input' id='customCheckDosen" + dosen.dosenId + prodiId + "'><label class='custom-control-label' for='customCheckDosen" + dosen.dosenId + prodiId + "'></label></div></td>";
                    data += "<td>" + ((dosen.dosenGelarDepan == null) ? " " : dosen.dosenGelarDepan) + " " + dosen.dosenNama + " " + dosen.dosenGelarBelakang + "</td>";
                    data += "<td><select class='form-control' name='jabatan" + dosen.dosenId + prodiId + "'><option value=''>Pilih Jabatan</option>"
                    data += "<option value='ketua'>Ketua</option>"
                    data += "<option value='sekre'>Sekretaris</option>"
                    data += "</select></td>"
                    data += "</tr>";
                });
                btn += "<button type='button' class='btn btn-sm btn-primary' id='updateDsnProdi" + prodiId + "' onclick='updateDsnProdi(" + prodiId + ")'>Perbarui</button>"
                if (JSON.parse(response).length >= 25) {
                    alert += "<div class='alert alert-warning' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data dosen terlalu banyak, gunakan keyword yang lebih detail!</div></div>"
                }
            } else if (response == 'null') {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' >Masukkan keyword terlebih dahulu</td>";
                data += "</tr>";
            } else {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' class='text-danger'>Data dosen tidak ditemukan</td>";
                data += "</tr>";
            }
            $('[id="alertDsnProdi' + prodiId + '"]').empty();
            $('[id="alertDsnProdi' + prodiId + '"]').append(alert);
            $('[id="updateDsnProdi' + prodiId + '"]').empty();
            $('[id="updateDsnProdi' + prodiId + '"]').append(btn);
            $('[id="pilihDsnProdi' + prodiId + '"]').empty();
            $('[id="pilihDsnProdi' + prodiId + '"]').append(data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
}

// update pimpinan prodi

function updateDsnProdi(prodiId) {
    let email = $('[name="sessionEmail"]').val();
    let dosenId = $("input[name='dosen']:checked").val()
    let jabatan = $('[name="jabatan' + dosenId + prodiId + '"]').val()
    if (dosenId == null || jabatan == null) {
        alert('Pilih dosen atau jabatan terlebih dahulu!')
    } else {
        $.ajax({
            type: "POST",
            url: "/prodi/dosen/" + prodiId,
            data: {
                email: email,
                dosenId: dosenId,
                jabatan: jabatan,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                window.location.reload(true);
                if (response == 1) {
                    data += "<div class='alert alert-success' role='alert'><div class='iq-alert-icon'><i class='ri-check-line'></i></div><div class='iq-alert-text'>Data Prodi Berhasil Diupdate!</div></div>"
                } else {
                    data += "<div class='alert alert-danger' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data Prodi Gagal Diupdate!</div></div>"
                }
                $("#alert").empty();
                $("#alert").append(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
}

// cari dosen set rombel dosen pa

function cariSetRombel(setRombelId, prodiProgramId, dosenOld) {
    let cariDosen = $('[name="cariSetRombel' + setRombelId + '"]').val()
    $.ajax({
        url: "/setDosenProdi/cari/dosenPa",
        type: "POST",
        data: {
            prodiProgramId: prodiProgramId,
            dosenOld: dosenOld,
            cariDosen: cariDosen,
        },
        success: function(response) {
            var data = "";
            var btn = "";
            var alert = "";
            if (response.length > 2 && response != 'null') {
                JSON.parse(response).forEach(dosen => {
                    data += "<tr>";
                    data += "<td style='text-align:center'><div class='custom-control custom-radio'><input name='dosen' value='" + dosen.dosenId + "' type='radio' class='custom-control-input' id='customCheckDosen" + dosen.dosenId + setRombelId + "'><label class='custom-control-label' for='customCheckDosen" + dosen.dosenId + setRombelId + "'></label></div></td>";
                    data += "<td>" + ((dosen.dosenGelarDepan == null) ? " " : dosen.dosenGelarDepan) + " " + dosen.dosenNama + " " + dosen.dosenGelarBelakang + "</td>";
                    data += "</tr>";
                });
                btn += "<button type='button' class='btn btn-sm btn-primary' id='updateSetRombel" + setRombelId + "' onclick='updateSetRombel(" + setRombelId + ")'>Perbarui</button>"
                if (JSON.parse(response).length >= 25) {
                    alert += "<div class='alert alert-warning' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data dosen terlalu banyak, gunakan keyword yang lebih detail!</div></div>"
                }
            } else if (response == 'null') {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' >Masukkan keyword terlebih dahulu</td>";
                data += "</tr>";
            } else {
                data += "<tr>";
                data += "<td style='text-align:center' colspan='2' class='text-danger'>Data dosen tidak ditemukan</td>";
                data += "</tr>";
            }
            $('[id="alertSetRombel' + setRombelId + '"]').empty();
            $('[id="alertSetRombel' + setRombelId + '"]').append(alert);
            $('[id="updateSetRombel' + setRombelId + '"]').empty();
            $('[id="updateSetRombel' + setRombelId + '"]').append(btn);
            $('[id="pilihSetRombel' + setRombelId + '"]').empty();
            $('[id="pilihSetRombel' + setRombelId + '"]').append(data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    })
}

// update dosen set rombel dosen pa

function updateSetRombel(setRombelId) {
    let email = $('[name="sessionEmail"]').val();
    let dosenId = $("input[name='dosen']:checked").val()
    if (dosenId == null) {
        alert('Pilih dosen terlebih dahulu!')
    } else {
        $.ajax({
            type: "POST",
            url: "/setRombel/dosen/" + setRombelId,
            data: {
                email: email,
                dosenId: dosenId,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                var data = "";
                window.location.reload(true);
                if (response == 1) {
                    data += "<div class='alert alert-success' role='alert'><div class='iq-alert-icon'><i class='ri-check-line'></i></div><div class='iq-alert-text'>Data Dosen PA Berhasil Diupdate!</div></div>"
                } else {
                    data += "<div class='alert alert-danger' role='alert'><div class='iq-alert-icon'><i class='ri-alert-line'></i></div><div class='iq-alert-text'>Data Dosen PA Gagal Diupdate!</div></div>"
                }
                $("#alert").empty();
                $("#alert").append(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
}

function check() {
    console.log($(this));
    let keycode = ($(this).keyCode ? $(this).keyCode : $(this).which);
    if (keycode == '13') {
        alert('You pressed enter!');
    }
}