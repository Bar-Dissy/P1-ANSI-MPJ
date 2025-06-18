<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('public/jadwal_style.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Navigation Bar - tidak akan dicetak -->
            <nav aria-label="breadcrumb" class="no-print mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('jadwal') ?>">Jadwal Kuliah</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Jadwal</li>
                </ol>
            </nav>
            
            <div class="jadwal-container mb-4">
                <div class="jadwal-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Jadwal Kuliah</h4>
                        <p class="mb-0"><?= esc($prodi_info['nama']) ?> (<?= esc($prodi_info['jenjang']) ?>) - Semester <?= esc($selected_semester) ?></p>
                        <p class="small mb-0">Tahun Akademik: <?= esc($selected_tahun_akademik) ?></p>
                    </div>
                    <?php if ($selected_semester == 6): ?>
                        <span class="semester-badge bg-warning">Semester 6</span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (empty($jadwal)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada jadwal kuliah yang tersedia untuk program studi <?= esc($prodi_info['nama']) ?> semester <?= esc($selected_semester) ?>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <?php
                                // Kelompokkan jadwal berdasarkan hari
                                $jadwal_by_hari = [];
                                foreach ($jadwal as $item) {
                                    $jadwal_by_hari[$item['hari']][] = $item;
                                }
                                
                                // Urutan hari
                                $hari_order = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            ?>
                            
                            <table class="table table-hover jadwal-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Mata Kuliah</th>
                                        <th width="5%">SKS</th>
                                        <th width="15%">Hari</th>
                                        <th width="15%">Waktu</th>
                                        <th width="10%">Ruangan</th>
                                        <th width="25%">Dosen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1; 
                                    $total_sks = 0; 
                                    
                                    // Tampilkan jadwal berdasarkan urutan hari
                                    foreach ($hari_order as $hari):
                                        if (isset($jadwal_by_hari[$hari])):
                                    ?>
                                        <tr class="hari-header">
                                            <td colspan="7" class="bg-light"><i class="fas fa-calendar-day me-2"></i><?= $hari ?></td>
                                        </tr>
                                        
                                        <?php foreach ($jadwal_by_hari[$hari] as $item): ?>
                                            <?php $total_sks += $item['sks']; ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><strong><?= esc($item['nama_matkul']) ?></strong></td>
                                                <td class="text-center"><?= esc($item['sks']) ?></td>
                                                <td><?= esc($item['hari']) ?></td>
                                                <td><?= esc(date('H:i', strtotime($item['waktu_mulai']))) ?> - <?= esc(date('H:i', strtotime($item['waktu_selesai']))) ?></td>
                                                <td class="text-center"><?= esc($item['ruangan']) ?></td>
                                                <td><?= esc($item['nama_dosen']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                    
                                    <tr class="total-sks">
                                        <td colspan="2" class="text-end fw-bold">Total SKS:</td>
                                        <td class="text-center fw-bold"><?= $total_sks ?></td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-secondary mt-3">
                            <i class="fas fa-info-circle me-2"></i> Jadwal dapat berubah sewaktu-waktu. Silakan cek secara berkala untuk informasi terbaru.
                        </div>
                        
                        <div class="mt-3 no-print">
                            <a href="<?= base_url('jadwal') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button onclick="window.print()" class="btn btn-success ms-2">
                                <i class="fas fa-print me-1"></i> Cetak Jadwal
                            </button>
                            <a href="#" class="btn btn-info ms-2" id="btnSaveAsPDF">
                                <i class="fas fa-file-pdf me-1"></i> Simpan PDF
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($jadwal)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function for save as PDF - This would need a PDF library to work properly
    // This is just a placeholder, you would need to implement the actual PDF generation
    document.getElementById('btnSaveAsPDF').addEventListener('click', function(e) {
        e.preventDefault();
        alert('Fitur PDF akan segera tersedia!');
        // Implementation would go here, using a library like jsPDF or html2pdf
    });
});
</script>
<?php endif; ?>
<?= $this->endSection() ?>