// cetak krs mahasiswa

function cetakKrs(npm, ta) {
    let url_print = "/krsMahasiswa/cetak";
    url_print += '?n=' + npm
    url_print += '&t=' + ta
    window.open(url_print, '_blank');
}