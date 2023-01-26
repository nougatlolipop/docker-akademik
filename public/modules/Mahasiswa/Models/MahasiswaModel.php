<?php

namespace Modules\Mahasiswa\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder;

class MahasiswaModel extends Model
{
    protected $table = 'dt_mahasiswa';
    protected $primaryKey = 'mahasiswaId';
    protected $allowedFields = ['mahasiswaNoDaftar', 'mahasiswaNpm',  'mahasiswaNamaLengkap',  'mahasiswaCreatedBy', 'mahasiswaModifiedBy', 'mahasiswaModifiedDate', 'mahasiswaCreatedDate', 'mahasiswaDeletedAt'];
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'mahasiswaCreatedDate';
    protected $updatedField = 'mahasiswaModifiedDate';
    protected $deletedField = 'mahasiswaDeletedAt';


    public function cariMahasiswa($where)
    {
        $builder = $this->table('dt_mahasiswa');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = dt_mahasiswa."mahasiswaProdiProgramKuliahId"', 'left');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"', 'left');
        $builder->join('dt_kelas', 'dt_kelas."kelasId" = dt_mahasiswa."mahasiswaKelasId"', 'left');
        $builder->where($where);
        return $builder;
    }

    public function getPerkembanganAkademik($where)
    {
        $builder = $this->db->table("function_tampil_perkembangan_akademik('" . $where . "')");
        return $builder->get();
    }

    public function getDosenPengampu($where)
    {
        $builder = $this->db->table("function_tampil_pengampu_akademik('" . $where . "')");
        return $builder->get();
    }

    public function getJadwalKuliah($where)
    {
        $builder = $this->db->table("function_tampil_jadwal_kuliah('" . $where[0] . "','" . $where[1] . "')");
        return $builder->get();
    }

    public function getDosenKuliah($where)
    {
        $builder = $this->db->table("function_tampil_dosen_mahasiswa('" . $where[0] . "','" . $where[1] . "')");
        return $builder->get();
    }

    public function getRiwayatPembayaran($where)
    {
        $builder = $this->db->table("function_tampil_payment_all_mhs('" . $where . "')");
        return $builder->get();
    }

    public function getMahasiswaAccountExists()
    {
        $builder = $this->table('dt_mahasiswa');
        $builder->whereNotIn(
            'dt_mahasiswa."mahasiswaNpm"',
            function (BaseBuilder $subBuilder) {
                return $subBuilder->select('users."username"')->from('users');
            }
        );
        return $builder->get();
    }

    public function getDataMhs($where)
    {
        $builder = $this->table('dt_mahasiswa');
        $builder->select(
            'dt_mahasiswa."mahasiswaNamaLengkap" AS namaMhs,
        dt_mahasiswa."mahasiswaNpm" AS npmMhs,
        dt_fakultas."fakultasNama" as fakultasNama,
        dt_fakultas."fakultasKode" AS fakultasKode,
        pimpinan_fak."dosenGelarDepan" AS wd1GelarDepan,
        pimpinan_fak."dosenNama" AS wd1Nama,
        pimpinan_fak."dosenGelarBelakang" AS wd1GelarBelakang,
        pimpinan_prodi."dosenGelarDepan" AS kaprodiGelarDepan,
	    pimpinan_prodi."dosenNama" AS kaprodiNama,
	    pimpinan_prodi."dosenGelarBelakang" AS kaprodiGelarBelakang,
        dt_prodi."prodiNama" AS prodiNama,
        dt_program_kuliah."programKuliahNama" AS programKuliahNama,
        dt_dosen."dosenGelarDepan" AS paGelarDepan,
        dt_dosen."dosenNama" AS paNama,
        dt_dosen."dosenGelarBelakang" AS paGelarBelakang'
        );
        $builder->join('setting_rombel', 'setting_rombel."setRombelAngkatan" = dt_mahasiswa."mahasiswaAngkatan" AND setting_rombel."setRombelProdiProgramKuliahId" = dt_mahasiswa."mahasiswaProdiProgramKuliahId" AND setting_rombel."setRombelKelasId" = dt_mahasiswa."mahasiswaKelasId"', 'LEFT');
        $builder->join('setting_prodi_program_kuliah', 'setting_prodi_program_kuliah."setProdiProgramKuliahId" = dt_mahasiswa."mahasiswaProdiProgramKuliahId"', 'LEFT');
        $builder->join('dt_prodi', 'dt_prodi."prodiId" = setting_prodi_program_kuliah."setProdiProgramKuliahProdiId"', 'LEFT');
        $builder->join('dt_program_kuliah', 'dt_program_kuliah."programKuliahId" = setting_prodi_program_kuliah."setProdiProgramKuliahProgramKuliahId"', 'LEFT');
        $builder->join('dt_fakultas', 'dt_fakultas."fakultasId" = dt_prodi."prodiFakultasId"', 'LEFT');
        $builder->join('dt_dosen', 'dt_dosen."dosenId" = setting_rombel."setRombelDosenPA"', 'LEFT');
        $builder->join('dt_dosen pimpinan_fak', 'pimpinan_fak."dosenId" = dt_fakultas."fakultasWD1"', 'LEFT');
        $builder->join('dt_dosen pimpinan_prodi', 'pimpinan_prodi."dosenId" = dt_prodi."prodiKaprodi"', 'LEFT');
        $builder->where($where);
        return $builder;
    }
}
