<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/Home', 'Home::index');
$routes->get('/Jadwal/index','Jadwal::index');
$routes->get('/MataKuliah/index','MataKuliah::index');
$routes->get('/admin/jadwal/tambah', 'Jadwal\Jadwal_admin::tambah');
$routes->post('/admin/jadwal/simpan', 'Jadwal\Jadwal_admin::simpan');
$routes->get('dashboard/mahasiswa', 'Mahasiswa::index');

//Auth babi
$routes->get('auth', 'Auth::index');

$routes->match(['get', 'post'], 'auth/login', 'Auth::login');
// You might also want a logout route
$routes->get('auth/logout', 'Auth::logout');

// Admin routes
$routes->get('administrator/dashboard', 'Admin::dashboard');
$routes->get('admin', 'Admin::dashboard'); // Redirect admin to dashboard

$routes->group('administrator', function($routes) {
    $routes->get('administrator/Mahasiswa', 'administrator\Mahasiswa::index');
    $routes->post('tambah', 'Mahasiswa::tambah');
    $routes->post('edit/(:num)', 'Mahasiswa::edit/$1');
    $routes->get('hapus/(:num)', 'Mahasiswa::hapus/$1');
});



// Route untuk AJAX requests jadwal kuliah
$routes->get('administrator/jadwal-kuliah/get-dosen-by-prodi/(:num)', 'Administrator\JadwalKuliahController::getDosenByProdi/$1');
$routes->get('administrator/jadwal-kuliah/get-mata-kuliah-by-prodi/(:num)', 'Administrator\JadwalKuliahController::getMataKuliahByProdi/$1');

// Route untuk debugging (bisa dihapus setelah masalah teratasi)
$routes->get('administrator/jadwal-kuliah/debug-dosen/(:num)', 'Administrator\JadwalKuliahController::debugDosen/$1');


// Admin CRUD
$routes->group('administrator', ['namespace' => 'App\Controllers\administrator'], function($routes) {
    $routes->get('mahasiswa', 'Mahasiswa::index');
    $routes->post('mahasiswa/tambah', 'Mahasiswa::tambah');
    $routes->post('mahasiswa/edit/(:num)', 'Mahasiswa::edit/$1');
    $routes->get('mahasiswa/hapus/(:num)', 'Mahasiswa::hapus/$1');

    // Dosen routes
    $routes->get('dosen', 'Dosen::index');
    $routes->post('dosen/tambah', 'Dosen::tambah');
    $routes->post('dosen/edit/(:num)', 'Dosen::edit/$1');
    $routes->get('dosen/hapus/(:num)', 'Dosen::hapus/$1');

    // Mata Kuliah routes
    $routes->get('mata-kuliah', 'MataKuliah::index');
    $routes->post('mata-kuliah/tambah', 'MataKuliah::tambah');
    $routes->post('mata-kuliah/edit/(:num)', 'MataKuliah::edit/$1');
    $routes->get('mata-kuliah/hapus/(:num)', 'MataKuliah::hapus/$1');
    // Route untuk mendapatkan mata kuliah berdasarkan program studi (AJAX)
    $routes->get('mata-kuliah/get-by-prodi/(:num)', 'MataKuliah::getMataKuliahByProdi/$1');

    // Program Studi routes
    $routes->get('program-studi', 'ProgramStudi::index');
    $routes->post('program-studi/tambah', 'ProgramStudi::tambah');
    $routes->post('program-studi/edit/(:num)', 'ProgramStudi::edit/$1');
    $routes->get('program-studi/hapus/(:num)', 'ProgramStudi::hapus/$1');
    $routes->get('program-studi/detail/(:num)', 'ProgramStudi::detail/$1');

    // Jadwal babi
    $routes->get('jadwal-kuliah', 'JadwalKuliah::index');
    $routes->post('jadwal-kuliah/tambah', 'JadwalKuliah::tambah');
    $routes->post('jadwal-kuliah/edit/(:num)', 'JadwalKuliah::edit/$1');
    $routes->get('jadwal-kuliah/hapus/(:num)', 'JadwalKuliah::hapus/$1');
    $routes->get('jadwal-kuliah/get-mata-kuliah-by-prodi/(:num)', 'JadwalKuliah::getMataKuliahByProdi/$1');
    $routes->get('jadwal-kuliah/get-dosen-by-prodi/(:num)', 'JadwalKuliah::getDosenByProdi/$1');
});