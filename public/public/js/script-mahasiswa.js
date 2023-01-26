window.addEventListener('DOMContentLoaded', (event) => {
    loadMahasiswa()
});

function loadMahasiswa() {
    cariMahasiswa($('#npmMahasiswa').text(), 'krs');
};

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
                $("div[id=dataMK]").empty();
                cariMkDitawarkan(response[0].mahasiswaNpm, response[0].mahasiswaKelasId);
                getSksAllowed(response[0].mahasiswaNpm)
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function cariMkDitawarkan(npm, kelas) {
    $.ajax({
        type: "POST",
        url: "/setMatkulDitawarkan/cari",
        data: {
            npm: npm,
            kelas: kelas
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            if (!response.status) {
                var layout = "";
                layout += '<div class="list-group-item">';
                layout += '<p class="mb-0" style="text-align:center ;">' + response.message + '</p>';
                layout += '</div>';
                $("#btnSimpan").empty();
            } else if (response.status == null) {
                var layout = "";
                layout += '<div class="list-group-item">';
                layout += '<p class="mb-0" style="text-align:center ;">' + response.message + '</p>';
                layout += '</div>';
                $("#btnSimpan").empty();
            } else {
                var btn = "";
                var layout = "";
                response.data.forEach(element => {
                    var tersedia = element.setMatkulTawarKuotaKelas - element.setMatkulTawarKelasTerpakai;
                    var stat = ((element.setMatkulTawarKuotaKelas - element.setMatkulTawarKelasTerpakai) > 0) ? '' : 'disabled';
                    layout += '<div class="list-group-item" onclick=checklistMk("' + element.setMatkulTawarId + '")>';
                    layout += '<div class="d-flex w-100 justify-content-between">';
                    layout += '<strong class="mb-0">' + element.matkulKode + " - " + element.matkulNama + " (" + element.kurikulumNama + ')</strong>';
                    layout += "<input type='checkbox' name='matkul[]' value='" + element.setMatkulTawarId + "' class='checkbox - input' id='mkditawarkan" + element.setMatkulTawarId + "' " + stat + ">";
                    layout += '</div>';
                    layout += '<p class="mb-0">Kelas : ' + element.kelasKode + " " + element.waktuNama + '</p>';
                    layout += '<small>Kuota :' + element.setMatkulTawarKuotaKelas + ' | Sisa :' + tersedia + ' | Sks :' + element.setMatkulKurikulumSks + '</small>';
                    layout += '</div>';
                });
                var btn = '<button type="submit" class="btn btn-primary float-right">Simpan</button>'
                $("#btnSimpan").append(btn);
            }
            $("div[id=dataMK]").append(layout);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function checklistMk(id) {
    if ($('#mkditawarkan' + id).is(":checked")) {
        $('#mkditawarkan' + id).prop('checked', false);
    } else {
        $('#mkditawarkan' + id).prop('checked', true);
    }
}

function getSksAllowed(npm) {
    $.ajax({
        type: "POST",
        url: "/khsMahasiswa/cari",
        data: {
            npm: npm
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            // console.log(response);
            if (response.length == 0) {
                sksAllow = 24;
                $(".sksMax").empty();
                $(".sksMax").append("Jumlah sks yang diizinkan adalah: <strong>" + sksAllow + "</strong>");
                // console.log(sksAllow);
            } else {
                var data = [];
                let sksAllowed = 0;
                let sksDefault = 0;
                response.forEach(element => {
                    JSON.parse(element.khsNilaiMatkul)['data'].forEach(val => {
                        data.push(val);
                    });
                    sksAllowed = element.sksAllowJson;
                    sksDefault = element.sksDefault;
                });
                // console.log(data);
                // var nilai = 0;
                // var sks = 0;
                // data.forEach(khs => {
                //     nilai = nilai + khs.totalNilai
                //     sks = sks + (khs.totalNilai / khs.nilai);
                //     // console.log((khs.totalNilai / khs.nilai));
                // });
                ipk = $('#ipk').text();
                let sksAllow = sksDefault;
                JSON.parse(sksAllowed)['data'][0]['detail'].forEach(sksA => {
                    if (ipk >= sksA.minIpk && ipk <= sksA.maxIpk) {
                        sksAllow = sksA.allow;
                    }
                });

                // console.log(ipk);
                $(".sksMax").empty();
                $(".sksMax").append("<strong>Informasi !!!</strong> Jumlah sks yang diizinkan di semester inii adalah: <strong>" + sksAllow + "</strong>");
                // console.log(sksAllow);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}


let judul;

function showModal(title) {
    judul = title;
    $('#modalMahasiswa' + title).modal('show');
}

function biayaLain() {
    $('#modalMahasiswa' + judul).modal('hide');
    $('#biayaLain').modal('show');
}

function backMainModal() {
    $('#modalMahasiswa' + judul).modal('show');
    $('#biayaLain').modal('hide');
}

function backMainModalAgree() {
    let id = [];
    $('.tagihanLain').each(function() {
        if ($(this).is(":checked")) {
            id.push($(this).val());
        }
    });
    id.forEach(element => {
        addTagihanLain($('#npmMahasiswa').text(), element, $('.jumlahTagihan' + element).val());
        // console.log($('.jumlahTagihan'+element).val());
    });

    $('#modalMahasiswa' + judul).modal('show');
    $('#biayaLain').modal('hide');
}

function ubahMetodeBayar(params) {
    let tahap = [];
    $('.itemtagih').each(function() {
        tahap.push($(this).data('tahap'));
    });
    console.log(params[1]);
    $.ajax({
        type: "POST",
        url: "/tagihan/ubahMetodeTagihan",
        data: {
            npm: params[0],
            ket: (params[1]) ? '1' : '0',
            id: params[2]
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            console.log(response);
            let grandTotal = 0;
            response['detail'].forEach(element => {
                if (jQuery.inArray(element.tahap, tahap)) {
                    if (params[1]) {
                        $('.itemtagih[data-tahap=' + element.tahap + ']').addClass("bg-primary");
                    } else if (!params[1]) {
                        if (element.forceToPay == '1') {
                            $('.itemtagih[data-tahap=' + element.tahap + ']').addClass("bg-primary");
                        } else {
                            $('.itemtagih[data-tahap=' + element.tahap + ']').removeClass("bg-primary");
                        }
                    }
                    $('.diskon[data-tahap=' + element.tahap + ']').text('Diskon :' + formatRupiah(element.diskon.toString(), 'Rp. '));
                }
            });

            $("#total").empty();
            $("#total").append(formatRupiah(response['total'].toString(), 'Rp. '));
            if (parseInt(response['dompet']) > 0) {
                $(".dompetMhs").removeAttr('style');
            } else {
                $(".dompetMhs").attr('style', 'display: none !important');
            }
            $("#dompet").empty();
            $("#dompet").append(formatRupiah(response['dompet'].toString(), 'Rp. '));


            grandTotal = response['total'] - response['dompet'];

            $("#grandTotal").empty();
            if (grandTotal < 0) {
                $("#grandTotal").append("-" + formatRupiah(grandTotal.toString(), 'Rp. '));
            } else {
                $("#grandTotal").append(formatRupiah(grandTotal.toString(), 'Rp. '));
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function addTagihanLain(npm, id, jumlah) {
    $.ajax({
        type: "POST",
        url: "/tagihanLain/add",
        data: {
            npm: npm,
            id: id,
            jumlah: jumlah,
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            console.log(response);
            let tanggalMulai = response.dataInsert['tagihLainTanggalMulai'];
            let tanggalSelesai = response.dataInsert['tagihLainTanggalSelesai'];
            let nominal = formatRupiah(response.dataInsert['tagihLainNominal'].toString(), 'Rp. ');
            let id = response.infoTagihan['tagihLainId'] + ',' + response.infoTagihan['tarifLainIncludeTahap'] + ',' + response.infoTagihan['refJenisBiayaId'];
            let dataIt = (new Date(tanggalSelesai.substring(0, 10)) > new Date()) ? 'data-id="' + id + '"' : "";

            let bg = (new Date(tanggalSelesai.substring(0, 10)) < new Date()) ? "bg-primary-light" : "";
            let cls = (new Date(tanggalSelesai.substring(0, 10)) < new Date()) ? "" : "itemtagih";
            let aktif = (new Date(tanggalSelesai.substring(0, 10)) > new Date() && response.dataInsert['tagihLainIsForceToPay'] == '1') ? "bg-primary" : "";
            let event = (new Date(tanggalSelesai.substring(0, 10)) < new Date()) ? "" : "onclick=ubahTagihan('" + id.toString() + "')";


            // cek error split
            if (response.status) {
                var layout = "";
                layout += '<div class="list-group-item ' + bg + ' ' + cls + ' ' + aktif + '" ' + dataIt + ' data-tahap=' + response.infoTagihan['tarifLainIncludeTahap'] + ' ' + event + '>';
                layout += '<div class="d-flex w-100 justify-content-between">';
                layout += '<strong class="mb-0">' + response.infoTagihan['refJenisBiayaNama'] + '</strong>';
                layout += '<small>' + tanggalMulai.substring(0, 10) + ' s/d ' + tanggalSelesai.substring(0, 10) + '</small>';
                layout += '</div>';
                layout += '<p class="mb-0">' + nominal + '</p>';
                layout += '<small>Diskon : ' + formatRupiah(response.dataInsert['tagihLainDiskon'].toString(), 'Rp. ') + '</small>';
                layout += '</div>';
                $("div.list-group.tagihanList").append(layout);
                $("#total").empty();
                $("#total").append(formatRupiah(response['total'].toString(), 'Rp. '));

                let grandTotal = response['total'] - response['saldoDompet'];

                $("#grandTotal").empty();
                if (grandTotal < 0) {
                    $("#grandTotal").append("-" + formatRupiah(grandTotal.toString(), 'Rp. '));
                } else {
                    $("#grandTotal").append(formatRupiah(grandTotal.toString(), 'Rp. '));
                }
            } else {
                console.log(response.message);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function ubahTagihan(id) {
    let ket = '';
    let classList = $('div[data-id="' + id + '"]').attr('class').split(/\s+/);
    console.log(classList);

    if (jQuery.inArray("bg-primary", classList) !== -1) {
        ket = '0';
    } else {
        ket = '1';
    }

    if (!$('input[name=metodeBayar]').is(":checked")) {
        $.LoadingOverlay("show");
        if ($('div[data-id="' + id + '"]').data("id").split(',')[2] == 3 || $('div[data-id="' + id + '"]').data("id").split(',')[2] == 2) {
            sendDataTagihan([$('div[data-id="' + id + '"]').data("id").split(',')[0], $('div[data-id="' + id + '"]').data("id").split(',')[1]], ket, $('div[data-id="' + id + '"]'), 'tahap');
        } else if ($('div[data-id="' + id + '"]').data("id").split(',')[2] == 25) {
            sendDataTagihanHer([$('div[data-id="' + id + '"]').data("id").split(',')[0], $('div[data-id="' + id + '"]').data("id").split(',')[1]], ket, $('div[data-id="' + id + '"]'), 'tahap');
        } else {
            sendDataTagihanLain($('div[data-id="' + id + '"]').data("id").split(',')[0], ket, $('div[data-id="' + id + '"]'), 'tahap');
        }
    } else {
        alert("Anda dalam Metode Bayar Lunas, silahkan ubah Metode pembayaran!!");
    }
}

function sendDataTagihanLain(id, ket, element) {
    $.ajax({
        type: "POST",
        url: "/tagihan/ubahTagihanLain",
        data: {
            id: id,
            ket: ket,
            from: 'mahasiswa',
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function (response) {
            $.LoadingOverlay("hide");
            console.log(response);
            if (response['data'] == '0') {
                element.removeClass("bg-primary");
            } else {
                element.addClass("bg-primary");
            }
            $("#total").empty();
            $("#total").append(formatRupiah(response['total'].toString(), 'Rp. '));
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function sendDataTagihan(path, ket, element, action) {
    $.ajax({
        type: "POST",
        url: "/tagihan/ubahTagihan",
        data: {
            id: path[0],
            tahap: path[1],
            ket: ket,
            from: 'mahasiswa',
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function (response) {
            $.LoadingOverlay("hide");
            let grandTotal = 0;
            if (response['data'] == '0') {
                element.removeClass("bg-primary");
            } else {
                element.addClass("bg-primary");
            }
            $("#total").empty();
            $("#total").append(formatRupiah(response['total'].toString(), 'Rp. '));

            grandTotal = response['total'] - response['dompet'];

            $("#grandTotal").empty();
            if (grandTotal < 0) {
                $("#grandTotal").append("-" + formatRupiah(grandTotal.toString(), 'Rp. '));
            } else {
                $("#grandTotal").append(formatRupiah(grandTotal.toString(), 'Rp. '));
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });

}

function sendDataTagihanHer(path, ket, element, action) {
    $.ajax({
        type: "POST",
        url: "/tagihan/ubahTagihanHer",
        data: {
            id: path[0],
            tahap: path[1],
            ket: ket,
            from: 'mahasiswa',
            npm: $('#npmMahasiswa').text()
        },
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function (response) {
            $.LoadingOverlay("hide");
            let grandTotal = 0;
            if (response['data'] == '0') {
                element.removeClass("bg-primary");
            } else {
                element.addClass("bg-primary");
            }
            $("#total").empty();
            $("#total").append(formatRupiah(response['total'].toString(), 'Rp. '));

            grandTotal = response['total'] - response['dompet'];

            $("#grandTotal").empty();
            if (grandTotal < 0) {
                $("#grandTotal").append("-" + formatRupiah(grandTotal.toString(), 'Rp. '));
            } else {
                $("#grandTotal").append(formatRupiah(grandTotal.toString(), 'Rp. '));
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });

}

function ubahMetodePembayaran() {
    ubahMetodeBayar([$('#npmMahasiswa').text(), $('input[name=metodeBayar]').is(":checked"), $('input[name=metodeBayar]').data('id')]);
}

PullToRefresh.init({
    mainElement: 'div.container',
    onRefresh: function() { window.location.reload(); }
});