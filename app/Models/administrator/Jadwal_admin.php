<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table      = 'jadwal';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['mk_id', 'dosen_id', 'ruangan_id', 'tahun_akademik_id', 'hari', 'jam_mulai', 'jam_selesai', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    
    /**
     * Mendapatkan data jadwal dengan informasi lengkap (join dengan tabel terkait)
     *
     * @param array $filter Filter data yang diinginkan
     * @return array
     */
    public function getJadwalLengkap($filter = [])
    {
        $builder = $this->db->table('jadwal j');
        $builder->select('j.id, j.hari, j.jam_mulai, j.jam_selesai, j.status as status_jadwal, 
                         mk.kode_mk, mk.nama_mk, mk.sks, 
                         d.nama as nama_dosen, d.gelar, 
                         r.kode as kode_ruangan, r.nama as nama_ruangan, r.kapasitas,
                         ta.nama as tahun_akademik, ta.semester');
        $builder->join('mata_kuliah mk', 'j.mk_id = mk.id');
        $builder->join('dosen d', 'j.dosen_id = d.id');
        $builder->join('ruangan r', 'j.ruangan_id = r.id');
        $builder->join('tahun_akademik ta', 'j.tahun_akademik_id = ta.id');
        
        // Filter berdasarkan status jadwal
        if (isset($filter['status'])) {
            $builder->where('j.status', $filter['status']);
        }
        
        // Filter berdasarkan semester aktif
        if (isset($filter['semester_aktif']) && $filter['semester_aktif']) {
            $builder->where('ta.status', 'aktif');
        }
        
        // Filter berdasarkan tahun akademik
        if (isset($filter['tahun_akademik_id'])) {
            $builder->where('j.tahun_akademik_id', $filter['tahun_akademik_id']);
        }
        
        // Filter berdasarkan hari
        if (isset($filter['hari'])) {
            $builder->where('j.hari', $filter['hari']);
        }

        // Filter berdasarkan dosen
        if (isset($filter['dosen_id'])) {
            $builder->where('j.dosen_id', $filter['dosen_id']);
        }

        // Filter berdasarkan ruangan
        if (isset($filter['ruangan_id'])) {
            $builder->where('j.ruangan_id', $filter['ruangan_id']);
        }
        
        // Pengurutan default
        $builder->orderBy('j.hari', 'ASC');
        $builder->orderBy('j.jam_mulai', 'ASC');
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Mendapatkan daftar tahun akademik untuk dropdown filter
     */
    public function getTahunAkademikDropdown()
    {
        $builder = $this->db->table('tahun_akademik');
        $builder->select('id, nama');
        $builder->orderBy('tanggal_mulai', 'DESC');
        return $builder->get()->getResultArray();
    }
    
    /**
     * Mendapatkan daftar dosen untuk dropdown filter
     */
    public function getDosenDropdown()
    {
        $builder = $this->db->table('dosen');
        $builder->select('id, nama, gelar');
        $builder->where('status', 'aktif');
        $builder->orderBy('nama', 'ASC');
        return $builder->get()->getResultArray();
    }
    
    /**
     * Mendapatkan daftar ruangan untuk dropdown filter
     */
    public function getRuanganDropdown()
    {
        $builder = $this->db->table('ruangan');
        $builder->select('id, nama, kode');
        $builder->orderBy('nama', 'ASC');
        return $builder->get()->getResultArray();
    }
}