<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\JadwalKuliahModel;
use App\Models\DosenModel;
use App\Models\ProgramStudiModel;

class Mahasiswa extends BaseController
{
    protected $mahasiswaModel;
    protected $jadwalKuliahModel;
    protected $dosenModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->jadwalKuliahModel = new JadwalKuliahModel();
        $this->dosenModel = new DosenModel();
        $this->prodiModel = new ProgramStudiModel();
    }

    public function index()
    {
        // Get logged in student data
        $mahasiswa_id = session()->get('related_id');
        $mahasiswa = $this->mahasiswaModel->find($mahasiswa_id);

        if (!$mahasiswa) {
            return redirect()->to('/auth/logout');
        }

        // Get program study ID based on student's program study name
        $prodi = $this->prodiModel->where('nama', $mahasiswa['program_studi'])->first();

        if (!$prodi) {
            return redirect()->back()->with('error', 'Program studi tidak ditemukan');
        }

        // Use student's current semester from database
        $semester_aktif = $mahasiswa['semester'] ?? $this->calculateCurrentSemester($mahasiswa['angkatan']);
        $kelas = $mahasiswa['kelas'] ?? 'Reguler'; // Default to 'Reguler' if class not set

        // Get schedule for current semester and class
        $jadwal_kuliah = $this->jadwalKuliahModel
            ->select('jadwal_kuliah.*, dosen.nama_lengkap as nama_dosen')
            ->join('dosen', 'dosen.id = jadwal_kuliah.dosen_id')
            ->where('jadwal_kuliah.program_studi_id', $prodi['id'])
            ->where('jadwal_kuliah.semester', $semester_aktif)
            ->where('jadwal_kuliah.kelas', $kelas) // Filter by student's class
            ->where('jadwal_kuliah.status', 'Aktif')
            ->where('jadwal_kuliah.deleted_at', null)
            ->orderBy('hari, waktu_mulai') // Sort by day and time
            ->findAll();

        $data = [
            'title' => 'Dashboard Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'semester_aktif' => $semester_aktif,
            'jadwal_kuliah' => $jadwal_kuliah
        ];

        return view('v_mahasiswa', $data);
    }

    protected function calculateCurrentSemester($angkatan)
    {
        $tahun_sekarang = date('Y');
        $tahun_masuk = $angkatan;
        $semester = (($tahun_sekarang - $tahun_masuk) * 2) + (date('m') > 6 ? 2 : 1);
        
        // Ensure semester doesn't exceed 8 (for undergraduate programs)
        return min($semester, 8);
    }
}