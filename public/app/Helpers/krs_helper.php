<?php

function getTahunAjaranAktif($npm, $type)
{
    $orWhere = [];
    if (in_groups(['Fakultas'])) {
        if ($type == 'krs') {
            $where = array(
                'setting_jadwal_akademik.setJadwalAkademikKrsStartDate <= ' => date('Y-m-d H:i:s'),
                'setting_jadwal_akademik.setJadwalAkademikKrsEndDate >= ' => date('Y-m-d H:i:s'),
                'dt_mahasiswa.mahasiswaNpm' => $npm,
            );
            $orWhere = array(
                ['setting_jadwal_akademik.setJadwalAkademikKrsForceAktif' => '1'],
                ['dt_mahasiswa.mahasiswaNpm' => $npm],
            );
        } elseif ($type == 'nilai') {
            $where = array(
                'setting_jadwal_akademik.setJadwalAkademikUasStartDate <= ' => date('Y-m-d H:i:s'),
                'setting_jadwal_akademik.setJadwalAkademikUasEndDate >= ' => date('Y-m-d H:i:s'),
                'dt_mahasiswa.mahasiswaNpm' => $npm,
            );
            $orWhere = array(
                ['setting_jadwal_akademik.setJadwalAkademikUasForceAktif' => '1'],
                ['dt_mahasiswa.mahasiswaNpm' => $npm],
            );
        }
    } else {
        if ($type == 'krs') {
            $where = array(
                'setting_jadwal_akademik.setJadwalAkademikKrsStartDate <= ' => date('Y-m-d H:i:s'),
                'setting_jadwal_akademik.setJadwalAkademikKrsEndDate >= ' => date('Y-m-d H:i:s'),
                'dt_mahasiswa.mahasiswaNpm' => $npm,
            );
            $orWhere = array(
                ['setting_jadwal_akademik.setJadwalAkademikKrsForceAktif' => '1'],
                ['dt_mahasiswa.mahasiswaNpm' => $npm],
            );
        } elseif ($type == 'nilai') {
            $where = array(
                'setting_jadwal_akademik.setJadwalAkademikUasStartDate <= ' => date('Y-m-d H:i:s'),
                'setting_jadwal_akademik.setJadwalAkademikUasEndDate >= ' => date('Y-m-d H:i:s'),
                'dt_mahasiswa.mahasiswaNpm' => $npm,
            );
            $orWhere = array(
                ['setting_jadwal_akademik.setJadwalAkademikUasForceAktif' => '1'],
                ['dt_mahasiswa.mahasiswaNpm' => $npm],
            );
        }
    }

    $model = new Modules\SetJadwalAkademik\Models\SetJadwalAkademikModel;
    $result = $model->getTahunAjaranAktif($where, $orWhere)->findAll();
    return $result;
}

// function getTahunAjaranAktifByNoReg($noReg, $type)
// {
//     if ($type == 'krs') {
//         $where = array(
//             'setting_jadwal_akademik.setJadwalAkademikKrsStartDate <= ' => date('Y-m-d H:i:s'),
//             'setting_jadwal_akademik.setJadwalAkademikKrsEndDate >= ' => date('Y-m-d H:i:s'),
//             'dt_mahasiswa.mahasiswaNpm' => $noReg,
//         );
//         $orWhere = array(
//             'setting_jadwal_akademik.setJadwalAkademikKrsForceAktif' => '1',
//             'dt_mahasiswa.mahasiswaNpm' => $noReg,
//         );
//     }
//     $model = new Modules\SetJadwalAkademik\Models\SetJadwalAkademikModel;
//     $result = $model->getTahunAjaranAktif($where, $orWhere)->findAll();
//     return $result;
// }

function getMatkul($id)
{
    $model = new Modules\SetMatkulDitawarkan\Models\SetMatkulDitawarkanModel;
    $result = $model->getKrsDetail(['setting_matkul_tawarkan."setMatkulTawarId"' => $id])->findAll();
    return $result;
}

function reformatDosen($id, $data)
{
    $str = "";
    foreach ($data as $key => $dosen) {
        if ($id == $dosen->idMatkulTawar) {
            $depan = ($dosen->dosenGelarDepan == null) ? "" : $dosen->dosenGelarDepan;
            $tengah = $dosen->dosenNama;
            $belakang = $dosen->dosenGelarBelakang;
            $str .= $depan . " " . $tengah . " " . $belakang;
            if ($key + 1 < count($data)) {
                $str .= ", ";
            }
        }
    }
    return $str;
}

function getMatkulByMatkul($id)
{
    $model = new Modules\SetMatkulDitawarkan\Models\SetMatkulDitawarkanModel;
    $result = $model->getKrsDetail(['dt_matkul."matkulId"' => $id])->findAll();
    return $result;
}

function getSksAllowed($where)
{
    $model = new Modules\KhsMahasiswa\Models\KhsMahasiswaModel;
    $result = $model->cariKhs($where)->findAll();
    return $result;
}

function unique_key($array, $keyname)
{
    $new_array = array();
    foreach ($array as $key => $value) {
        if (!isset($new_array[$value[$keyname]])) {
            $new_array[$value[$keyname]] = $value;
        }
    }
    $new_array = array_values($new_array);
    return $new_array;
}

function hari_ini()
{
    $hari = date("D");

    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu";
            break;

        case 'Mon':
            $hari_ini = "Senin";
            break;

        case 'Tue':
            $hari_ini = "Selasa";
            break;

        case 'Wed':
            $hari_ini = "Rabu";
            break;

        case 'Thu':
            $hari_ini = "Kamis";
            break;

        case 'Fri':
            $hari_ini = "Jumat";
            break;

        case 'Sat':
            $hari_ini = "Sabtu";
            break;

        default:
            $hari_ini = "Tidak di ketahui";
            break;
    }

    return $hari_ini;
}
