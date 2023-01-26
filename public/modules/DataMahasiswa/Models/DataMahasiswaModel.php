<?php

namespace Modules\DataMahasiswa\Models;

use CodeIgniter\Model;

class DataMahasiswaModel extends Model
{
    protected $table = 'dt_mahasiswa';
    protected $primaryKey = 'mahasiswaId';
    protected $allowedFields = [
        "mahasiswaId", "mahasiswaNoDaftar", "mahasiswaNpm", "mahasiswaNamaLengkap", "mahasiswaTempatLahir", "mahasiswaTanggalLahir", "mahasiswaAlamat", "mahasiswaNoHp", "mahasiswaKecamatanId", "mahasiswaKodePos", "mahasiswaProdiProgramKuliahId", "mahasiswaKelasId", "mahasiswaJenisKelaminId", "mahasiswaAgamaId", "mahasiswaGolDarahId", "mahasiswaRt", "mahasiswaRw", "mahasiswaDusun", "mahasiswaJenisTinggalId", "mahasiswaSumberBiayaId", "mahasiswaBacaQuranId", "mahasiswaTransportId", "mahasiswaAlamatUjian", "mahasiswaNoTelp", "mahasiswaEmail", "mahasiswaFoto", "mahasiswaStatusFoto", "mahasiswaUsername", "mahasiswaPassword", "mahasiswaGelombangDaftarId", "mahasiswaJalurDaftarId", "mahasiswaAngkatan", "mahasiswaSemesterId", "mahasiswaStatusBayarDaftar", "mahasiswaScanBayarDaftar", "mahasiswaStatusBayarRegulang", "mahasiswaScanBayarRegulang", "mahasiswaTanggalDaftar", "mahasiswaTanggalIsiBiodata", "mahasiswaTanggalRegulang", "mahasiswaLulusProdiPilihan", "mahasiswaStatusTesKesehatan", "mahasiswaTesCadangan", "mahasiswaAsalSekolahId", "mahasiswaAlamatSekolahAsal", "mahasiswaKecamatanSekolahAsal", "mahasiswaJenjangPendidikanId", "mahasiswaJurusanSekolahId", "mahasiswaNIK", "mahasiswaScanKTP", "mahasiswaNoSKHU", "mahasiswaScanSKHU", "mahasiswaNoIjazah", "mahasiswaScanIjazah", "mahasiswaScanKK", "mahasiswaNoAkteLahir", "mahasiswaScanAkteLahir", "mahasiswaTanggalSKHU", "mahasiswaTanggalIjazah", "mahasiswaNilaiSKHU", "mahasiswaNilaiIjazah", "mahasiswaNilaiRaport", "mahasiswaTahunLulusSekolah", "mahasiswaTahunTamatSekolah", "mahasiswaNoUjian", "mahasiswaKebutuhanKhususId", "mahasiswaPenerimaKpsId", "mahasiswaStatusPenerimaKps", "mahasiswaPenerimaBeasiswaId", "mahasiswaStatusPenerimaBeasiswa", "mahasiswaScanPenerimaKps", "mahasiswaScanPenerimaBeasiswa", "mahasiswaNamaAyah", "mahasiswaTempatLahirAyah", "mahasiswaTanggalLahirAyah", "mahasiswaJenjangPendidikanAyah", "mahasiswaPekerjaanAyah", "mahasiswaPenghasilanAyah", "mahasiswaKebutuhanKhususAyah", "mahasiswaNoTelpAyah", "mahasiswaNamaIbu", "mahasiswaTempatLahirIbu", "mahasiswaTanggalLahirIbu", "mahasiswaJenjangPendidikanIbu", "mahasiswaPekerjaanIbu", "mahasiswaPenghasilanIbu", "mahasiswaKebutuhanKhususIbu", "mahasiswaNoTelpIbu", "mahasiswaNamaWali", "mahasiswaTempatLahirWali", "mahasiswaTanggalLahirWali", "mahasiswaJenjangPendidikanWali", "mahasiswaPekerjaanWali", "mahasiswaPenghasilanWali", "mahasiswaKebutuhanKhususWali", "mahasiswaNoTelpWali", "mahasiswaAlamatOrtu", "mahasiswaKecamatanOrtu", "mahasiswaAlamatWali", "mahasiswaKecamatanWali", "mahasiswaNISN", "mahasiswaBebasTes", "mahasiswaPeringkatBebasTes", "mahasiswaUjianPBT", "mahasiswaTanggalUjianPBT", "mahasiswaNilaiUjianPBT", "mahasiswaUjianCBT", "mahasiswaTanggalUjianCBT", "mahasiswaNilaiUjianCBT", "mahasiswaStatusNikahId", "mahasiswaHobiId", "mahasiswaPekerjaanId", "mahasiswaPekerjaanInstansiNama", "mahasiswaPekerjaanInstansiAlamat", "mahasiswaPekerjaanInstansiTelp", "mahasiswaNpmAsal", "mahasiswaGelar", "mahasiswaPTAsal", "mahasiswaFakultasAsal", "mahasiswaProdiAsal", "mahasiswaAkreditasiPTAsal", "mahasiswaTahunMasukPTAsal", "mahasiswaTahunLulusPTAsal", "mahasiswaNoIjazahPTAsal", "mahasiswaScanIjazahPTAsal", "mahasiswaJumlahSksPTAsal", "mahasiswaIpkPTAsal", "mahasiswaNilaiTranskripPTAsal", "mahasiswaGelarPasca", "mahasiswaPTAsalPasca", "mahasiswaFakultasAsalPasca", "mahasiswaProdiAsalPasca", "mahasiswaAkreditasiPTAsalPasca", "mahasiswaTahunMasukPTAsalPasca", "mahasiswaTahunLulusPTAsalPasca", "mahasiswaNoIjazahPTAsalPasca", "mahasiswaScanIjazahPTAsalPasca", "mahasiswaJumlahSksPTAsalPasca", "mahasiswaIpkPTAsalPasca", "mahasiswaNilaiTranskripPTAsalPasca", "mahasiswaRiwayatSDNama", "mahasiswaRiwayatSDAlamat", "mahasiswaRiwayatSDTahunLulus", "mahasiswaRiwayatSDTahunTamat", "mahasiswaRiwayatSMPNama", "mahasiswaRiwayatSMPAlamat", "mahasiswaRiwayatSMPTahunLulus", "mahasiswaRiwayatSMPTahunTamat", "mahasiswaRiwayatSMANama", "mahasiswaRiwayatSMAAlamat", "mahasiswaRiwayatSMATahunLulus", "mahasiswaRiwayatSMATahunTamat", "mahasiswaRiwayatPT1Nama", "mahasiswaRiwayatPT1Alamat", "mahasiswaRiwayatPT1TahunLulus", "mahasiswaRiwayatPT1TahunTamat", "mahasiswaRiwayatPT2Nama", "mahasiswaRiwayatPT2Alamat", "mahasiswaRiwayatPT2TahunLulus", "mahasiswaRiwayatPT2TahunTamat", "mahasiswaRiwayatPT3Nama", "mahasiswaRiwayatPT3Alamat", "mahasiswaRiwayatPT3TahunLulus", "mahasiswaRiwayatPT3TahunTamat", "mahasiswaAsalInformasiId", "mahasiswaDiskonBiayaId", "mahasiswaDiskonJumlah", "mahasiswaDiskonPersen", "mahasiswaAlumni", "mahasiswaAlumniDeskripsi", "mahasiswaIsKonversi", "mahasiswaKeterangan", "mahasiswaStatusAktif", "mahasiswaCreatedBy", "mahasiswaCreatedDate", "mahasiswaModifiedBy", "mahasiswaModifiedDate", "mahasiswaDeletedAt"
    ];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'mahasiswaCreatedDate';
    protected $updatedField = 'mahasiswaModifiedDate';
    protected $deletedField = 'mahasiswaDeletedAt';

    public function getDataMahasiswa($where, $fakultas = null)
    {
        $builder = $this->table('dt_mahasiswa');
        $builder->join('dt_kelas', 'dt_kelas."kelasId" = dt_mahasiswa."mahasiswaKelasId"', 'LEFT');
        $builder->join('ref_jenis_kelamin', 'ref_jenis_kelamin."refJkId" = dt_mahasiswa."mahasiswaJenisKelaminId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah.setProdiProgramKuliahId = dt_mahasiswa.mahasiswaProdiProgramKuliahId', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah.programKuliahId = setting_prodi_program_kuliah.setProdiProgramKuliahProgramKuliahId', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi.prodiId = setting_prodi_program_kuliah.setProdiProgramKuliahProdiId', 'LEFT');
        $builder->join('dt_waktu_kuliah', 'dt_waktu_kuliah.waktuId = setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', 'LEFT');
        if ($fakultas) {
            $builder->where($fakultas);
        }
        if (isset($where['angkatan_min'])) {
            $builder->where('dt_mahasiswa.mahasiswaAngkatan >=', $where['angkatan_min']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_mahasiswa."mahasiswaNpm")', strtolower($where['keyword']))->where('dt_mahasiswa.mahasiswaAngkatan >=', $where['angkatan_min']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->where('dt_mahasiswa.mahasiswaAngkatan >=', $where['angkatan_min']);
            }
        }
        if (isset($where['angkatan_max'])) {
            $builder->where('dt_mahasiswa.mahasiswaAngkatan <=', $where['angkatan_max']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_mahasiswa."mahasiswaNpm")', strtolower($where['keyword']))->where('dt_mahasiswa.mahasiswaAngkatan <=', $where['angkatan_max']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->where('dt_mahasiswa.mahasiswaAngkatan <=', $where['angkatan_max']);
            }
        }
        if (isset($where['program_kuliah'])) {
            $builder->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_mahasiswa."mahasiswaNpm")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->where('dt_program_kuliah.programKuliahId', $where['program_kuliah']);
            }
        }
        if (isset($where['prodi'])) {
            $builder->whereIn('dt_prodi.prodiId', $where['prodi']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_mahasiswa."mahasiswaNpm")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->whereIn('dt_prodi.prodiId', $where['prodi']);
            }
        }
        if (isset($where['waktuKuliah'])) {
            $builder->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_mahasiswa."mahasiswaNpm")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']))->whereIn('setting_prodi_program_kuliah.setProdiProgramKuliahWaktuKuliahId', $where['waktuKuliah']);
            }
        }
        if (!isset($where['angkatan_min']) && !isset($where['angkatan_max']) && !isset($where['program_kuliah']) && !isset($where['prodi']) && !isset($where['waktuKuliah'])) {
            if (isset($where['keyword'])) {
                $builder->like('LOWER(dt_mahasiswa."mahasiswaNpm")', strtolower($where['keyword']));
                $builder->orLike('LOWER(dt_mahasiswa."mahasiswaNamaLengkap")', strtolower($where['keyword']));
            }
        }
        $builder->orderBy('dt_mahasiswa.mahasiswaId', 'DESC');
        return $builder;
    }
}
