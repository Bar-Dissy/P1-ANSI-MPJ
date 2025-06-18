<?php

namespace App\Controllers\administrator;

use App\Controllers\BaseController;
use App\Models\JadwalKuliahModel;
use App\Models\MataKuliahModel;
use App\Models\DosenModel;
use App\Models\ProgramStudiModel;

class JadwalKuliah extends BaseController
{
    protected $jadwalKuliahModel;
    protected $mataKuliahModel;
    protected $dosenModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->jadwalKuliahModel = new JadwalKuliahModel();
        $this->mataKuliahModel = new MataKuliahModel();
        $this->dosenModel = new DosenModel();
        $this->prodiModel = new ProgramStudiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Jadwal Kuliah',
            'jadwal_kuliah' => $this->jadwalKuliahModel->getJadwalKuliahWithRelations(),
            'mata_kuliah' => $this->mataKuliahModel->findAll(),
            'dosen' => $this->dosenModel->findAll(),
            'program_studi' => $this->prodiModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('administrator/v_jadwal_kuliah', $data);
    }

    public function tambah()
    {
        if (!$this->validate([
            'kode_matkul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mata kuliah harus dipilih'
                ]
            ],
            'hari' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Hari harus dipilih'
                ]
            ],
            'waktu_mulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu mulai harus diisi'
                ]
            ],
            'waktu_selesai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu selesai harus diisi'
                ]
            ],
            'ruangan' => [
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => 'Ruangan harus diisi',
                    'max_length' => 'Ruangan maksimal 20 karakter'
                ]
            ],
            'dosen_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dosen harus dipilih'
                ]
            ],
            'program_studi_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Program studi harus dipilih'
                ]
            ],
            'tahun_akademik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun akademik harus diisi'
                ]
            ]
        ])) {
            return redirect()->to('administrator/jadwal-kuliah')->withInput();
        }

        // Cek duplikasi jadwal
        $duplicateCheck = $this->checkDuplicateSchedule(
            $this->request->getVar('kode_matkul'),
            $this->request->getVar('hari'),
            $this->request->getVar('waktu_mulai'),
            $this->request->getVar('waktu_selesai'),
            $this->request->getVar('ruangan'),
            $this->request->getVar('dosen_id'),
            $this->request->getVar('program_studi_id'),
            $this->request->getVar('tahun_akademik'),
            $this->request->getVar('kelas') ?? 'Reguler'
        );

        if ($duplicateCheck['duplicate']) {
            session()->setFlashdata('error', $duplicateCheck['message']);
            return redirect()->to('administrator/jadwal-kuliah')->withInput();
        }

        // Get mata kuliah data
        $mataKuliah = $this->mataKuliahModel->where('kode_matkul', $this->request->getVar('kode_matkul'))->first();

        $this->jadwalKuliahModel->save([
            'kode_matkul' => $this->request->getVar('kode_matkul'),
            'nama_matkul' => $mataKuliah['nama_matkul'],
            'sks' => $mataKuliah['sks'],
            'semester' => $mataKuliah['semester'],
            'hari' => $this->request->getVar('hari'),
            'waktu_mulai' => $this->request->getVar('waktu_mulai'),
            'waktu_selesai' => $this->request->getVar('waktu_selesai'),
            'ruangan' => $this->request->getVar('ruangan'),
            'dosen_id' => $this->request->getVar('dosen_id'),
            'program_studi_id' => $this->request->getVar('program_studi_id'),
            'tahun_akademik' => $this->request->getVar('tahun_akademik'),
            'kelas' => $this->request->getVar('kelas') ?? 'Reguler',
            'kuota' => $this->request->getVar('kuota') ?? 40,
            'status' => 'Aktif'
        ]);

        session()->setFlashdata('pesan', 'Jadwal kuliah berhasil ditambahkan.');
        return redirect()->to('administrator/jadwal-kuliah');
    }

    public function edit($id)
    {
        if (!$this->validate([
            'kode_matkul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mata kuliah harus dipilih'
                ]
            ],
            'hari' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Hari harus dipilih'
                ]
            ],
            'waktu_mulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu mulai harus diisi'
                ]
            ],
            'waktu_selesai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu selesai harus diisi'
                ]
            ],
            'ruangan' => [
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => 'Ruangan harus diisi',
                    'max_length' => 'Ruangan maksimal 20 karakter'
                ]
            ],
            'dosen_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dosen harus dipilih'
                ]
            ],
            'program_studi_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Program studi harus dipilih'
                ]
            ],
            'tahun_akademik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun akademik harus diisi'
                ]
            ]
        ])) {
            return redirect()->to('administrator/jadwal-kuliah')->withInput();
        }

        // Cek duplikasi jadwal (exclude current record)
        $duplicateCheck = $this->checkDuplicateSchedule(
            $this->request->getVar('kode_matkul'),
            $this->request->getVar('hari'),
            $this->request->getVar('waktu_mulai'),
            $this->request->getVar('waktu_selesai'),
            $this->request->getVar('ruangan'),
            $this->request->getVar('dosen_id'),
            $this->request->getVar('program_studi_id'),
            $this->request->getVar('tahun_akademik'),
            $this->request->getVar('kelas') ?? 'Reguler',
            $id // exclude current record
        );

        if ($duplicateCheck['duplicate']) {
            session()->setFlashdata('error', $duplicateCheck['message']);
            return redirect()->to('administrator/jadwal-kuliah')->withInput();
        }

        // Get mata kuliah data
        $mataKuliah = $this->mataKuliahModel->where('kode_matkul', $this->request->getVar('kode_matkul'))->first();

        $this->jadwalKuliahModel->save([
            'id' => $id,
            'kode_matkul' => $this->request->getVar('kode_matkul'),
            'nama_matkul' => $mataKuliah['nama_matkul'],
            'sks' => $mataKuliah['sks'],
            'semester' => $mataKuliah['semester'],
            'hari' => $this->request->getVar('hari'),
            'waktu_mulai' => $this->request->getVar('waktu_mulai'),
            'waktu_selesai' => $this->request->getVar('waktu_selesai'),
            'ruangan' => $this->request->getVar('ruangan'),
            'dosen_id' => $this->request->getVar('dosen_id'),
            'program_studi_id' => $this->request->getVar('program_studi_id'),
            'tahun_akademik' => $this->request->getVar('tahun_akademik'),
            'kelas' => $this->request->getVar('kelas') ?? 'Reguler',
            'kuota' => $this->request->getVar('kuota') ?? 40,
            'status' => $this->request->getVar('status') ?? 'Aktif'
        ]);

        session()->setFlashdata('pesan', 'Jadwal kuliah berhasil diubah.');
        return redirect()->to('administrator/jadwal-kuliah');
    }

    public function hapus($id)
    {
        $this->jadwalKuliahModel->delete($id);
        session()->setFlashdata('pesan', 'Jadwal kuliah berhasil dihapus.');
        return redirect()->to('administrator/jadwal-kuliah');
    }

    /**
     * Check for duplicate schedule
     */
    private function checkDuplicateSchedule($kode_matkul, $hari, $waktu_mulai, $waktu_selesai, $ruangan, $dosen_id, $program_studi_id, $tahun_akademik, $kelas, $excludeId = null)
    {
        $builder = $this->jadwalKuliahModel->builder();
        
        // Check for exact duplicate (all fields match)
        $builder->where([
            'kode_matkul' => $kode_matkul,
            'hari' => $hari,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'ruangan' => $ruangan,
            'dosen_id' => $dosen_id,
            'program_studi_id' => $program_studi_id,
            'tahun_akademik' => $tahun_akademik,
            'kelas' => $kelas,
            'deleted_at' => null
        ]);
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        $exactDuplicate = $builder->get()->getRow();
        
        if ($exactDuplicate) {
            return [
                'duplicate' => true,
                'message' => 'Jadwal kuliah sudah ada! Kombinasi mata kuliah, hari, waktu, ruangan, dosen, program studi, tahun akademik, dan kelas yang sama sudah terdaftar.'
            ];
        }

        // Reset builder for conflict checks
        $builder = $this->jadwalKuliahModel->builder();
        
        // Check for time and room conflict (same room, day, overlapping time)
        $builder->where([
            'hari' => $hari,
            'ruangan' => $ruangan,
            'tahun_akademik' => $tahun_akademik,
            'deleted_at' => null
        ]);
        
        // Check for time overlap
        $builder->groupStart()
            ->where("(waktu_mulai <= '$waktu_mulai' AND waktu_selesai > '$waktu_mulai')")
            ->orWhere("(waktu_mulai < '$waktu_selesai' AND waktu_selesai >= '$waktu_selesai')")
            ->orWhere("(waktu_mulai >= '$waktu_mulai' AND waktu_selesai <= '$waktu_selesai')")
        ->groupEnd();
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        $roomConflict = $builder->get()->getRow();
        
        if ($roomConflict) {
            return [
                'duplicate' => true,
                'message' => 'Konflik jadwal ruangan! Ruangan ' . $ruangan . ' sudah digunakan pada hari ' . $hari . ' di waktu yang bertabrakan (' . $roomConflict->waktu_mulai . ' - ' . $roomConflict->waktu_selesai . ').'
            ];
        }

        // Reset builder for lecturer conflict
        $builder = $this->jadwalKuliahModel->builder();
        
        // Check for lecturer conflict (same lecturer, day, overlapping time)
        $builder->where([
            'hari' => $hari,
            'dosen_id' => $dosen_id,
            'tahun_akademik' => $tahun_akademik,
            'deleted_at' => null
        ]);
        
        // Check for time overlap
        $builder->groupStart()
            ->where("(waktu_mulai <= '$waktu_mulai' AND waktu_selesai > '$waktu_mulai')")
            ->orWhere("(waktu_mulai < '$waktu_selesai' AND waktu_selesai >= '$waktu_selesai')")
            ->orWhere("(waktu_mulai >= '$waktu_mulai' AND waktu_selesai <= '$waktu_selesai')")
        ->groupEnd();
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        $lecturerConflict = $builder->get()->getRow();
        
        if ($lecturerConflict) {
            // Get lecturer name
            $dosen = $this->dosenModel->find($dosen_id);
            return [
                'duplicate' => true,
                'message' => 'Konflik jadwal dosen! Dosen ' . $dosen['nama_lengkap'] . ' sudah mengajar pada hari ' . $hari . ' di waktu yang bertabrakan (' . $lecturerConflict->waktu_mulai . ' - ' . $lecturerConflict->waktu_selesai . ').'
            ];
        }

        return [
            'duplicate' => false,
            'message' => ''
        ];
    }

    public function getMataKuliahByProdi($prodiId)
    {
        $mataKuliah = $this->mataKuliahModel->where('program_studi_id', $prodiId)->findAll();
        
        // Kembalikan dalam format yang diharapkan oleh frontend
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $mataKuliah
        ]);
    }

    public function getDosenByProdi($prodiId)
    {
        $dosen = $this->dosenModel->where('program_studi', $prodiId)->findAll();
        
        // Kembalikan dalam format yang diharapkan oleh frontend
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $dosen
        ]);
    }
}