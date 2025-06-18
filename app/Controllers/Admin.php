<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
        // Check if user is logged in and is an admin
        if (!session()->get('logged_in') || session()->get('level') !== 'admin') {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke halaman tersebut');
            header('Location: ' . base_url('auth'));
            exit;
        }
    }
    
    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'user' => [
                'name' => session()->get('username'),
                'level' => session()->get('level')
            ]
        ];
        
        return view('administrator/v_dashboard', $data);
    }
    
    // Add more admin methods as needed
    public function users()
    {
        $data = [
            'title' => 'Manajemen Pengguna',
            'user' => [
                'name' => session()->get('username'),
                'level' => session()->get('level')
            ]
        ];
        
        return view('admin/users', $data);
    }
    
    public function settings()
    {
        $data = [
            'title' => 'Pengaturan Sistem',
            'user' => [
                'name' => session()->get('username'),
                'level' => session()->get('level')
            ]
        ];
        
        return view('admin/settings', $data);
    }
}