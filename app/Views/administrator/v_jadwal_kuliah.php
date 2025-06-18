<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold text-primary mb-0">Jadwal Kuliah</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Jadwal
                </button>
            </div>

             <!-- Alert Success -->
            <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('pesan') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <!-- Alert Error -->
            <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <!-- Alert Validation Errors -->
            <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari jadwal...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterProdi">
                                <option value="">Semua Program Studi</option>
                                <?php foreach ($program_studi as $prodi): ?>
                                <option value="<?= $prodi['nama'] ?>"><?= $prodi['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterHari">
                                <option value="">Semua Hari</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <?php if (empty($jadwal_kuliah)): ?>
                        <div class="alert alert-info">
                            Tidak ada jadwal kuliah yang tersedia saat ini.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tabelJadwal">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="8%">Kode</th>
                                        <th width="15%">Mata Kuliah</th>
                                        <th width="5%">SKS</th>
                                        <th width="5%">Sem</th>
                                        <th width="8%">Hari</th>
                                        <th width="12%">Waktu</th>
                                        <th width="8%">Ruangan</th>
                                        <th width="12%">Dosen</th>
                                        <th width="10%">Program Studi</th>
                                        <th width="8%">Kelas</th>
                                        <th width="8%">Status</th>
                                        <th width="11%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($jadwal_kuliah as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['kode_matkul'] ?></td>
                                        <td><?= $row['nama_matkul'] ?></td>
                                        <td><?= $row['sks'] ?></td>
                                        <td><?= $row['semester'] ?></td>
                                        <td><?= $row['hari'] ?></td>
                                        <td><?= $row['waktu_mulai'] ?> - <?= $row['waktu_selesai'] ?></td>
                                        <td><?= $row['ruangan'] ?></td>
                                        <td><?= $row['nama_dosen'] ?></td>
                                        <td><?= $row['nama_prodi'] ?></td>
                                        <td><?= $row['kelas'] ?></td>
                                        <td>
                                            <span class="badge bg-<?= $row['status'] == 'Aktif' ? 'success' : 'danger' ?>">
                                                <?= $row['status'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailJadwalModal<?= $row['id'] ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editJadwalModal<?= $row['id'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusJadwalModal<?= $row['id'] ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-labelledby="tambahJadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahJadwalModalLabel">Tambah Jadwal Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/jadwal-kuliah/tambah') ?>" method="post">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="program_studi_id" class="form-label">Program Studi</label>
                                <select class="form-select" id="program_studi_id" name="program_studi_id" required>
                                    <option value="">Pilih Program Studi</option>
                                    <?php foreach ($program_studi as $prodi): ?>
                                        <option value="<?= $prodi['id'] ?>"><?= $prodi['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kode_matkul" class="form-label">Mata Kuliah</label>
                                <select class="form-select" id="kode_matkul" name="kode_matkul" required>
                                    <option value="">Pilih Mata Kuliah</option>
                                    <?php foreach ($mata_kuliah as $matkul): ?>
                                        <option value="<?= $matkul['kode_matkul'] ?>"><?= $matkul['nama_matkul'] ?> (<?= $matkul['kode_matkul'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dosen_id" class="form-label">Dosen</label>
                                <select class="form-select" id="dosen_id" name="dosen_id" required>
                                    <option value="">Pilih Dosen</option>
                                    <?php foreach ($dosen as $dsn): ?>
                                        <option value="<?= $dsn['id'] ?>"><?= $dsn['nama_lengkap'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select" id="semester" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    <?php for ($i = 1; $i <= 8; $i++): ?>
                                        <option value="<?= $i ?>">Semester <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                                <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik" value="<?= date('Y') ?>/<?= date('Y')+1 ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hari" class="form-label">Hari</label>
                                <select class="form-select" id="hari" name="hari" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                            </div>
                            <div class="mb-3">
                                <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                            </div>
                            <div class="mb-3">
                                <label for="ruangan" class="form-label">Ruangan</label>
                                <input type="text" class="form-control" id="ruangan" name="ruangan" required>
                            </div>
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" value="Reguler">
                            </div>
                            <div class="mb-3">
                                <label for="kuota" class="form-label">Kuota</label>
                                <input type="number" class="form-control" id="kuota" name="kuota" value="40">
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

<!-- Modal Detail, Edit dan Hapus untuk setiap jadwal -->
<?php foreach ($jadwal_kuliah as $row): ?>
<!-- Modal Detail Jadwal -->
<div class="modal fade" id="detailJadwalModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="detailJadwalModalLabel<?= $row['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detailJadwalModalLabel<?= $row['id'] ?>">Detail Jadwal Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th width="40%">Kode Mata Kuliah</th>
                                <td><?= $row['kode_matkul'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama Mata Kuliah</th>
                                <td><?= $row['nama_matkul'] ?></td>
                            </tr>
                            <tr>
                                <th>SKS</th>
                                <td><?= $row['sks'] ?></td>
                            </tr>
                            <tr>
                                <th>Semester</th>
                                <td><?= $row['semester'] ?></td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td><?= $row['nama_prodi'] ?></td>
                            </tr>
                            <tr>
                                <th>Dosen</th>
                                <td><?= $row['nama_dosen'] ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th width="40%">Hari</th>
                                <td><?= $row['hari'] ?></td>
                            </tr>
                            <tr>
                                <th>Waktu</th>
                                <td><?= $row['waktu_mulai'] ?> - <?= $row['waktu_selesai'] ?></td>
                            </tr>
                            <tr>
                                <th>Ruangan</th>
                                <td><?= $row['ruangan'] ?></td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td><?= $row['kelas'] ?></td>
                            </tr>
                            <tr>
                                <th>Kuota</th>
                                <td><?= $row['kuota'] ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-<?= $row['status'] == 'Aktif' ? 'success' : 'danger' ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
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

<!-- Modal Edit Jadwal -->
<div class="modal fade" id="editJadwalModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editJadwalModalLabel<?= $row['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editJadwalModalLabel<?= $row['id'] ?>">Edit Jadwal Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/jadwal-kuliah/edit/' . $row['id']) ?>" method="post">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="program_studi_id_edit<?= $row['id'] ?>" class="form-label">Program Studi</label>
                                <select class="form-select" id="program_studi_id_edit<?= $row['id'] ?>" name="program_studi_id" required>
                                    <option value="">Pilih Program Studi</option>
                                    <?php foreach ($program_studi as $prodi): ?>
                                        <option value="<?= $prodi['id'] ?>" <?= $prodi['id'] == $row['program_studi_id'] ? 'selected' : '' ?>>
                                            <?= $prodi['nama'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kode_matkul_edit<?= $row['id'] ?>" class="form-label">Mata Kuliah</label>
                                <select class="form-select" id="kode_matkul_edit<?= $row['id'] ?>" name="kode_matkul" required>
                                    <option value="">Pilih Mata Kuliah</option>
                                    <?php foreach ($mata_kuliah as $matkul): ?>
                                        <option value="<?= $matkul['kode_matkul'] ?>" <?= $matkul['kode_matkul'] == $row['kode_matkul'] ? 'selected' : '' ?>>
                                            <?= $matkul['nama_matkul'] ?> (<?= $matkul['kode_matkul'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dosen_id_edit<?= $row['id'] ?>" class="form-label">Dosen</label>
                                <select class="form-select" id="dosen_id_edit<?= $row['id'] ?>" name="dosen_id" required>
                                    <option value="">Pilih Dosen</option>
                                    <?php foreach ($dosen as $dsn): ?>
                                        <option value="<?= $dsn['id'] ?>" <?= $dsn['id'] == $row['dosen_id'] ? 'selected' : '' ?>>
                                            <?= $dsn['nama_lengkap'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="semester_edit<?= $row['id'] ?>" class="form-label">Semester</label>
                                <select class="form-select" id="semester_edit<?= $row['id'] ?>" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    <?php for ($i = 1; $i <= 8; $i++): ?>
                                        <option value="<?= $i ?>" <?= $i == $row['semester'] ? 'selected' : '' ?>>
                                            Semester <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tahun_akademik_edit<?= $row['id'] ?>" class="form-label">Tahun Akademik</label>
                                <input type="text" class="form-control" id="tahun_akademik_edit<?= $row['id'] ?>" name="tahun_akademik" value="<?= $row['tahun_akademik'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hari_edit<?= $row['id'] ?>" class="form-label">Hari</label>
                                <select class="form-select" id="hari_edit<?= $row['id'] ?>" name="hari" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin" <?= $row['hari'] == 'Senin' ? 'selected' : '' ?>>Senin</option>
                                    <option value="Selasa" <?= $row['hari'] == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                                    <option value="Rabu" <?= $row['hari'] == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                                    <option value="Kamis" <?= $row['hari'] == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                                    <option value="Jumat" <?= $row['hari'] == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                                    <option value="Sabtu" <?= $row['hari'] == 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="waktu_mulai_edit<?= $row['id'] ?>" class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control" id="waktu_mulai_edit<?= $row['id'] ?>" name="waktu_mulai" value="<?= $row['waktu_mulai'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="waktu_selesai_edit<?= $row['id'] ?>" class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control" id="waktu_selesai_edit<?= $row['id'] ?>" name="waktu_selesai" value="<?= $row['waktu_selesai'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="ruangan_edit<?= $row['id'] ?>" class="form-label">Ruangan</label>
                                <input type="text" class="form-control" id="ruangan_edit<?= $row['id'] ?>" name="ruangan" value="<?= $row['ruangan'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="kelas_edit<?= $row['id'] ?>" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas_edit<?= $row['id'] ?>" name="kelas" value="<?= $row['kelas'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="kuota_edit<?= $row['id'] ?>" class="form-label">Kuota</label>
                                <input type="number" class="form-control" id="kuota_edit<?= $row['id'] ?>" name="kuota" value="<?= $row['kuota'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="status_edit<?= $row['id'] ?>" class="form-label">Status</label>
                                <select class="form-select" id="status_edit<?= $row['id'] ?>" name="status">
                                    <option value="Aktif" <?= $row['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="Nonaktif" <?= $row['status'] == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
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

<!-- Modal Hapus Jadwal -->
<div class="modal fade" id="hapusJadwalModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="hapusJadwalModalLabel<?= $row['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="hapusJadwalModalLabel<?= $row['id'] ?>">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus jadwal kuliah:</p>
                <p class="fw-bold"><?= $row['kode_matkul'] ?> - <?= $row['nama_matkul'] ?></p>
                <p class="text-danger">Perhatian: Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= base_url('administrator/jadwal-kuliah/hapus/' . $row['id']) ?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validasi waktu mulai dan selesai
    document.querySelectorAll('[id^="waktu_mulai"], [id^="waktu_selesai"]').forEach(function(element) {
        element.addEventListener('change', function() {
            const id = this.id.replace(/waktu_(mulai|selesai)/, '');
            const waktuMulai = document.getElementById('waktu_mulai' + id)?.value;
            const waktuSelesai = document.getElementById('waktu_selesai' + id)?.value;
            
            if (waktuMulai && waktuSelesai && waktuMulai >= waktuSelesai) {
                alert('Waktu selesai harus setelah waktu mulai');
                document.getElementById('waktu_selesai' + id).value = '';
            }
        });
    });
    
    // Filter tabel
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tabelJadwal tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
    
    document.getElementById('filterProdi').addEventListener('change', function() {
        filterTable();
    });
    
    document.getElementById('filterHari').addEventListener('change', function() {
        filterTable();
    });
    
    document.getElementById('filterStatus').addEventListener('change', function() {
        filterTable();
    });
    
    function filterTable() {
        const prodiFilter = document.getElementById('filterProdi').value;
        const hariFilter = document.getElementById('filterHari').value;
        const statusFilter = document.getElementById('filterStatus').value;
        const rows = document.querySelectorAll('#tabelJadwal tbody tr');
        
        rows.forEach(row => {
            const prodi = row.cells[9].textContent;
            const hari = row.cells[5].textContent;
            const status = row.cells[10].textContent.trim();
            
            const prodiMatch = !prodiFilter || prodi === prodiFilter;
            const hariMatch = !hariFilter || hari === hariFilter;
            const statusMatch = !statusFilter || status === statusFilter;
            
            row.style.display = prodiMatch && hariMatch && statusMatch ? '' : 'none';
        });
    }
    
    // Reset modal tambah saat ditutup
    const tambahModal = document.getElementById('tambahJadwalModal');
    if (tambahModal) {
        tambahModal.addEventListener('hidden.bs.modal', function() {
            const form = this.querySelector('form');
            if (form) {
                form.reset();
            }
        });
    }
});

// Fungsi untuk print jadwal
function printJadwal() {
    const printContent = document.getElementById('tabelJadwal').outerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Jadwal Kuliah</title>
            <style>
                body { font-family: Arial, sans-serif; }
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .btn { display: none; }
            </style>
        </head>
        <body>
            <h2>Jadwal Kuliah</h2>
            ${printContent}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>