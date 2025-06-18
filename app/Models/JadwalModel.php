<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal_kuliah';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode_matkul', 'nama_matkul', 'sks', 'semester', 'hari', 
                               'waktu_mulai', 'waktu_selesai', 'ruangan', 'dosen_id', 
                               'program_studi_id', 'tahun_akademik', 'kelas', 'kuota', 'status'];

    public function getJadwalByProdiSemester($prodi_id, $semester)
    {
        return $this->db->table('jadwal_kuliah j')
            ->select('j.*, d.nama_lengkap as nama_dosen')
            ->join('dosen d', 'd.id = j.dosen_id')
            ->where('j.program_studi_id', $prodi_id)
            ->where('j.semester', $semester)
            ->where('j.status', 'Aktif')
            ->get()
            ->getResultArray();
    }

    public function getJadwal()
    {
        return $this->db->table('jadwal_kuliah j')
            ->select('j.*, d.nama_lengkap as nama_dosen')
            ->join('dosen d', 'd.id = j.dosen_id')
            ->where('j.status', 'Aktif')
            ->get()
            ->getResultArray();
    }

    public function getFilteredJadwal($prodi_id = null, $semester = null, $kelas = null)
    {
        $builder = $this->db->table('jadwal_kuliah j')
            ->select('j.*, d.nama_lengkap as nama_dosen')
            ->join('dosen d', 'd.id = j.dosen_id')
            ->where('j.status', 'Aktif');

        if ($prodi_id) {
            $builder->where('j.program_studi_id', $prodi_id);
        }

        if ($semester) {
            $builder->where('j.semester', $semester);
        }

        if ($kelas) {
            $builder->where('j.kelas', $kelas);
        }

        return $builder->get()->getResultArray();
    }

    public function getDistinctClasses()
    {
        return $this->db->table('jadwal_kuliah')
            ->select('kelas')
            ->distinct()
            ->where('status', 'Aktif')
            ->orderBy('kelas')
            ->get()
            ->getResultArray();
    }
}