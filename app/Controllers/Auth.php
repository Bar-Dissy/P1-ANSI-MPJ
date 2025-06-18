<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        // If user is already logged in, redirect to appropriate dashboard
        if (session()->get('logged_in')) {
            return $this->redirectBasedOnLevel(session()->get('level'));
        }
        
        return view('v_login');
    }
    
    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Format tanggal lahir sebagai password (ddmmyyyy) to md5
        $passwordHash = md5($password);
        
        // Cari user berdasarkan username tanpa mempertimbangkan level
        $user = $this->userModel->where('username', $username)
                             ->where('deleted_at', null)
                             ->first();
        
        if ($user) {
            if ($user['password'] === $passwordHash) {
                $sessionData = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'level' => $user['level'],
                    'related_id' => $user['related_id'],
                    'logged_in' => true
                ];
                
                session()->set($sessionData);
                
                return $this->redirectBasedOnLevel($user['level']);
            }
        }
        
        session()->setFlashdata('error', 'Username/NIM/NIDN atau password salah');
        return redirect()->to(base_url('auth'));
    }
    
    private function redirectBasedOnLevel($level)
    {
        switch ($level) {
            case 'admin':
                return redirect()->to(base_url('administrator/dashboard'));
            case 'dosen':
                return redirect()->to(base_url('Home'));
            case 'mahasiswa':
                return redirect()->to(base_url('dashboard/mahasiswa'));
            default:
                return redirect()->to(base_url('/'));
        }
    }
    
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Anda telah berhasil logout');
        return redirect()->to(base_url('auth'));
    }
}