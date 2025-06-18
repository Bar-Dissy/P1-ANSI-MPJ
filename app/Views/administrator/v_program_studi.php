<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold text-primary mb-0">Data Program Studi</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProgramStudiModal">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Program Studi
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
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari program studi...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterJenjang">
                                <option value="">Semua Jenjang</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterTahun">
                                <option value="">Semua Tahun</option>
                                <?php 
                                $tahunSekarang = date('Y');
                                for ($i = $tahunSekarang; $i >= 2000; $i--) : ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-secondary" id="resetFilter">
                                <i class="fas fa-sync-alt"></i> Reset
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabelProgramStudi">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Kode</th>
                                    <th width="25%">Nama Program Studi</th>
                                    <th width="10%">Jenjang</th>
                                    <th width="20%">Ketua Prodi</th>
                                    <th width="10%">Tahun Berdiri</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($program_studi)) : ?>
                                    <?php $no = 1; foreach ($program_studi as $prodi) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><span class="badge bg-primary"><?= esc($prodi['kode']) ?></span></td>
                                        <td><?= esc($prodi['nama']) ?></td>
                                        <td><span class="badge bg-info"><?= esc($prodi['jenjang']) ?></span></td>
                                        <td><?= esc($prodi['ketua_prodi']) ?: '-' ?></td>
                                        <td><?= esc($prodi['tahun_berdiri']) ?: '-' ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info me-1" onclick="detailProgramStudi(<?= $prodi['id'] ?>)" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editProgramStudiModal<?= $prodi['id'] ?>" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusProgramStudiModal<?= $prodi['id'] ?>" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data program studi</td>
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

<!-- Modal Tambah Program Studi -->
<div class="modal fade" id="tambahProgramStudiModal" tabindex="-1" aria-labelledby="tambahProgramStudiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahProgramStudiModalLabel">Tambah Data Program Studi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/program-studi/tambah') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode Program Studi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('kode')) ? 'is-invalid' : '' ?>" 
                                       id="kode" name="kode" value="<?= old('kode') ?>" 
                                       placeholder="Contoh: TI" maxlength="10" required style="text-transform: uppercase;">
                                <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('kode')) : ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('validation')->getError('kode') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('nama')) ? 'is-invalid' : '' ?>" 
                                       id="nama" name="nama" value="<?= old('nama') ?>" 
                                       placeholder="Nama program studi" maxlength="100" required>
                                <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('nama')) : ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('validation')->getError('nama') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="jenjang" class="form-label">Jenjang <span class="text-danger">*</span></label>
                                <select class="form-select <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('jenjang')) ? 'is-invalid' : '' ?>" 
                                        id="jenjang" name="jenjang" required>
                                    <option value="" selected disabled>Pilih Jenjang</option>
                                    <option value="D3" <?= old('jenjang') == 'D3' ? 'selected' : '' ?>>D3 (Diploma Tiga)</option>
                                    <option value="S1" <?= old('jenjang') == 'S1' ? 'selected' : '' ?>>S1 (Sarjana)</option>
                                    <option value="S2" <?= old('jenjang') == 'S2' ? 'selected' : '' ?>>S2 (Magister)</option>
                                    <option value="S3" <?= old('jenjang') == 'S3' ? 'selected' : '' ?>>S3 (Doktor)</option>
                                </select>
                                <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('jenjang')) : ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('validation')->getError('jenjang') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ketua_prodi" class="form-label">Ketua Program Studi</label>
                                <input type="text" class="form-control <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('ketua_prodi')) ? 'is-invalid' : '' ?>" 
                                       id="ketua_prodi" name="ketua_prodi" value="<?= old('ketua_prodi') ?>" 
                                       placeholder="Nama ketua program studi" maxlength="100">
                                <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('ketua_prodi')) : ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('validation')->getError('ketua_prodi') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="tahun_berdiri" class="form-label">Tahun Berdiri</label>
                                <input type="number" class="form-control <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('tahun_berdiri')) ? 'is-invalid' : '' ?>" 
                                       id="tahun_berdiri" name="tahun_berdiri" value="<?= old('tahun_berdiri') ?>" 
                                       placeholder="Tahun berdiri" min="1900" max="<?= date('Y') ?>">
                                <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('tahun_berdiri')) : ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('validation')->getError('tahun_berdiri') ?>
                                </div>
                                <?php endif; ?>
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

<!-- Modal Detail Program Studi -->
<div class="modal fade" id="detailProgramStudiModal" tabindex="-1" aria-labelledby="detailProgramStudiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detailProgramStudiModalLabel">Detail Program Studi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit dan Hapus Program Studi -->
<?php if (!empty($program_studi)) : ?>
<?php foreach ($program_studi as $prodi) : ?>
<!-- Modal Edit Program Studi -->
<div class="modal fade" id="editProgramStudiModal<?= $prodi['id'] ?>" tabindex="-1" aria-labelledby="editProgramStudiModalLabel<?= $prodi['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editProgramStudiModalLabel<?= $prodi['id'] ?>">Edit Data Program Studi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/program-studi/edit/' . $prodi['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode<?= $prodi['id'] ?>" class="form-label">Kode Program Studi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kode<?= $prodi['id'] ?>" 
                                       name="kode" value="<?= esc($prodi['kode']) ?>" 
                                       placeholder="Contoh: TI" maxlength="10" required style="text-transform: uppercase;">
                            </div>
                            <div class="mb-3">
                                <label for="nama<?= $prodi['id'] ?>" class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama<?= $prodi['id'] ?>" 
                                       name="nama" value="<?= esc($prodi['nama']) ?>" 
                                       placeholder="Nama program studi" maxlength="100" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenjang<?= $prodi['id'] ?>" class="form-label">Jenjang <span class="text-danger">*</span></label>
                                <select class="form-select" id="jenjang<?= $prodi['id'] ?>" name="jenjang" required>
                                    <option value="D3" <?= $prodi['jenjang'] == 'D3' ? 'selected' : '' ?>>D3 (Diploma Tiga)</option>
                                    <option value="S1" <?= $prodi['jenjang'] == 'S1' ? 'selected' : '' ?>>S1 (Sarjana)</option>
                                    <option value="S2" <?= $prodi['jenjang'] == 'S2' ? 'selected' : '' ?>>S2 (Magister)</option>
                                    <option value="S3" <?= $prodi['jenjang'] == 'S3' ? 'selected' : '' ?>>S3 (Doktor)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ketua_prodi<?= $prodi['id'] ?>" class="form-label">Ketua Program Studi</label>
                                <input type="text" class="form-control" id="ketua_prodi<?= $prodi['id'] ?>" 
                                       name="ketua_prodi" value="<?= esc($prodi['ketua_prodi']) ?>" 
                                       placeholder="Nama ketua program studi" maxlength="100">
                            </div>
                            <div class="mb-3">
                                <label for="tahun_berdiri<?= $prodi['id'] ?>" class="form-label">Tahun Berdiri</label>
                                <input type="number" class="form-control" id="tahun_berdiri<?= $prodi['id'] ?>" 
                                       name="tahun_berdiri" value="<?= esc($prodi['tahun_berdiri']) ?>" 
                                       placeholder="Tahun berdiri" min="1900" max="<?= date('Y') ?>">
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

<!-- Modal Hapus Program Studi -->
<div class="modal fade" id="hapusProgramStudiModal<?= $prodi['id'] ?>" tabindex="-1" aria-labelledby="hapusProgramStudiModalLabel<?= $prodi['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="hapusProgramStudiModalLabel<?= $prodi['id'] ?>">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus program studi:</p>
                <p class="fw-bold"><?= esc($prodi['kode']) ?> - <?= esc($prodi['nama']) ?></p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= base_url('administrator/program-studi/hapus/' . $prodi['id']) ?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    filterTable();
});

// Filter functionality
document.getElementById('filterJenjang').addEventListener('change', function() {
    filterTable();
});

document.getElementById('filterTahun').addEventListener('change', function() {
    filterTable();
});

document.getElementById('resetFilter').addEventListener('click', function() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterJenjang').value = '';
    document.getElementById('filterTahun').value = '';
    filterTable();
});

function filterTable() {
    var searchText = document.getElementById('searchInput').value.toLowerCase();
    var filterJenjang = document.getElementById('filterJenjang').value;
    var filterTahun = document.getElementById('filterTahun').value;
    var table = document.getElementById('tabelProgramStudi');
    var rows = table.querySelectorAll('tbody tr');

    rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        if (cells.length === 0) return; // Skip if no cells (like "no data" row)
        
        var kode = cells[1].textContent.toLowerCase();
        var nama = cells[2].textContent.toLowerCase();
        var jenjang = cells[3].textContent;
        var tahun = cells[5].textContent;
        
        var matchSearch = kode.includes(searchText) || nama.includes(searchText);
        var matchJenjang = !filterJenjang || jenjang.includes(filterJenjang);
        var matchTahun = !filterTahun || tahun.includes(filterTahun);
        
        if (matchSearch && matchJenjang && matchTahun) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Detail Program Studi function
function detailProgramStudi(id) {
    fetch('<?= base_url('administrator/program-studi/detail/') ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var content = `
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Kode:</strong></td>
                                    <td><span class="badge bg-primary">${data.data.kode}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td>${data.data.nama}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenjang:</strong></td>
                                    <td><span class="badge bg-info">${data.data.jenjang}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Ketua Prodi:</strong></td>
                                    <td>${data.data.ketua_prodi || '-'}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Berdiri:</strong></td>
                                    <td>${data.data.tahun_berdiri || '-'}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Statistik Program Studi</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <h5 class="text-primary">${data.stats.mata_kuliah}</h5>
                                            <small>Mata Kuliah</small>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="text-success">${data.stats.jadwal_kuliah}</h5>
                                            <small>Jadwal Kuliah</small>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="text-info">${data.stats.mahasiswa}</h5>
                                            <small>Mahasiswa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('detailContent').innerHTML = content;
                var modal = new bootstrap.Modal(document.getElementById('detailProgramStudiModal'));
                modal.show();
            } else {
                alert('Gagal memuat detail program studi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat detail');
        });
}

// Auto uppercase for kode input
document.addEventListener('DOMContentLoaded', function() {
    var kodeInputs = document.querySelectorAll('input[name="kode"]');
    kodeInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
});
</script>

<?= $this->endSection() ?>