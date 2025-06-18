<?php

namespace App\Controllers\administrator;

use App\Controllers\BaseController;
use App\Models\MataKuliahModel;
use App\Models\ProgramStudiModel;

class MataKuliah extends BaseController
{
    protected $mataKuliahModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->mataKuliahModel = new MataKuliahModel();
        $this->prodiModel = new ProgramStudiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Mata Kuliah',
            'mata_kuliah' => $this->mataKuliahModel->getMataKuliah(),
            'program_studi' => $this->prodiModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('administrator/v_mata_kuliah', $data);
    }

    public function tambah()
    {
        if (!$this->validate([
            'kode_matkul' => [
                'rules' => 'required|is_unique[mata_kuliah.kode_matkul]|max_length[10]',
                'errors' => [
                    'required' => 'Kode mata kuliah harus diisi',
                    'is_unique' => 'Kode mata kuliah sudah terdaftar',
                    'max_length' => 'Kode mata kuliah maksimal 10 karakter'
                ]
            ],
            'nama_matkul' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama mata kuliah harus diisi',
                    'max_length' => 'Nama mata kuliah maksimal 100 karakter'
                ]
            ],
            'sks' => [
                'rules' => 'required|integer|greater_than[0]|less_than_equal_to[6]',
                'errors' => [
                    'required' => 'SKS harus diisi',
                    'integer' => 'SKS harus berupa angka',
                    'greater_than' => 'SKS minimal 1',
                    'less_than_equal_to' => 'SKS maksimal 6'
                ]
            ],
            'semester' => [
                'rules' => 'required|integer|greater_than[0]|less_than_equal_to[8]',
                'errors' => [
                    'required' => 'Semester harus diisi',
                    'integer' => 'Semester harus berupa angka',
                    'greater_than' => 'Semester minimal 1',
                    'less_than_equal_to' => 'Semester maksimal 8'
                ]
            ],
            'program_studi_id' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Program studi harus dipilih',
                    'integer' => 'Program studi tidak valid'
                ]
            ]
        ])) {
            return redirect()->to('administrator/mata-kuliah')->withInput();
        }

        $this->mataKuliahModel->save([
            'kode_matkul' => $this->request->getVar('kode_matkul'),
            'nama_matkul' => $this->request->getVar('nama_matkul'),
            'sks' => $this->request->getVar('sks'),
            'semester' => $this->request->getVar('semester'),
            'program_studi_id' => $this->request->getVar('program_studi_id'),
            'deskripsi' => $this->request->getVar('deskripsi')
        ]);

        session()->setFlashdata('pesan', 'Data mata kuliah berhasil ditambahkan.');
        return redirect()->to('administrator/mata-kuliah');
    }

    public function edit($id)
    {
        if (!$this->validate([
            'kode_matkul' => [
                'rules' => "required|is_unique[mata_kuliah.kode_matkul,id,$id]|max_length[10]",
                'errors' => [
                    'required' => 'Kode mata kuliah harus diisi',
                    'is_unique' => 'Kode mata kuliah sudah terdaftar',
                    'max_length' => 'Kode mata kuliah maksimal 10 karakter'
                ]
            ],
            'nama_matkul' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama mata kuliah harus diisi',
                    'max_length' => 'Nama mata kuliah maksimal 100 karakter'
                ]
            ],
            'sks' => [
                'rules' => 'required|integer|greater_than[0]|less_than_equal_to[6]',
                'errors' => [
                    'required' => 'SKS harus diisi',
                    'integer' => 'SKS harus berupa angka',
                    'greater_than' => 'SKS minimal 1',
                    'less_than_equal_to' => 'SKS maksimal 6'
                ]
            ],
            'semester' => [
                'rules' => 'required|integer|greater_than[0]|less_than_equal_to[8]',
                'errors' => [
                    'required' => 'Semester harus diisi',
                    'integer' => 'Semester harus berupa angka',
                    'greater_than' => 'Semester minimal 1',
                    'less_than_equal_to' => 'Semester maksimal 8'
                ]
            ],
            'program_studi_id' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Program studi harus dipilih',
                    'integer' => 'Program studi tidak valid'
                ]
            ]
        ])) {
            return redirect()->to('administrator/mata-kuliah')->withInput();
        }

        $this->mataKuliahModel->save([
            'id' => $id,
            'kode_matkul' => $this->request->getVar('kode_matkul'),
            'nama_matkul' => $this->request->getVar('nama_matkul'),
            'sks' => $this->request->getVar('sks'),
            'semester' => $this->request->getVar('semester'),
            'program_studi_id' => $this->request->getVar('program_studi_id'),
            'deskripsi' => $this->request->getVar('deskripsi')
        ]);

        session()->setFlashdata('pesan', 'Data mata kuliah berhasil diubah.');
        return redirect()->to('administrator/mata-kuliah');
    }

    public function hapus($id)
    {
        $this->mataKuliahModel->delete($id);
        session()->setFlashdata('pesan', 'Data mata kuliah berhasil dihapus.');
        return redirect()->to('administrator/mata-kuliah');
    }

    public function getMataKuliahByProdi($prodiId)
    {
        $mataKuliah = $this->mataKuliahModel->where('program_studi_id', $prodiId)->findAll();
        return $this->response->setJSON($mataKuliah);
    }
}