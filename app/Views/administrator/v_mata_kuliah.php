<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold text-primary mb-0">Data Mata Kuliah</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahMataKuliahModal">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Mata Kuliah
                </button>
            </div>
            
            <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari mata kuliah...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterProdi">
                                <option value="">Semua Program Studi</option>
                                <?php foreach ($program_studi as $prodi) : ?>
                                <option value="<?= esc($prodi['nama']) ?>"><?= esc($prodi['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterSemester">
                                <option value="">Semua Semester</option>
                                <?php for ($i = 1; $i <= 8; $i++) : ?>
                                <option value="<?= $i ?>">Semester <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterSKS">
                                <option value="">Semua SKS</option>
                                <option value="1">1 SKS</option>
                                <option value="2">2 SKS</option>
                                <option value="3">3 SKS</option>
                                <option value="4">4 SKS</option>
                                <option value="5">5 SKS</option>
                                <option value="6">6 SKS</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabelMataKuliah">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Kode</th>
                                    <th width="25%">Nama Mata Kuliah</th>
                                    <th width="8%">SKS</th>
                                    <th width="10%">Semester</th>
                                    <th width="20%">Program Studi</th>
                                    <th width="22%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($mata_kuliah)) : ?>
                                    <?php $no = 1; foreach ($mata_kuliah as $mk) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><span class="badge bg-primary"><?= esc($mk['kode_matkul']) ?></span></td>
                                        <td><?= esc($mk['nama_matkul']) ?></td>
                                        <td><span class="badge bg-info"><?= esc($mk['sks']) ?> SKS</span></td>
                                        <td><span class="badge bg-secondary">Semester <?= esc($mk['semester']) ?></span></td>
                                        <td><?= esc($mk['nama_prodi'] ?? 'Program Studi Tidak Ditemukan') ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#detailMataKuliahModal<?= $mk['id'] ?>" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editMataKuliahModal<?= $mk['id'] ?>" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusMataKuliahModal<?= $mk['id'] ?>" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data mata kuliah</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Mata Kuliah -->
<div class="modal fade" id="tambahMataKuliahModal" tabindex="-1" aria-labelledby="tambahMataKuliahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahMataKuliahModalLabel">Tambah Data Mata Kuliah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/mata-kuliah/tambah') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_matkul" class="form-label">Kode Mata Kuliah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('kode_matkul')) ? 'is-invalid' : '' ?>" 
                                       id="kode_matkul" name="kode_matkul" value="<?= old('kode_matkul') ?>" 
                                       placeholder="Contoh: K03" maxlength="20" required>
                                <?php if (isset($validation) && $validation->hasError('kode_matkul')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kode_matkul') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="nama_matkul" class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama_matkul')) ? 'is-invalid' : '' ?>" 
                                       id="nama_matkul" name="nama_matkul" value="<?= old('nama_matkul') ?>" 
                                       placeholder="Nama mata kuliah" maxlength="100" required>
                                <?php if (isset($validation) && $validation->hasError('nama_matkul')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama_matkul') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="sks" class="form-label">SKS <span class="text-danger">*</span></label>
                                <select class="form-select <?= (isset($validation) && $validation->hasError('sks')) ? 'is-invalid' : '' ?>" 
                                        id="sks" name="sks" required>
                                    <option value="" selected disabled>Pilih SKS</option>
                                    <option value="1" <?= old('sks') == '1' ? 'selected' : '' ?>>1 SKS</option>
                                    <option value="2" <?= old('sks') == '2' ? 'selected' : '' ?>>2 SKS</option>
                                    <option value="3" <?= old('sks') == '3' ? 'selected' : '' ?>>3 SKS</option>
                                    <option value="4" <?= old('sks') == '4' ? 'selected' : '' ?>>4 SKS</option>
                                    <option value="5" <?= old('sks') == '5' ? 'selected' : '' ?>>5 SKS</option>
                                    <option value="6" <?= old('sks') == '6' ? 'selected' : '' ?>>6 SKS</option>
                                </select>
                                <?php if (isset($validation) && $validation->hasError('sks')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('sks') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <select class="form-select <?= (isset($validation) && $validation->hasError('semester')) ? 'is-invalid' : '' ?>" 
                                        id="semester" name="semester" required>
                                    <option value="" selected disabled>Pilih Semester</option>
                                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                                    <option value="<?= $i ?>" <?= old('semester') == $i ? 'selected' : '' ?>>Semester <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <?php if (isset($validation) && $validation->hasError('semester')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('semester') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi_id" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <select class="form-select <?= (isset($validation) && $validation->hasError('program_studi_id')) ? 'is-invalid' : '' ?>" 
                                        id="program_studi_id" name="program_studi_id" required>
                                    <option value="" selected disabled>Pilih Program Studi</option>
                                    <?php foreach ($program_studi as $prodi) : ?>
                                    <option value="<?= $prodi['id'] ?>" <?= old('program_studi_id') == $prodi['id'] ? 'selected' : '' ?>><?= esc($prodi['nama']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($validation) && $validation->hasError('program_studi_id')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('program_studi_id') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" 
                                          placeholder="Deskripsi mata kuliah (opsional)"><?= old('deskripsi') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail, Edit dan Hapus Mata Kuliah -->
<?php if (!empty($mata_kuliah)) : ?>
<?php foreach ($mata_kuliah as $mk) : ?>
<!-- Modal Detail Mata Kuliah -->
<div class="modal fade" id="detailMataKuliahModal<?= $mk['id'] ?>" tabindex="-1" aria-labelledby="detailMataKuliahModalLabel<?= $mk['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detailMataKuliahModalLabel<?= $mk['id'] ?>">Detail Mata Kuliah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th width="40%">Kode Mata Kuliah</th>
                                <td><span class="badge bg-primary"><?= esc($mk['kode_matkul']) ?></span></td>
                            </tr>
                            <tr>
                                <th>Nama Mata Kuliah</th>
                                <td><?= esc($mk['nama_matkul']) ?></td>
                            </tr>
                            <tr>
                                <th>SKS</th>
                                <td><span class="badge bg-info"><?= esc($mk['sks']) ?> SKS</span></td>
                            </tr>
                            <tr>
                                <th>Semester</th>
                                <td><span class="badge bg-secondary">Semester <?= esc($mk['semester']) ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th width="40%">Program Studi</th>
                                <td><?= esc($mk['nama_prodi'] ?? 'Tidak Ditemukan') ?></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td><?= esc($mk['deskripsi']) ?: '-' ?></td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td><?= date('d M Y H:i', strtotime($mk['created_at'])) ?></td>
                            </tr>
                            <tr>
                                <th>Diupdate</th>
                                <td><?= date('d M Y H:i', strtotime($mk['updated_at'])) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Mata Kuliah -->
<div class="modal fade" id="editMataKuliahModal<?= $mk['id'] ?>" tabindex="-1" aria-labelledby="editMataKuliahModalLabel<?= $mk['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editMataKuliahModalLabel<?= $mk['id'] ?>">Edit Data Mata Kuliah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/mata-kuliah/edit/' . $mk['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_matkul<?= $mk['id'] ?>" class="form-label">Kode Mata Kuliah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kode_matkul<?= $mk['id'] ?>" 
                                       name="kode_matkul" value="<?= esc($mk['kode_matkul']) ?>" 
                                       placeholder="Contoh: K03" maxlength="20" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_matkul<?= $mk['id'] ?>" class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_matkul<?= $mk['id'] ?>" 
                                       name="nama_matkul" value="<?= esc($mk['nama_matkul']) ?>" 
                                       placeholder="Nama mata kuliah" maxlength="100" required>
                            </div>
                            <div class="mb-3">
                                <label for="sks<?= $mk['id'] ?>" class="form-label">SKS <span class="text-danger">*</span></label>
                                <select class="form-select" id="sks<?= $mk['id'] ?>" name="sks" required>
                                    <option value="1" <?= $mk['sks'] == 1 ? 'selected' : '' ?>>1 SKS</option>
                                    <option value="2" <?= $mk['sks'] == 2 ? 'selected' : '' ?>>2 SKS</option>
                                    <option value="3" <?= $mk['sks'] == 3 ? 'selected' : '' ?>>3 SKS</option>
                                    <option value="4" <?= $mk['sks'] == 4 ? 'selected' : '' ?>>4 SKS</option>
                                    <option value="5" <?= $mk['sks'] == 5 ? 'selected' : '' ?>>5 SKS</option>
                                    <option value="6" <?= $mk['sks'] == 6 ? 'selected' : '' ?>>6 SKS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="semester<?= $mk['id'] ?>" class="form-label">Semester <span class="text-danger">*</span></label>
                                <select class="form-select" id="semester<?= $mk['id'] ?>" name="semester" required>
                                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $mk['semester'] == $i ? 'selected' : '' ?>>Semester <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi_id<?= $mk['id'] ?>" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <select class="form-select" id="program_studi_id<?= $mk['id'] ?>" name="program_studi_id" required>
                                    <?php foreach ($program_studi as $prodi) : ?>
                                    <option value="<?= $prodi['id'] ?>" <?= $mk['program_studi_id'] == $prodi['id'] ? 'selected' : '' ?>><?= esc($prodi['nama']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi<?= $mk['id'] ?>" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi<?= $mk['id'] ?>" name="deskripsi" rows="4" 
                                          placeholder="Deskripsi mata kuliah (opsional)"><?= esc($mk['deskripsi']) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Mata Kuliah -->
<div class="modal fade" id="hapusMataKuliahModal<?= $mk['id'] ?>" tabindex="-1" aria-labelledby="hapusMataKuliahModalLabel<?= $mk['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="hapusMataKuliahModalLabel<?= $mk['id'] ?>">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus mata kuliah:</p>
                <p class="fw-bold"><?= esc($mk['kode_matkul']) ?> - <?= esc($mk['nama_matkul']) ?></p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Perhatian: Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= base_url('administrator/mata-kuliah/hapus/' . $mk['id']) ?>" class="btn btn-danger" 
                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter data
    const searchInput = document.getElementById('searchInput');
    const filterProdi = document.getElementById('filterProdi');
    const filterSemester = document.getElementById('filterSemester');
    const filterSKS = document.getElementById('filterSKS');
    const tabelMataKuliah = document.getElementById('tabelMataKuliah');
    
    if (tabelMataKuliah) {
        const tbody = tabelMataKuliah.getElementsByTagName('tbody')[0];
        const rows = tbody.getElementsByTagName('tr');
        
        function filterTable() {
            const searchValue = searchInput.value.toLowerCase();
            const prodiValue = filterProdi.value.toLowerCase();
            const semesterValue = filterSemester.value;
            const sksValue = filterSKS.value;
            
            let visibleCount = 0;
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                
                // Skip jika row kosong atau row "tidak ada data"
                if (row.cells.length < 7) {
                    continue;
                }
                
                const kode = row.cells[1].textContent.toLowerCase();
                const nama = row.cells[2].textContent.toLowerCase();
                const sks = row.cells[3].textContent;
                const semester = row.cells[4].textContent;
                const prodi = row.cells[5].textContent.toLowerCase();
                
                // Filter berdasarkan search input
                const matchSearch = kode.includes(searchValue) || nama.includes(searchValue);
                
                // Filter berdasarkan program studi
                const matchProdi = prodiValue === '' || prodi.includes(prodiValue);
                
                // Filter berdasarkan semester
                const matchSemester = semesterValue === '' || semester.includes(semesterValue);
                
                // Filter berdasarkan SKS
                const matchSKS = sksValue === '' || sks.includes(sksValue + ' SKS');
                
                if (matchSearch && matchProdi && matchSemester && matchSKS) {
                    row.style.display = '';
                    visibleCount++;
                    // Update nomor urut
                    row.cells[0].textContent = visibleCount;
                } else {
                    row.style.display = 'none';
                }
            }
            
            // Tampilkan pesan jika tidak ada data yang cocok
            const noDataRow = tbody.querySelector('.no-data-row');
            if (visibleCount === 0 && rows.length > 0) {
                if (!noDataRow) {
                    const newRow = tbody.insertRow();
                    newRow.className = 'no-data-row';
                    newRow.innerHTML = '<td colspan="7" class="text-center text-muted">Tidak ada data yang sesuai dengan filter</td>';
                }
            } else {
                if (noDataRow) {
                    noDataRow.remove();
                }
            }
        }
        
        // Event listeners untuk filter
        searchInput.addEventListener('input', filterTable);
        filterProdi.addEventListener('change', filterTable);
        filterSemester.addEventListener('change', filterTable);
        filterSKS.addEventListener('change', filterTable);
        
        // Reset filter
        function resetFilters() {
            searchInput.value = '';
            filterProdi.value = '';
            filterSemester.value = '';
            filterSKS.value = '';
            filterTable();
        }
        
        // Tombol reset (jika ada)
        const resetButton = document.getElementById('resetFilter');
        if (resetButton) {
            resetButton.addEventListener('click', resetFilters);
        }
    }
    
    // Auto-close alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const alertInstance = new bootstrap.Alert(alert);
            alertInstance.close();
        }, 5000); // 5 detik
    });
    
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    });
    
    // Clear validation on input
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});

// Function untuk export data (jika diperlukan)
function exportData() {
    // Implementasi export data
    console.log('Export data mata kuliah');
}

// Function untuk print data (jika diperlukan)  
function printData() {
    window.print();
}
</script>
<?= $this->endSection() ?>