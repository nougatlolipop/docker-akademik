$(document).ready(function() {

    //menampilkan program kuliah di matkul kurikulum

    $("input[name='matkul[]']").change(function() {
        var matkul = [];
        var mk = [];

        $.each($("input[name='matkul[]']:checked"), function() {
            matkul.push($(this).val());
            mk.push($(this).data('mk'));
        });

        $('.matkul').empty();

        mk.forEach(element => {
            $('tbody.matkul').append('<tr><td>' + element + '</td></tr>');
        });

        $('.element').empty();
        $('.element').append('<input type="hidden" name="kelasProdiProgId" value="' + matkul.join(', ') + '">');
    });

});