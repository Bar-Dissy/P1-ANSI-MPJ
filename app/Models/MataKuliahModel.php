<?php

namespace App\Models;

use CodeIgniter\Model;

class MataKuliahModel extends Model
{
    protected $table = 'mata_kuliah';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode_matkul', 'nama_matkul', 'sks', 'semester', 'program_studi_id', 'deskripsi'];

    public function getMataKuliah()
    {
        // Join with program_studi table to get program study name
        $builder = $this->db->table($this->table);
        $builder->select('mata_kuliah.*, program_studi.nama as nama_prodi');
        $builder->join('program_studi', 'program_studi.id = mata_kuliah.program_studi_id', 'left');
        $builder->where('mata_kuliah.deleted_at', null); // Only active records
        $builder->orderBy('mata_kuliah.semester', 'ASC');
        $builder->orderBy('mata_kuliah.nama_matkul', 'ASC');
        
        return $builder->get()->getResultArray();
    }
}