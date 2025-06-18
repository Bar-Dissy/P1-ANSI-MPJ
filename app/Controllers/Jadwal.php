<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\JadwalModel;
use App\Models\ProgramStudiModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $prodiModel;
    
    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->prodiModel = new ProgramStudiModel();
    }
    
    public function index()
    {
        $data['title'] = 'Jadwal Perkuliahan';
        
        // Ambil semua program studi untuk dropdown
        $data['program_studi'] = $this->prodiModel->findAll();
        
        // Ambil parameter dari request (jika ada)
        $prodi_id = $this->request->getGet('prodi_id');
        $semester = $this->request->getGet('semester');
        $kelas = $this->request->getGet('kelas');
        
        // Jika ada filter, ambil jadwal sesuai filter
        if ($prodi_id || $semester || $kelas) {
            $data['jadwal'] = $this->jadwalModel->getFilteredJadwal($prodi_id, $semester, $kelas);
            $data['prodi_id'] = $prodi_id;
            $data['semester'] = $semester;
            $data['kelas'] = $kelas;
        } else {
            // Jika tidak ada filter, ambil semua jadwal
            $data['jadwal'] = $this->jadwalModel->getJadwal();
            $data['prodi_id'] = null;
            $data['semester'] = null;
            $data['kelas'] = null;
        }
        
        // Get unique class options for dropdown
        $data['kelas_options'] = $this->jadwalModel->getDistinctClasses();
        
        return view('v_jadwal', $data);
    }
}