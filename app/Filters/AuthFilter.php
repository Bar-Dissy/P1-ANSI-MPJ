<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika pengguna belum login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('auth'));
        }
        
        // Jika level akses diperiksa
        if (!empty($arguments)) {
            $level = session()->get('level');
            
            // Periksa apakah level pengguna saat ini termasuk dalam daftar izin
            if (!in_array($level, $arguments)) {
                // Redirect sesuai level
                switch ($level) {
                    case 'admin':
                        return redirect()->to(base_url('admin/dashboard'));
                    case 'dosen':
                    case 'mahasiswa':
                    default:
                        return redirect()->to(base_url('Home'));
                }
            }
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing here
    }
}