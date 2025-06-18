<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramStudiModel extends Model
{
    protected $table = 'program_studi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode', 'nama', 'jenjang', 'ketua_prodi', 'tahun_berdiri'];
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
}