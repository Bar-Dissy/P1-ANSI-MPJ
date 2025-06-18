<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <!-- Header dengan card -->
    <div class="card border-0 bg-light shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold text-primary mb-3">Selamat Datang di SIAKAD</h2>
                    <p class="lead mb-0">Sistem Informasi Akademik untuk memudahkan aktivitas perkuliahan Anda</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="/api/placeholder/200/200" alt="SIAKAD Icon" class="img-fluid" style="max-width: 150px;">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Menu Cepat -->
    <h4 class="mb-3">Akses Cepat</h4>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-primary border-top-0 border-end-0 border-bottom-0 border-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">Mata Kuliah</h5>
                    <p class="card-text">Lihat daftar mata kuliah yang tersedia di semester ini.</p>
                    <a href="<?= base_url('mahasiswa/mata-kuliah') ?>" class="btn btn-outline-primary">Lihat Mata Kuliah</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-success border-top-0 border-end-0 border-bottom-0 border-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success">Jadwal Kuliah</h5>
                    <p class="card-text">Cek jadwal kuliah berdasarkan program studi dan semester.</p>
                    <a href="<?= base_url('mahasiswa/jadwal') ?>" class="btn btn-outline-success">Cek Jadwal</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-info border-top-0 border-end-0 border-bottom-0 border-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-info">Profil</h5>
                    <p class="card-text">Lihat dan perbarui informasi profil akademik Anda.</p>
                    <a href="<?= base_url('mahasiswa/profil') ?>" class="btn btn-outline-info">Profil Saya</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Informasi Akademik -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Akademik</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="bi bi-info-circle-fill me-2"></i> Masa pengisian KRS akan berakhir pada tanggal 25 Mei 2025.
            </div>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Perkuliahan semester genap akan dimulai pada tanggal 1 Juni 2025.
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>