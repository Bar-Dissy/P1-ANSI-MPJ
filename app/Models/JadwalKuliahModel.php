<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalKuliahModel extends Model
{
    protected $table = 'jadwal_kuliah';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_matkul', 'nama_matkul', 'sks', 'semester', 'hari', 
        'waktu_mulai', 'waktu_selesai', 'ruangan', 'dosen_id', 
        'program_studi_id', 'tahun_akademik', 'kelas', 'kuota', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function getJadwalKuliahWithRelations()
    {
        return $this->select('jadwal_kuliah.*, dosen.nama_lengkap as nama_dosen, program_studi.nama as nama_prodi')
            ->join('dosen', 'dosen.id = jadwal_kuliah.dosen_id')
            ->join('program_studi', 'program_studi.id = jadwal_kuliah.program_studi_id')
            ->where('jadwal_kuliah.deleted_at', null)
            ->findAll();
    }
}