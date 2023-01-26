<?php

function getTahunAjaranBerjalan()
{
    $model = new Modules\TahunAjaran\Models\TahunAjaranModel;
    $result = $model->getTahunAjaranBerjalan()->findAll();
    return $result;
}

function getMenitSks()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getMenitSks'])->getResult()[0]->configValue;
    return $result;
}

function reformatRoster($where)
{
    $roster = new \Modules\SetRosterKuliah\Models\SetRosterKuliahModel;
    $result = $roster->getWhere(['setting_jadwal_kuliah."setJadwalKuliahMatkulTawarId"' => $where[1]])->findAll();
    $str = '';
    $no = 1;
    foreach ($result as $key => $dtRoster) {
        $id = $dtRoster->setJadwalKuliahId;
        $hari = $dtRoster->refHariNama;
        $jamMulai = reformatTime($dtRoster->setJadwalKuliahJamMulai);
        $jamSelesai = reformatTime($dtRoster->setJadwalKuliahJamSelesai);
        $ruangan = $dtRoster->ruangNama;
        if ($where[0] == 'tabel') {
            $str .= '<tr>';
            $str .= '<td style="text-align:center">' . $no++ . '</td>';
            $str .= '<td>' . $hari . ' ' . reformatTime($jamMulai) . ' - ' . reformatTime($jamSelesai) . '</td>';
            $str .= '<td>' . $ruangan . '</td>';
            $str .= '<td style="text-align:center"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus' . $id . '"><i class="las la-trash"> </i></button></td>';
            $str .= '</tr>';
        } else {
            if (count($result) > 1) {
                $str .= '- ';
            }
            $str .= $hari . ' ' . $jamMulai . ' - ' . $jamSelesai . ' / ' . $ruangan;
            if (count($result) > 1) {
                $str .= '<br/>';
            }
        }
    }
    return $str;
}

function reformatDosenMatkul($where)
{
    $dosen = new \Modules\Dosen\Models\DosenModel;
    $idDosen = [];
    foreach ($where[1] as $key => $data) {
        $idDosen[] = $data->id;
    }
    $str = '';
    if ($idDosen == null) {
        $str .= 'Belum disetting';
    } else {
        $result = $dosen->getWhereIn($idDosen)->findAll();
        foreach ($result as $key => $dosen) {
            $id = $dosen->dosenId;
            $depan = ($dosen->dosenGelarDepan == null) ? "" : $dosen->dosenGelarDepan;
            $tengah = $dosen->dosenNama;
            $belakang = $dosen->dosenGelarBelakang;
            if ($where[0] == 'tabel') {
                $str .= '<tr>';
                $str .= '<td style="text-align:center"><div class="custom-control custom-checkbox"><input name="hapusDosen[]" value="' . $id . '" type="checkbox" class="custom-control-input" id="customCheckDosen' . $id . $where[2] . '"><label class="custom-control-label" for="customCheckDosen' . $id . $where[2] . '"></label></div></td>';
                $str .= '<td>' . $depan . " " . $tengah . " " . $belakang . '</td>';
                $str .= '</tr>';
            } elseif ($where[0] == 'list') {
                if (count($result) > 1) {
                    $str .= '- ';
                }
                $str .= $depan . " " . $tengah . " " . $belakang;
                if (count($result) > 1) {
                    $str .= '<br/>';
                }
            } else {
                $str .= $depan . " " . $tengah . " " . $belakang;
                if (count($result) > 1) {
                    $str .= ', ';
                }
            }
        }
    }
    return $str;
}

function reformatDosenPimpinan($where)
{
    $dosen = new \Modules\Dosen\Models\DosenModel;
    if ($where[0] == 'fakultas') {
        $idDosen = [$where[1], $where[2], $where[3]];
        $str = '';
        $result = $dosen->getWhereIn($idDosen)->findAll();
        foreach ($result as $key => $dosen) {
            $id = $dosen->dosenId;
            $depan = ($dosen->dosenGelarDepan == null) ? "" : $dosen->dosenGelarDepan;
            $tengah = $dosen->dosenNama;
            $belakang = $dosen->dosenGelarBelakang;
            if ($where[4] == '20') {
                $str .= ($where[1] == $id) ? '<tr><th>Direktur</th></tr><tr><td>' . $depan . " " . $tengah . " " . $belakang . '</td></tr>' : '';
                $str .= ($where[2] == $id) ? '<tr><th>Wakil Direktur</th></tr><tr><td>' . $depan . " " . $tengah . " " . $belakang . '</td></tr>' : '';
            } else {
                $str .= ($where[1] == $id) ? '<tr><th>Dekan</th></tr><tr><td>' . $depan . " " . $tengah . " " . $belakang . '</td></tr>' : '';
                $str .= ($where[2] == $id) ? '<tr><th>Wakil Dekan I</th></tr><tr><td>' . $depan . " " . $tengah . " " . $belakang . '</td></tr>' : '';
                $str .=  ($where[3] == $id) ? '<tr><th>Wakil Dekan III</th></tr><tr><td>' . $depan . " " . $tengah . " " . $belakang . '</td></tr>' : '';
            }
        }
    } else {
        $idDosen = [$where[1], $where[2]];
        $str = '';
        $result = $dosen->getWhereIn($idDosen)->findAll();
        foreach ($result as $key => $dosen) {
            $id = $dosen->dosenId;
            $depan = ($dosen->dosenGelarDepan == null) ? "" : $dosen->dosenGelarDepan;
            $tengah = $dosen->dosenNama;
            $belakang = $dosen->dosenGelarBelakang;

            $str .= ($where[1] == $id) ? '<tr><th>Ketua</th></tr><tr><td>' . $depan . " " . $tengah . " " . $belakang . '</td></tr>' : '';
            $str .= ($where[2] == $id) ? '<tr><th>Sekretaris</th></tr><tr><td>' . $depan . " " . $tengah . " " . $belakang . '</td></tr>' : '';
        }
    }

    return $str;
}
