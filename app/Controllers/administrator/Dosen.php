<?php

namespace App\Controllers\administrator;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\ProgramStudiModel;
use App\Models\JabatanDosenModel;

class Dosen extends BaseController
{
    protected $dosenModel;
    protected $prodiModel;
    protected $jabatanModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->prodiModel = new ProgramStudiModel();
        $this->jabatanModel = new JabatanDosenModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Dosen',
            'dosen' => $this->dosenModel->findAll(),
            'program_studi' => $this->prodiModel->findAll(),
            'jabatan_dosen' => $this->jabatanModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('administrator/v_dosen', $data);
    }

    public function tambah()
    {
        if (!$this->validate([
            'nidn' => [
                'rules' => 'required|is_unique[dosen.nidn]',
                'errors' => [
                    'required' => 'NIDN harus diisi',
                    'is_unique' => 'NIDN sudah terdaftar'
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[dosen.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ]
        ])) {
            return redirect()->to('administrator/dosen')->withInput();
        }

        // Handle file upload
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = 'default.jpg';

        if ($fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/dosen', $namaFoto);
        }

        $this->dosenModel->save([
            'nidn' => $this->request->getVar('nidn'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_telepon' => $this->request->getVar('no_telepon'),
            'email' => $this->request->getVar('email'),
            'program_studi' => $this->request->getVar('program_studi'),
            'pendidikan_terakhir' => $this->request->getVar('pendidikan_terakhir'),
            'jabatan' => $this->request->getVar('jabatan'),
            'bidang_keahlian' => $this->request->getVar('bidang_keahlian'),
            'foto' => $namaFoto
        ]);

        session()->setFlashdata('pesan', 'Data dosen berhasil ditambahkan.');
        return redirect()->to('administrator/dosen');
    }

    public function edit($id)
    {
        if (!$this->validate([
            'nidn' => [
                'rules' => "required|is_unique[dosen.nidn,id,$id]",
                'errors' => [
                    'required' => 'NIDN harus diisi',
                    'is_unique' => 'NIDN sudah terdaftar'
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi'
                ]
            ],
            'email' => [
                'rules' => "required|valid_email|is_unique[dosen.email,id,$id]",
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ]
        ])) {
            return redirect()->to('administrator/dosen')->withInput();
        }

        $dosen = $this->dosenModel->find($id);
        $namaFoto = $dosen['foto'];

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Hapus foto lama jika bukan default
            if ($namaFoto != 'default.jpg') {
                unlink('uploads/dosen/' . $namaFoto);
            }
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/dosen', $namaFoto);
        }

        $this->dosenModel->save([
            'id' => $id,
            'nidn' => $this->request->getVar('nidn'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_telepon' => $this->request->getVar('no_telepon'),
            'email' => $this->request->getVar('email'),
            'program_studi' => $this->request->getVar('program_studi'),
            'pendidikan_terakhir' => $this->request->getVar('pendidikan_terakhir'),
            'jabatan' => $this->request->getVar('jabatan'),
            'bidang_keahlian' => $this->request->getVar('bidang_keahlian'),
            'foto' => $namaFoto
        ]);

        session()->setFlashdata('pesan', 'Data dosen berhasil diubah.');
        return redirect()->to('administrator/dosen');
    }

    public function hapus($id)
    {
        $dosen = $this->dosenModel->find($id);
        
        // Hapus foto jika bukan default
        if ($dosen['foto'] != 'default.jpg') {
            unlink('uploads/dosen/' . $dosen['foto']);
        }

        $this->dosenModel->delete($id);
        session()->setFlashdata('pesan', 'Data dosen berhasil dihapus.');
        return redirect()->to('administrator/dosen');
    }
}