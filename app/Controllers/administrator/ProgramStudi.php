<?php

namespace App\Controllers\administrator;

use App\Controllers\BaseController;
use App\Models\ProgramStudiModel;

class ProgramStudi extends BaseController
{
    protected $programStudiModel;

    public function __construct()
    {
        $this->programStudiModel = new ProgramStudiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Program Studi',
            'program_studi' => $this->programStudiModel->findAll()
        ];

        return view('administrator/v_program_studi', $data);
    }

    public function tambah()
    {
        $rules = [
            'kode' => [
                'rules' => 'required|min_length[2]|max_length[10]|is_unique[program_studi.kode]',
                'errors' => [
                    'required' => 'Kode program studi harus diisi',
                    'min_length' => 'Kode program studi minimal 2 karakter',
                    'max_length' => 'Kode program studi maksimal 10 karakter',
                    'is_unique' => 'Kode program studi sudah ada'
                ]
            ],
            'nama' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama program studi harus diisi',
                    'min_length' => 'Nama program studi minimal 3 karakter',
                    'max_length' => 'Nama program studi maksimal 100 karakter'
                ]
            ],
            'jenjang' => [
                'rules' => 'required|in_list[D3,S1,S2,S3]',
                'errors' => [
                    'required' => 'Jenjang harus dipilih',
                    'in_list' => 'Jenjang tidak valid'
                ]
            ],
            'ketua_prodi' => [
                'rules' => 'permit_empty|max_length[100]',
                'errors' => [
                    'max_length' => 'Nama ketua prodi maksimal 100 karakter'
                ]
            ],
            'tahun_berdiri' => [
                'rules' => 'permit_empty|integer|greater_than[1900]|less_than_equal_to[' . date('Y') . ']',
                'errors' => [
                    'integer' => 'Tahun berdiri harus berupa angka',
                    'greater_than' => 'Tahun berdiri tidak valid',
                    'less_than_equal_to' => 'Tahun berdiri tidak boleh lebih dari tahun sekarang'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Data tidak valid. Silakan periksa kembali form Anda.');
            session()->setFlashdata('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        $data = [
            'kode' => strtoupper($this->request->getPost('kode')),
            'nama' => $this->request->getPost('nama'),
            'jenjang' => $this->request->getPost('jenjang'),
            'ketua_prodi' => $this->request->getPost('ketua_prodi'),
            'tahun_berdiri' => $this->request->getPost('tahun_berdiri') ?: null
        ];

        if ($this->programStudiModel->insert($data)) {
            session()->setFlashdata('pesan', 'Data program studi berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data program studi');
        }

        return redirect()->to(base_url('administrator/program-studi'));
    }

    public function edit($id)
    {
        $programStudi = $this->programStudiModel->find($id);
        
        if (!$programStudi) {
            session()->setFlashdata('error', 'Data program studi tidak ditemukan');
            return redirect()->to(base_url('administrator/program-studi'));
        }

        $rules = [
            'kode' => [
                'rules' => 'required|min_length[2]|max_length[10]|is_unique[program_studi.kode,id,' . $id . ']',
                'errors' => [
                    'required' => 'Kode program studi harus diisi',
                    'min_length' => 'Kode program studi minimal 2 karakter',
                    'max_length' => 'Kode program studi maksimal 10 karakter',
                    'is_unique' => 'Kode program studi sudah ada'
                ]
            ],
            'nama' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama program studi harus diisi',
                    'min_length' => 'Nama program studi minimal 3 karakter',
                    'max_length' => 'Nama program studi maksimal 100 karakter'
                ]
            ],
            'jenjang' => [
                'rules' => 'required|in_list[D3,S1,S2,S3]',
                'errors' => [
                    'required' => 'Jenjang harus dipilih',
                    'in_list' => 'Jenjang tidak valid'
                ]
            ],
            'ketua_prodi' => [
                'rules' => 'permit_empty|max_length[100]',
                'errors' => [
                    'max_length' => 'Nama ketua prodi maksimal 100 karakter'
                ]
            ],
            'tahun_berdiri' => [
                'rules' => 'permit_empty|integer|greater_than[1900]|less_than_equal_to[' . date('Y') . ']',
                'errors' => [
                    'integer' => 'Tahun berdiri harus berupa angka',
                    'greater_than' => 'Tahun berdiri tidak valid',
                    'less_than_equal_to' => 'Tahun berdiri tidak boleh lebih dari tahun sekarang'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Data tidak valid. Silakan periksa kembali form Anda.');
            return redirect()->back()->withInput();
        }

        $data = [
            'kode' => strtoupper($this->request->getPost('kode')),
            'nama' => $this->request->getPost('nama'),
            'jenjang' => $this->request->getPost('jenjang'),
            'ketua_prodi' => $this->request->getPost('ketua_prodi'),
            'tahun_berdiri' => $this->request->getPost('tahun_berdiri') ?: null
        ];

        if ($this->programStudiModel->update($id, $data)) {
            session()->setFlashdata('pesan', 'Data program studi berhasil diupdate');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate data program studi');
        }

        return redirect()->to(base_url('administrator/program-studi'));
    }

    public function hapus($id)
    {
        $programStudi = $this->programStudiModel->find($id);
        
        if (!$programStudi) {
            session()->setFlashdata('error', 'Data program studi tidak ditemukan');
            return redirect()->to(base_url('administrator/program-studi'));
        }

        // Cek apakah program studi masih digunakan di tabel lain
        $db = \Config\Database::connect();
        
        // Cek di tabel mata_kuliah
        $mataKuliahCount = $db->table('mata_kuliah')
            ->where('program_studi_id', $id)
            ->where('deleted_at IS NULL')
            ->countAllResults();
        
        // Cek di tabel jadwal_kuliah
        $jadwalKuliahCount = $db->table('jadwal_kuliah')
            ->where('program_studi_id', $id)
            ->where('deleted_at IS NULL')
            ->countAllResults();

        // Cek di tabel mahasiswa (menggunakan nama program studi)
        $mahasiswaCount = $db->table('mahasiswa')
            ->where('program_studi', $programStudi['nama'])
            ->where('deleted_at IS NULL')
            ->countAllResults();

        if ($mataKuliahCount > 0 || $jadwalKuliahCount > 0 || $mahasiswaCount > 0) {
            session()->setFlashdata('error', 'Program studi tidak dapat dihapus karena masih digunakan dalam mata kuliah, jadwal kuliah, atau mahasiswa');
            return redirect()->to(base_url('administrator/program-studi'));
        }

        if ($this->programStudiModel->delete($id)) {
            session()->setFlashdata('pesan', 'Data program studi berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data program studi');
        }

        return redirect()->to(base_url('administrator/program-studi'));
    }

    public function detail($id)
    {
        $programStudi = $this->programStudiModel->find($id);
        
        if (!$programStudi) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data program studi tidak ditemukan'
            ]);
        }

        // Statistik program studi
        $db = \Config\Database::connect();
        
        $stats = [
            'mata_kuliah' => $db->table('mata_kuliah')
                ->where('program_studi_id', $id)
                ->where('deleted_at IS NULL')
                ->countAllResults(),
            'jadwal_kuliah' => $db->table('jadwal_kuliah')
                ->where('program_studi_id', $id)
                ->where('deleted_at IS NULL')
                ->countAllResults(),
            // Fixed: Use the program study name to match mahasiswa records
            'mahasiswa' => $db->table('mahasiswa')
                ->where('program_studi', $programStudi['nama'])
                ->where('deleted_at IS NULL')
                ->countAllResults()
        ];

        return $this->response->setJSON([
            'success' => true,
            'data' => $programStudi,
            'stats' => $stats
        ]);
    }
}