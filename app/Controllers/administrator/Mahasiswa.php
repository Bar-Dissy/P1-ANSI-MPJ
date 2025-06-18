<?php

namespace App\Controllers\administrator;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;

class Mahasiswa extends BaseController
{
    protected $mahasiswaModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->prodiModel = new ProgramStudiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Mahasiswa',
            'mahasiswa' => $this->mahasiswaModel->findAll(),
            'program_studi' => $this->prodiModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('administrator/v_mahasiswa', $data);
    }

    public function tambah()
    {
        if (!$this->validate([
            'nim' => [
                'rules' => 'required|is_unique[mahasiswa.nim]',
                'errors' => [
                    'required' => 'NIM harus diisi',
                    'is_unique' => 'NIM sudah terdaftar, silakan gunakan NIM yang berbeda'
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi'
                ]
            ],
            'semester' => [
                'rules' => 'required|numeric|greater_than[0]|less_than[9]',
                'errors' => [
                    'required' => 'Semester harus diisi',
                    'numeric' => 'Semester harus berupa angka',
                    'greater_than' => 'Semester minimal 1',
                    'less_than' => 'Semester maksimal 8'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis kelamin harus dipilih'
                ]
            ],
            'tempat_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tempat lahir harus diisi'
                ]
            ],
            'tanggal_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal lahir harus diisi'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi'
                ]
            ],
            'no_telepon' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'No. telepon harus diisi',
                    'numeric' => 'No. telepon harus berupa angka'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[mahasiswa.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'program_studi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Program studi harus dipilih'
                ]
            ],
            'angkatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Angkatan harus dipilih'
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status harus dipilih'
                ]
            ]
        ])) {
            // Set flash message untuk error validasi
            session()->setFlashdata('errors', $this->validator->getErrors());
            session()->setFlashdata('old_input', $this->request->getPost());
            return redirect()->to('administrator/mahasiswa')->withInput();
        }

        // Handle file upload
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = 'default.jpg';

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Validasi file foto
            if ($fileFoto->getSize() > 2097152) { // 2MB
                session()->setFlashdata('error', 'Ukuran file foto maksimal 2MB');
                return redirect()->to('administrator/mahasiswa')->withInput();
            }
            
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($fileFoto->getMimeType(), $allowedTypes)) {
                session()->setFlashdata('error', 'Format file foto harus JPG atau PNG');
                return redirect()->to('administrator/mahasiswa')->withInput();
            }

            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/mahasiswa', $namaFoto);
        }

        $this->mahasiswaModel->save([
            'nim' => $this->request->getVar('nim'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_telepon' => $this->request->getVar('no_telepon'),
            'email' => $this->request->getVar('email'),
            'program_studi' => $this->request->getVar('program_studi'),
            'angkatan' => $this->request->getVar('angkatan'),
            'semester' => $this->request->getVar('semester'),
            'kelas' => $this->request->getVar('kelas'),
            'status' => $this->request->getVar('status'),
            'foto' => $namaFoto
        ]);

        session()->setFlashdata('pesan', 'Data mahasiswa berhasil ditambahkan.');
        return redirect()->to('administrator/mahasiswa');
    }

    public function edit($id)
    {
        if (!$this->validate([
            'nim' => [
                'rules' => "required|is_unique[mahasiswa.nim,id,$id]",
                'errors' => [
                    'required' => 'NIM harus diisi',
                    'is_unique' => 'NIM sudah terdaftar, silakan gunakan NIM yang berbeda'
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi'
                ]
            ],
            'semester' => [
                'rules' => 'required|numeric|greater_than[0]|less_than[9]',
                'errors' => [
                    'required' => 'Semester harus diisi',
                    'numeric' => 'Semester harus berupa angka',
                    'greater_than' => 'Semester minimal 1',
                    'less_than' => 'Semester maksimal 8'
                ]
            ],
            'email' => [
                'rules' => "required|valid_email|is_unique[mahasiswa.email,id,$id]",
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ]
        ])) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            session()->setFlashdata('old_input', $this->request->getPost());
            return redirect()->to('administrator/mahasiswa')->withInput();
        }

        $mahasiswa = $this->mahasiswaModel->find($id);
        $namaFoto = $mahasiswa['foto'];

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Validasi file foto
            if ($fileFoto->getSize() > 2097152) { // 2MB
                session()->setFlashdata('error', 'Ukuran file foto maksimal 2MB');
                return redirect()->to('administrator/mahasiswa')->withInput();
            }
            
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($fileFoto->getMimeType(), $allowedTypes)) {
                session()->setFlashdata('error', 'Format file foto harus JPG atau PNG');
                return redirect()->to('administrator/mahasiswa')->withInput();
            }

            // Hapus foto lama jika bukan default
            if ($namaFoto != 'default.jpg' && file_exists('uploads/mahasiswa/' . $namaFoto)) {
                unlink('uploads/mahasiswa/' . $namaFoto);
            }
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/mahasiswa', $namaFoto);
        }

        $this->mahasiswaModel->save([
            'id' => $id,
            'nim' => $this->request->getVar('nim'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_telepon' => $this->request->getVar('no_telepon'),
            'email' => $this->request->getVar('email'),
            'program_studi' => $this->request->getVar('program_studi'),
            'semester' => $this->request->getVar('semester'),
            'kelas' => $this->request->getVar('kelas'),
            'angkatan' => $this->request->getVar('angkatan'),
            'status' => $this->request->getVar('status'),
            'foto' => $namaFoto
        ]);

        session()->setFlashdata('pesan', 'Data mahasiswa berhasil diubah.');
        return redirect()->to('administrator/mahasiswa');
    }

    public function hapus($id)
    {
        $mahasiswa = $this->mahasiswaModel->find($id);
        
        if (!$mahasiswa) {
            session()->setFlashdata('error', 'Data mahasiswa tidak ditemukan.');
            return redirect()->to('administrator/mahasiswa');
        }
        
        // Hapus foto jika bukan default
        if ($mahasiswa['foto'] != 'default.jpg' && file_exists('uploads/mahasiswa/' . $mahasiswa['foto'])) {
            unlink('uploads/mahasiswa/' . $mahasiswa['foto']);
        }

        $this->mahasiswaModel->delete($id);
        session()->setFlashdata('pesan', 'Data mahasiswa berhasil dihapus.');
        return redirect()->to('administrator/mahasiswa');
    }
}