<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD UM BIMA - Panel Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar .nav-link {
            color: #343a40;
            padding: 0.8rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.2rem;
        }
        
        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
        }
        
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .content-wrapper {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }
        
        .dropdown-menu {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0.75rem 0;
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-white p-3" style="width: 250px;">
            <div class="d-flex align-items-center mb-4 py-2">
                <img src="<?= base_url('logo.jpg') ?>" alt="Logo" height="40">
                <h5 class="ms-2 mb-0 fw-bold text-primary">UM BIMA</h5>
            </div>
            
            <p class="text-muted small mb-2">MENU UTAMA</p>
            
            <?php
            $request = service('request');
            $currentPath = $request->getUri()->getPath();
            ?>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $currentPath == 'administrator/v_dashboard' ? 'active' : '' ?>" href="<?= base_url('administrator/dashboard') ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= strpos($currentPath, 'admin/mahasiswa') !== false ? 'active' : '' ?>" href="<?= base_url('administrator/mahasiswa') ?>">
                        <i class="fas fa-user-graduate"></i> Mahasiswa
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= strpos($currentPath, 'admin/dosen') !== false ? 'active' : '' ?>" href="<?= base_url('administrator/dosen') ?>">
                        <i class="fas fa-chalkboard-teacher"></i> Dosen
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= strpos($currentPath, 'admin/mata-kuliah') !== false ? 'active' : '' ?>" href="<?= base_url('administrator/mata-kuliah') ?>">
                        <i class="fas fa-book"></i> Mata Kuliah
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= strpos($currentPath, 'admin/program-studi') !== false ? 'active' : '' ?>" href="<?= base_url('administrator/program-studi') ?>">
                        <i class="fas fa-graduation-cap"></i> Program Studi
                    </a>
                </li>
            </ul>
            
            <hr>
            
            <p class="text-muted small mb-2">PENGELOLAAN</p>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= strpos($currentPath, 'admin/jadwal') !== false ? 'active' : '' ?>" href="<?= base_url('administrator/jadwal-kuliah') ?>">
                        <i class="fas fa-calendar-alt"></i> Jadwal Kuliah
                    </a>
                </li>
                
                
            
            <hr>
            
        </div>
        
        <!-- Main Content -->
        <div class="content-wrapper flex-grow-1">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-sm btn-outline-secondary d-lg-none me-3" type="button" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Admin</a></li>
                        <?php
                        $segments = $request->getUri()->getSegments();
                        
                        if(count($segments) > 1 && $segments[0] != 'dashboard') {
                            echo '<li class="breadcrumb-item active text-capitalize">' . str_replace('-', ' ', $segments[0]) . '</li>';
                            
                            if(isset($segments[1]) && $segments[1] != '') {
                                echo '<li class="breadcrumb-item active text-capitalize">' . str_replace('-', ' ', $segments[1]) . '</li>';
                            }
                        }
                        ?>
                    </ol>
                    
                    <div class="ms-auto d-flex align-items-center">
                       
                        
                        <div class="dropdown ms-3">
                            <button class="btn btn-link text-dark dropdown-toggle d-flex align-items-center text-decoration-none" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url('logo.jpg') ?>" alt="Profile" class="rounded-circle me-2" width="32" height="32">
                                <span>Administrator</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Main Content Area -->
            <main>
                <?= $this->renderSection('content') ?>
            </main>
            
            <!-- Footer -->
            <footer class="bg-white text-center py-3 mt-auto border-top">
                <p class="mb-0 text-muted">&copy; <?= date('Y') ?> SIAKAD - Sistem Informasi Akademik. All rights reserved.</p>
            </footer>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('d-none');
        });
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>