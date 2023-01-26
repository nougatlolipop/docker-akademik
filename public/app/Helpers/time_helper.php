<?php
function reformat($string)
{
    $date = strtotime($string);
    $output = date('Y-m-d', $date);
    return $output;
}

function reformatTime($string)
{
    $date = strtotime($string);
    $output = date('H:i', $date);
    return $output;
}

function sumTime($times)
{
    $minutes = 0;
    foreach ($times as $time) {
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    return sprintf('%02d:%02d', $hours, $minutes);
}

function reformatTanggalIndo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[0] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[2];
}
