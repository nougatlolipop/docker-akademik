$(document).ready(function() {
    var myUrl = window.location.href;
    var base_url = myUrl.split('?')[0];

    $('input[name="angkatanMin"]').keyup(function(e) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
        if (e.keyCode == 13) {
            if ($(this).val().length > 0 && $(this).val().length < 4) {
                $(this).val('');
                $(this).focus();
            } else {
                addQSParm('angMin', $(this).val());
                window.location.replace(myUrl);
            }
        }
    });

    $('input[name="angkatanMax"]').keyup(function(e) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
        if (e.keyCode == 13) {
            if ($(this).val().length > 0 && $(this).val().length < 4) {
                $(this).val('');
                $(this).focus();
            } else {
                addQSParm('angMax', $(this).val());
                window.location.replace(myUrl);
            }
        }
    });

    $('[name="progKuliah"]').change(function(e) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
        addQSParm('pgKuliah', $(this).val());
        window.location.replace(myUrl);
    });

    $('[name="kurikulum"]').change(function(e) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
        addQSParm('kurikulum', $(this).val());
        window.location.replace(myUrl);
    });

    $('[name="kelKuliah"]').change(function(e) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
        addQSParm('kelKuliah', $(this).val());
        window.location.replace(myUrl);
    });

    $("button[name='jenisBiaya']").click(function() {
        var array = [];
        $("input:checkbox[name=jenisBiaya]:checked").each(function() {
            array.push($(this).val());
        });
        if (array.length == 0) {
            window.location.replace(myUrl);
        } else {
            addQSParm('jenisBiaya', array);
            window.location.replace(myUrl);
        }
    });

    $("input:checkbox[name=smallJenis]").change(function() {
        var forMaintenance = new URLSearchParams(window.location.search);
        var array = [];
        var existProdi = false;

        if ($(this).is(":checked")) {
            for (const [k, v] of forMaintenance) {
                if (k.toString() == 'jenisBiaya') {
                    existProdi = true;
                }
            }
            if (existProdi) {
                forMaintenance.get('jenisBiaya').split(',').forEach(element => {
                    array.push(element);
                });
                array.push($(this).val())
            } else {
                array.push($(this).val())
            };
        } else {
            for (const [k, v] of forMaintenance) {
                if (k.toString() == 'jenisBiaya') {
                    existProdi = true;
                }
            }
            if (existProdi) {
                forMaintenance.get('jenisBiaya').split(',').forEach(element => {
                    if ($(this).val() != element) {
                        array.push(element);
                    }
                });
            } else {
                array.push($(this).val())
            };
        }

        if (array.length == 0) {
            addQSParm('jenisBiaya', "");
            window.location.replace(myUrl);
        } else {
            addQSParm('jenisBiaya', array);
            window.location.replace(myUrl);
        }
    });

    $("button[name='prodi']").click(function() {
        var forMaintenance = new URLSearchParams(window.location.search);
        var array = [];
        var existProdi = false;
        for (const [k, v] of forMaintenance) {
            if (k.toString() == 'prodi') {
                existProdi = true;
            }
        }
        if (existProdi) {
            if (forMaintenance.get('prodi').split(',').indexOf("99") != -1) {
                addQSParm('prodi', "");
                window.location.replace(myUrl);
            } else {
                $("input:checkbox[name=prd]:checked").each(function() {
                    array.push($(this).val());
                });
                if (array.length == 0) {
                    window.location.replace(myUrl);
                } else {
                    addQSParm('prodi', array);
                    window.location.replace(myUrl);
                }
            }
        } else {
            $("input:checkbox[name=prd]:checked").each(function() {
                array.push($(this).val());
            });
            if (array.length == 0) {
                window.location.replace(myUrl);
            } else {
                addQSParm('prodi', array);
                window.location.replace(myUrl);
            }
        }
    });

    $("input:checkbox[name=smallPrd]").change(function() {
        var forMaintenance = new URLSearchParams(window.location.search);
        var array = [];
        var existProdi = false;
        if ($(this).val() == '99') {
            if ($(this).is(":checked")) {
                addQSParm('prodi', '99');
                window.location.replace(myUrl);
            } else {
                addQSParm('prodi', '');
                window.location.replace(myUrl);
            }
        } else {
            if ($(this).is(":checked")) {
                for (const [k, v] of forMaintenance) {
                    if (k.toString() == 'prodi') {
                        existProdi = true;
                    }
                }
                if (existProdi) {
                    forMaintenance.get('prodi').split(',').forEach(element => {
                        array.push(element);
                    });
                    array.push($(this).val())
                } else {
                    array.push($(this).val())
                };
            } else {
                console.log('disini');
                for (const [k, v] of forMaintenance) {
                    if (k.toString() == 'prodi') {
                        existProdi = true;
                    }
                }
                if (existProdi) {
                    forMaintenance.get('prodi').split(',').forEach(element => {
                        if (element != '99') {
                            if ($(this).val() != element) {
                                array.push(element);
                            }
                        }
                    });
                } else {
                    array.push($(this).val())
                };
            }
            if (array.length == 0) {
                addQSParm('prodi', "");
                window.location.replace(myUrl);
            } else {
                addQSParm('prodi', array);
                window.location.replace(myUrl);
            }
        }


    });

    $('input:checkbox[name="wktKuliah"]').change(function(e) {
        var array = [];
        $("input:checkbox[name=wktKuliah]:checked").each(function() {
            array.push($(this).val());
        });
        if (array.length == 0) {
            addQSParm('wktKuliah', "");
            window.location.replace(myUrl);
        } else {
            addQSParm('wktKuliah', array);
            window.location.replace(myUrl);
        }
    });

    $('[name="thnAjar"]').keyup(function(e) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
        if (e.keyCode == 13) {
            if ($(this).val().length > 0 && $(this).val().length < 4) {
                $(this).val('');
                $(this).focus();
            } else {
                if ($(this).val().length > 0 && $(this).val().length < 4) {
                    $(this).val('');
                    $(this).focus();
                } else if ($(this).val().length == 0) {
                    addQSParm('thnAjar', "");
                    window.location.replace(myUrl);
                } else {
                    var array = [1, 2];
                    addQSParm('thnAjar', $(this).val());
                    window.location.replace(myUrl);
                }
            }
        }
    });

    $('input.keyword').keyup(function(e) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
        if (e.keyCode == 13) {

            addQSParm('keyword', $(this).val());
            window.location.replace(myUrl);

        }
    });

    $('input.npm').keyup(function(e) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
    });

    $('input.cari').keyup(function(e) {
        if (e.keyCode == 13) {

            addQSParm('keyword', $(this).val());
            window.location.replace(myUrl);

        }
    });

    $("span[name=filter]").click(function() {
        var forMaintenance = new URLSearchParams(window.location.search);
        var array = [];
        for (const [k, v] of forMaintenance) {
            if (k.toString() == $(this).data('name')) {
                forMaintenance.get(k.toString()).split(',').forEach(element => {
                    if (element != $(this).data('val')) {
                        array.push(element);
                    }
                });
            }
        }

        if (array.length == 0) {
            addQSParm($(this).data('name'), "");
            window.location.replace(myUrl);
        } else {
            addQSParm($(this).data('name'), array);
            window.location.replace(myUrl);
        }

    });

    $("span[name=deleteFilter]").click(function() {
        window.location.replace(base_url);
    });

    $("input[name=npm]").keyup(function(e) {
        if (e.keyCode == 13) {
            cariMahasiswa($(this).val(), 'krs');
        }
    });

    $("[name=btnCari]").click(function(e) {
        cariMahasiswa($("input[name=npm]").val(), 'krs');
    });

    $("button.hapusMK").click(function(e) {
        var tanya = confirm("Apakah Anda Akan Menghapus Data Ini ?");
        let npm = $(this).data('npm');
        let matkulId = $(this).data('id');
        if (tanya === true) {
            $.ajax({
                type: "POST",
                url: "/krsMahasiswa/hapusKrs",
                data: {
                    npm: npm,
                    matkulId: matkulId,
                },
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        $(".baris" + npm + matkulId).remove();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        } else {
            console.log("Tidak");
        }
    });

    $("button.editNilai").click(function(e) {
        // console.log($(this).data('npm'));
        $('.nilai' + $(this).data('npm')).hide()
    });

    $("input[name=npmTranskrip]").keyup(function(e) {
        if (e.keyCode == 13) {
            cariMahasiswa($(this).val(), 'transkrip');
        }
    });

    $("[name=btnCariTranskrip]").click(function(e) {
        cariMahasiswa($("input[name=npmTranskrip]").val(), 'transkrip');
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
                    if (type == 'krs') {
                        $("input[name=npmKrs]").val(response[0].mahasiswaNpm);
                        $("input[name=namaLengkap]").val(response[0].mahasiswaNamaLengkap);
                        $("tbody[id=dataMK]").empty();
                        cariMkDitawarkan(response[0].mahasiswaNpm, response[0].mahasiswaKelasId);
                        getSksAllowed(response[0].mahasiswaNpm)
                    } else if (type == 'transkrip') {
                        addQSParm('npm', response[0].mahasiswaNpm);
                        window.location.replace(myUrl);
                    }

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
                // console.log(response);
                if (!response.status) {
                    data += "<tr>";
                    data += "<tr>";
                    data += "<td colspan='6' style='text-align:center'>" + response.message + "</td>";
                    data += "</tr>";
                    $("tbody[id=dataMK]").append(data);
                } else {
                    var data = "";
                    response.data.forEach(element => {
                        var tersedia = element.setMatkulTawarKuotaKelas - element.setMatkulTawarKelasTerpakai;
                        var stat = ((element.setMatkulTawarKuotaKelas - element.setMatkulTawarKelasTerpakai) > 0) ? '' : 'disabled';
                        data += "<tr>";
                        data += "<td style='text-align:center'><input type='checkbox' name='matkul[]' value='" + element.setMatkulTawarId + "' class='checkbox-input' id='mkditawarkan' " + stat + "></td>";
                        data += "<td>" + element.matkulKode + " - " + element.matkulNama + " (" + element.kurikulumNama + ")</td>";
                        data += "<td>" + element.kelasKode + " " + element.waktuNama + "</td>";
                        data += "<td>" + element.setMatkulTawarKuotaKelas + "</td>";
                        data += "<td>" + tersedia + "</td>";
                        data += "<td>" + element.setMatkulKurikulumSks + "</td>";
                        data += "</tr>";
                    });
                    $("tbody[id=dataMK]").append(data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
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
            success: function (response) {
                console.log(response);
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
                    var nilai = 0;
                    var sks = 0;
                    data.forEach(khs => {
                        nilai = nilai + khs.totalNilai
                        sks = sks + (khs.totalNilai / khs.nilai);
                    });
                    ipk = nilai / sks;
                    let sksAllow = sksDefault;
                    // console.log(JSON.parse(sksAllowed)['data']);
                    JSON.parse(sksAllowed)['data'][0]['detail'].forEach(sksA => {
                        if (ipk >= sksA.minIpk && ipk <= sksA.maxIpk) {
                            sksAllow = sksA.allow;
                        }
                    });
                    
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

    function addQSParm(name, value) {
        var re = new RegExp("([?&]" + name + "=)[^&]+", "");

        function add(sep) {
            myUrl += sep + name + "=" + encodeURIComponent(value);
        }

        function change(nama, value) {
            var forMaintenance = new URLSearchParams(window.location.search);
            $urlke = 1;
            if (value == "") {
                forMaintenance.delete(nama);
            }

            for (const [k, v] of forMaintenance) {
                if (nama == k && v == value) {
                    if ($urlke == 1) {
                        base_url += "?" + k + "=" + encodeURIComponent(v);
                    } else {
                        base_url += "&" + k + "=" + encodeURIComponent(v);
                    }
                } else if (nama == k && v != value) {
                    if ($urlke == 1) {
                        base_url += "?" + k + "=" + encodeURIComponent(value);
                    } else {
                        base_url += "&" + k + "=" + encodeURIComponent(value);
                    }
                } else if (nama != k && v != value) {
                    if ($urlke == 1) {
                        base_url += "?" + k + "=" + encodeURIComponent(v);
                    } else {
                        base_url += "&" + k + "=" + encodeURIComponent(v);
                    }
                }
                $urlke++;
            }

            myUrl = base_url;
        }


        if (myUrl.indexOf("?") === -1) {
            add("?");
        } else {
            if (re.test(myUrl)) {
                change(name, value);
            } else {
                add("&");
            }
        }

    }
});