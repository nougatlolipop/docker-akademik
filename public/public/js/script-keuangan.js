$(document).ready(function() {

    let myUrl = "";
    $('#selectAll').click(function() {
        let checkedStatus = $(this).is(':checked') ? true : false;
        $('.checkitem').each(function() {
            $('.checkitem').prop('checked', checkedStatus);
        });

    });

    $('#hitung').click(function() {
        let data = [];
        $('.checkitem').each(function() {
            if ($(this).is(":checked")) {
                data.push(JSON.parse($(this).val()).map(i => Number(i)))
            }
        });
        console.log(data);
        // sendData(data);
    })


    $('#formulirhitung').submit(function() { //listen for submit event
        let data = [];
        $('.checkitem').each(function() {
            if ($(this).is(":checked")) {
                data.push(JSON.parse($(this).val()).map(i => Number(i)))
            }
        });
        console.log(data);

        var input = $("<input>")
            .attr("type", "hidden")
            .attr("name", "datappk").val(JSON.stringify(data));


        $('.formhitung').append($(input));
    });

    $('#btnMdlHitung').click(function() {
        let data = [];
        let prodi = [];
        let isHer = [];
        let dataher = [];
        $('.checkitem').each(function() {
            if ($(this).is(":checked")) {
                dataher.push(JSON.stringify($(this).data('her')));
                isHer.push($(this).data('isher'));
                data.push($(this).data('jlhtahap'));
                prodi.push($(this).data('prodi'));
            }
        });
        let uniqueData = [...new Set(data)];
        let uniqueProdi = [...new Set(prodi)];
        // console.log(uniqueData);
        // console.log(uniqueProdi);

        if (uniqueProdi.length == 1 && uniqueData.length == 1) {
            let alert = '';
            alert += '<div class="alert alert-warning" role="alert">';
            alert += '<div class="iq-alert-icon">';
            alert += '<i class="ri-alert-line"></i>';
            alert += '</div>';
            alert += '<div class="iq-alert-text">Silahkan pilih tahun tagihan, tagihan yang akan tersetting akan otomatis menghitung tagihan mahasiswa per satu tahun</div>';
            alert += '</div>';

            let her = ''
            if (isHer[0] == '1') {
                JSON.parse(dataher[0]).forEach((element, i) => {
                    her += '<tr>';
                    her += '<td style="text-align:center"><input type="hidden" class="form-control" name="her[]" value="' + element + '">Her-Tahap ' + element + '</td>';
                    her += '<td><input type="date" class="form-control" name="tglmulaiHer[]" id="exampleInputdate" value=""></td>';
                    her += '<td><input type="date" class="form-control" name="tglselesaiHer[]" id="exampleInputdate" value=""></td>';
                    her += '</tr>';
                });
            } else {
                her += '<tr>';
                her += '<td style="text-align:center" colspan="3">Tidak ada biaya pembayaran Her-Registrasi</td>';
                her += '</tr>';
            }

            let baris = '';
            baris += '<tr>';
            baris += '<td style="text-align:center"><input type="hidden" class="form-control" name="tahap[]" value="' + 0 + '">Lunas</td>';
            baris += '<td><input type="date" class="form-control" name="tglmulai[]" id="exampleInputdate" value=""></td>';
            baris += '<td><input type="date" class="form-control" name="tglselesai[]" id="exampleInputdate" value=""></td>';
            baris += '</tr>';
            for (let i = 1; i <= uniqueData[0]; i++) {
                baris += '<tr>';
                baris += '<td style="text-align:center"><input type="hidden" class="form-control" name="tahap[]" value="' + i + '">Tahap ' + i + '</td>';
                baris += '<td><input type="date" class="form-control" name="tglmulai[]" id="exampleInputdate" value=""></td>';
                baris += '<td><input type="date" class="form-control" name="tglselesai[]" id="exampleInputdate" value=""></td>';
                baris += '</tr>';
            }

            $('#herRegistrasi').empty();
            $('#herRegistrasi').append(her);
            $('#tglTahap').empty();
            $('#tglTahap').append(baris);

            $('.formhitung').show();
            $('.btnSimpanHitung').show();
            $('.peringatan').empty();
            $('.peringatan').append(alert);
            $('#hitungTagihanModal').modal('show');
        } else if (uniqueProdi.length == 1 && uniqueData.length > 1) {
            let alert = '';
            alert += '<div class="alert alert-danger" role="alert">';
            alert += '<div class="iq-alert-icon">';
            alert += '<i class="ri-alert-line"></i>';
            alert += '</div>';
            alert += '<div class="iq-alert-text">Ditemukan data yang berbeda jumlah tahap, silahkan periksa kembali prodi program kuliah yang di checklist</div>';
            alert += '</div>';
            $('.formhitung').hide();
            $('.btnSimpanHitung').hide();
            $('.peringatan').empty();
            $('.peringatan').append(alert);
            $('#hitungTagihanModal').modal('show');
        } else if (uniqueProdi.length > 1 && uniqueData.length == 1) {
            let alert = '';
            alert += '<div class="alert alert-danger" role="alert">';
            alert += '<div class="iq-alert-icon">';
            alert += '<i class="ri-alert-line"></i>';
            alert += '</div>';
            alert += '<div class="iq-alert-text">Permintaan ditolak, sistem menemukan prodi yang berbeda dalam satu proses</div>';
            alert += '</div>';
            $('.formhitung').hide();
            $('.btnSimpanHitung').hide();
            $('.peringatan').empty();
            $('.peringatan').append(alert);
            $('#hitungTagihanModal').modal('show');
        } else {
            let alert = '';
            alert += '<div class="alert alert-danger" role="alert">';
            alert += '<div class="iq-alert-icon">';
            alert += '<i class="ri-alert-line"></i>';
            alert += '</div>';
            alert += '<div class="iq-alert-text">Silahkan pilih prodi program pilihan terlebih dahulu</div>';
            alert += '</div>';
            $('.formhitung').hide();
            $('.btnSimpanHitung').hide();
            $('.peringatan').empty();
            $('.peringatan').append(alert);
            $('#hitungTagihanModal').modal('show');
        }
    });

    function sendDataTagihan(path, ket) {
        $.ajax({
            type: "POST",
            url: "/tagihan/ubahTagihan",
            data: {
                id: path[0],
                tahap: path[1],
                ket: ket,
                from: 'teller',
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                console.log(response);
                myUrl = window.location.href;
                window.location.replace(myUrl);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function sendDataTagihanHer(path, ket) {
        $.ajax({
            type: "POST",
            url: "/tagihan/ubahTagihanHer",
            data: {
                id: path[0],
                tahap: path[1],
                ket: ket,
                from: 'teller',
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                console.log(response);
                myUrl = window.location.href;
                window.location.replace(myUrl);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function sendDataTagihanLain(id, ket) {
        $.ajax({
            type: "POST",
            url: "/tagihan/ubahTagihanLain",
            data: {
                id: id,
                ket: ket,
                from: 'teller',
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                console.log(response);
                myUrl = window.location.href;
                window.location.replace(myUrl);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(".tagihItem").change(function () {
        console.log($(this).data("id"));
        let ket = '';
        ($(this).is(':checked')) ? ket = '1': ket = '0';
        if ($(this).data("id").split(',')[2] == 3 || $(this).data("id").split(',')[2] == 2) {
            sendDataTagihan([$(this).data("id").split(',')[0], $(this).data("id").split(',')[1]], ket);
        } else if ($(this).data("id").split(',')[2] == 25) {
            sendDataTagihanHer([$(this).data("id").split(',')[0], $(this).data("id").split(',')[1]], ket);
        } else {
            sendDataTagihanLain($(this).data("id").split(',')[0], ket);
        }
    })

    $(".tambahPrak").click(function() {
        var url = new URLSearchParams(window.location.search);
        let nilaiProdi = url.get('prodi');
        let nilaiProgramKuliah = url.get('pgKuliah');
        console.log(nilaiProdi, nilaiProgramKuliah);
        $.ajax({
            type: "POST",
            url: "/setMatkulDitawarkan/matkulKurikulum/pratikum",
            data: {
                prodiAkademik: nilaiProdi,
                programKuliahAkademik: nilaiProgramKuliah
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
                    $(".matkulPrak").empty();
                    $(".matkulPrak").append(data);
                } else {
                    $(".matkulPrak").empty();
                    $(".matkulPrak").append(data, response.list_matkul_kurikulum);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $("#jenis1").click(function() {
        let npm = $('[name="npm"]').val();
        $.ajax({
            type: "POST",
            url: "/keuTahap/jumlah",
            data: {
                npm: npm,
            },
            dataType: "json",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                if (response.data_tahap.length == 0) {
                    alert('Jumlah Tahap Pembayaran Belum Disetting!');
                } else {
                    let jml = response.data_tahap
                    let data = "";
                    for (let thp = 1; thp <= jml; thp++) {
                        data += '<div class="custom-control custom-radio custom-control-inline">'
                        data += '<input type="radio" id="tahap' + thp + '" value="' + thp + '" name="jenisTahap" class="custom-control-input" required>'
                        data += '<label class="custom-control-label" for="tahap' + thp + '">' + thp + '</label>'
                        data += '</div>'
                    }
                    $(".tahap").empty();
                    $(".tahap").append(data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $("#jenis0").click(function() {
        $(".tahap").empty();
    });

});
let idmodal;
let tahapId;

function openmodal(id, tahap) {
    idmodal = id;
    tahapId = tahap;
    $('#setting' + idmodal).modal('hide');
    $('#set2').modal('show');
}

function goback() {
    let namaId = [];
    let namaItem = [];
    let nominal = [];
    $("#namaTarif").find('input[name="record"]').each(function() {
        if ($(this).is(":checked")) {
            namaId.push($(this).data('id'));
            namaItem.push($(this).val());
            nominal.push($('input[name="nominalTagihan' + $(this).data('index') + '"]').val());
        }
    });
    console.log(namaId, namaItem, nominal);

    let jumlah = 0;
    nominal.forEach(element => {
        jumlah = jumlah + parseInt(element);
    });
    $("#itemSave" + idmodal + tahapId).val(namaId.join(","));
    $("#item" + idmodal + tahapId).val(namaItem.join(","));
    $("#nominalTahapSave" + idmodal + tahapId).val(nominal.join(","));
    $("#nominalTahap" + idmodal + tahapId).val(jumlah);
    $('#set2').modal('hide');
    $("#setting" + idmodal).modal('show');
}

let percentage = 0

function sync() {
    percentage = percentage + 5
    progress_bar_process(percentage)
    $.ajax({
        type: "GET",
        url: "/syncMhsAccount",
        dataType: "json",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            progress_bar_process(100)
                // console.log(response);
                // let jumlah = response.length
                // let percentage = 0
                // $.each(response, function (key, value) {
                //     // console.log(value.mahasiswaNpm); 
                //     createAccount(value.mahasiswaNpm)
                //     percentage = ((key + 1) /jumlah)*100
                //     progress_bar_process(percentage)
                //     flush();
                // });
        },
        error: handleError
    })
}

function handleError(xhr, status, error) {

    sync()
}

function createAccount(npm) {
    $.ajax({
        type: "POST",
        data: { npm, npm },
        url: "/createMhsAccount",
        dataType: "json",
        async: false,
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            return true;
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    })
}

function progress_bar_process(percentage) {
    $('.progress-bar').css('width', percentage + '%');
}

function cek_her() {
    let jumlahTahap = $('#jumlahTahap').val();
    if ($('#cekHer').is(':checked')) {
        console.log('jumlahTahap');
        if ($('#jumlahTahap').val()) {
            if ($('#jumlahTahap').val() < 1) {
                $('#tahap').empty()
            } else {
                let html = ''
                for (let tahap = 1; tahap <= jumlahTahap; tahap++) {
                    html += '<div class="custom-control custom-checkbox custom-control-inline">'
                    html += '<input type="checkbox" name="refKeuTahapHer[]" class="custom-control-input" id="tahap' + tahap + '" value="' + tahap + '">'
                    html += '<label class="custom-control-label" for="tahap' + tahap + '">Tahap ' + tahap + '</label>'
                    html += '</div>'
                }
                $('#tahap').empty()
                $('#tahap').append(html)
            }
        }
    } else {
        $('#tahap').empty()
    }
}