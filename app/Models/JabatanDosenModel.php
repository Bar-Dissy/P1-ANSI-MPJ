<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanDosenModel extends Model
{
    protected $table            = 'jabatan_dosen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields    = [
        'nama_jabatan',
        'deskripsi',
        'created_at',
        'deleted_at'
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = '';
    protected $deletedField     = 'deleted_at';

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    // Optional: Validasi data
    protected $validationRules = [
        'nama_jabatan' => 'required|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'nama_jabatan' => [
            'required' => 'Nama jabatan wajib diisi.',
            'min_length' => 'Minimal 3 karakter.',
            'max_length' => 'Maksimal 100 karakter.'
        ]
    ];

    protected $skipValidation = false;
}
