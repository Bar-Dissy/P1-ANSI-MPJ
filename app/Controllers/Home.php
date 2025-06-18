<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('auth'));
        }
        
        return view('v_home');
    }
}