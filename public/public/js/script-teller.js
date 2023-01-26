$(document).ready(function () {
    // $tidakLunas = 0;
    // $('.tagihItem').each(function () {
    //     if (!$(this).is(":checked")) {
    //         $tidakLunas++;
    //     }
    // });
    // if ($tidakLunas == 0) {
    //     $('#konfirmasiLunas').modal('show');
    // } 
    // cekJadwalLunas();

    function cekJadwalLunas() {
        $.ajax({
            type: "POST",
            url: "/keuTeller/cekJadwalLunas",
            data: {
                npm:$('input[name=mahasiswaTeller]').val(),
            },
            dataType: "json",
            beforeSend: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
});