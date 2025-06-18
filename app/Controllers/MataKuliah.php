<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MataKuliahModel;

class MataKuliah extends BaseController
{
    protected $mataKuliahModel;
    
    public function __construct()
    {
        $this->mataKuliahModel = new MataKuliahModel();
    }
    
    public function index()
    {
        $data['title'] = 'Daftar Mata Kuliah';
        $data['mata_kuliah'] = $this->mataKuliahModel->getMataKuliah();
        
        return view('v_mata-kuliah', $data);
    }
}