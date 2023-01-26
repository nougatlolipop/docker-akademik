<?php

/* 
This is Controller NilaiProdi
 */

namespace Modules\NilaiProdi\Controllers;

use App\Controllers\BaseController;
use Modules\NilaiProdi\Models\NilaiProdiModel;
use Modules\Prodi\Models\ProdiModel;


class NilaiProdi extends BaseController
{
    protected $nilaiProdiModel;
    protected $prodiModel;
    protected $validation;

    public function __construct()
    {
        $this->nilaiProdiModel = new NilaiProdiModel();
        $this->prodiModel = new ProdiModel();
        $this->validation = \Config\Services::validation();
    }


    public function index()
    {
        $currentPage = $this->request->getVar('page_nilaiProdi') ? $this->request->getVar('page_nilaiProdi') : 1;
        $keyword = $this->request->getVar('keyword');
        if (in_groups('Fakultas')) {
            $fakultas = ['dt_fakultas."fakultasId"' => getUserDetail()[0]->fakultasId];
            $breadcrumb = ['Data', 'Nilai Prodi'];
        } else {
            $breadcrumb = ['Data', 'Aturan', 'Nilai Prodi'];
            $fakultas = null;
        }
        $prodi = $this->prodiModel->getProdi($fakultas, $keyword);

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Nilai Prodi",
            'breadcrumb' => $breadcrumb,
            'prodi' => $prodi->paginate($this->numberPage, 'nilaiProdi'),
            'nilaiProdi' => $this->nilaiProdiModel->getNilaiProdi()->findAll(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $this->prodiModel->pager,
            'validation' => \Config\Services::validation(),
        ];

        return view('Modules\NilaiProdi\Views\nilaiProdi', $data);
    }

    public function edit()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'gradeProdiNilaiBobot' => rv('required', ['required' => 'Bobot nilai prodi harus diisi']),
            'gradeProdiNilaiPredikat' => rv('required', ['required' => 'Predikat nilai prodi harus diisi']),
            'gradeProdiNilaiPredikatEng' => rv('required', ['required' => 'Predikat (Eng) nilai prodi harus diisi']),
            'gradeProdiNilaiSkalaMax' => rv('required', ['required' => 'Nilai max nilai prodi harus diisi']),
            'gradeProdiNilaiSkalaMin' => rv('required', ['required' => 'Nilai min prodi harus diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $id = $this->request->getVar('gradeProdiNilaiId');
        $gradeProdiNilaiProdiId = $this->request->getVar('gradeProdiNilaiProdiId');
        $gradeProdiNilaiGradeId = $this->request->getVar('gradeProdiNilaiGradeId');
        $gradeProdiNilaiBobot = $this->request->getVar('gradeProdiNilaiBobot');
        $gradeProdiNilaiPredikat = $this->request->getVar('gradeProdiNilaiPredikat');
        $gradeProdiNilaiPredikatEng = $this->request->getVar('gradeProdiNilaiPredikatEng');
        $gradeProdiNilaiSkalaMax = $this->request->getVar('gradeProdiNilaiSkalaMax');
        $gradeProdiNilaiSkalaMin = $this->request->getVar('gradeProdiNilaiSkalaMin');
        $gradeProdiNilaiModifiedBy = user()->email;
        $cekJlhField = count($id);

        for ($i = 0; $i < $cekJlhField; $i++) {
            $data = array(
                'gradeProdiNilaiId' => $id[$i],
                'gradeProdiNilaiProdiId' => $gradeProdiNilaiProdiId[$i],
                'gradeProdiNilaiGradeId' => $gradeProdiNilaiGradeId[$i],
                'gradeProdiNilaiBobot' => $gradeProdiNilaiBobot[$i],
                'gradeProdiNilaiPredikat' => $gradeProdiNilaiPredikat[$i],
                'gradeProdiNilaiPredikatEng' => $gradeProdiNilaiPredikatEng[$i],
                'gradeProdiNilaiSkalaMax' => $gradeProdiNilaiSkalaMax[$i],
                'gradeProdiNilaiSkalaMin' => $gradeProdiNilaiSkalaMin[$i],
                'gradeProdiNilaiModifiedBy' => $gradeProdiNilaiModifiedBy,
            );
            if ($this->nilaiProdiModel->update($id[$i], $data)) {
                session()->setFlashdata('success', 'Data Nilai Prodi Berhasil Diubah!');
            };
        }
        return redirect()->to($url);
    }
}
