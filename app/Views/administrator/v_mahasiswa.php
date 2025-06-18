<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold text-primary mb-0">Data Mahasiswa</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahMahasiswaModal">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Mahasiswa
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
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari mahasiswa...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterProdi">
                                <option value="">Semua Program Studi</option>
                                <?php foreach ($program_studi as $prodi) : ?>
                                <option value="<?= $prodi['nama'] ?>"><?= $prodi['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Cuti">Cuti</option>
                                <option value="Lulus">Lulus</option>
                                <option value="Keluar">Keluar</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabelMahasiswa">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">NIM</th>
                                    <th width="15%">Foto</th>
                                    <th width="15%">Nama Lengkap</th>
                                    <th width="15%">Program Studi</th>
                                    <th width="8%">Angkatan</th>
                                    <th width="8%">Semester</th>
                                    <th width="10%">Kelas</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($mahasiswa as $mhs) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $mhs['nim'] ?></td>
                                    <td>
                                        <?php if ($mhs['foto'] != 'default.jpg') : ?>
                                            <img src="<?= base_url('uploads/mahasiswa/' . $mhs['foto']) ?>" alt="Foto <?= $mhs['nama_lengkap'] ?>" class="img-thumbnail" width="70">
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/img/default.jpg') ?>" alt="Foto Default" class="img-thumbnail" width="70">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $mhs['nama_lengkap'] ?></td>
                                    <td><?= $mhs['program_studi'] ?></td>
                                    <td><?= $mhs['angkatan'] ?></td>
                                    <td><?= $mhs['semester'] ?></td>
                                    <td><?= $mhs['kelas'] ?? 'Reguler' ?></td>
                                    <td>
                                        <?php if ($mhs['status'] == 'Aktif') : ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php elseif ($mhs['status'] == 'Cuti') : ?>
                                            <span class="badge bg-warning">Cuti</span>
                                        <?php elseif ($mhs['status'] == 'Lulus') : ?>
                                            <span class="badge bg-info">Lulus</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">Keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailMahasiswaModal<?= $mhs['id'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editMahasiswaModal<?= $mhs['id'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusMahasiswaModal<?= $mhs['id'] ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Mahasiswa -->
<div class="modal fade" id="tambahMahasiswaModal" tabindex="-1" aria-labelledby="tambahMahasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahMahasiswaModalLabel">Tambah Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/mahasiswa/tambah') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkLaki" value="Laki-laki" checked>
                                        <label class="form-check-label" for="jkLaki">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkPerempuan" value="Perempuan">
                                        <label class="form-check-label" for="jkPerempuan">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="no_telepon" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi" class="form-label">Program Studi</label>
                                <select class="form-select" id="program_studi" name="program_studi" required>
                                    <option value="" selected disabled>Pilih Program Studi</option>
                                    <?php foreach ($program_studi as $prodi) : ?>
                                    <option value="<?= $prodi['nama'] ?>"><?= $prodi['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <select class="form-select" id="angkatan" name="angkatan" required>
                                    <option value="" selected disabled>Pilih Tahun</option>
                                    <?php 
                                    $tahun_sekarang = date('Y');
                                    for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 5; $i--) : 
                                    ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select" id="semester" name="semester" required>
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" value="Reguler">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Keluar">Keluar</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto">
                                <small class="text-muted">Format: JPG/PNG, Maks: 2MB</small>
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

<!-- Modal Detail, Edit dan Hapus Mahasiswa -->
<?php foreach ($mahasiswa as $mhs) : ?>
<!-- Modal Detail Mahasiswa -->
<div class="modal fade" id="detailMahasiswaModal<?= $mhs['id'] ?>" tabindex="-1" aria-labelledby="detailMahasiswaModalLabel<?= $mhs['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detailMahasiswaModalLabel<?= $mhs['id'] ?>">Detail Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <?php if ($mhs['foto'] != 'default.jpg') : ?>
                            <img src="<?= base_url('uploads/mahasiswa/' . $mhs['foto']) ?>" alt="Foto <?= $mhs['nama_lengkap'] ?>" class="img-fluid rounded">
                        <?php else : ?>
                            <img src="<?= base_url('assets/img/default.jpg') ?>" alt="Foto Default" class="img-fluid rounded">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <table class="table">
                            <tr>
                                <th width="30%">NIM</th>
                                <td><?= $mhs['nim'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><?= $mhs['nama_lengkap'] ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td><?= $mhs['jenis_kelamin'] ?></td>
                            </tr>
                            <tr>
                                <th>Tempat, Tgl Lahir</th>
                                <td><?= $mhs['tempat_lahir'] . ', ' . date('d F Y', strtotime($mhs['tanggal_lahir'])) ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= $mhs['alamat'] ?></td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td><?= $mhs['no_telepon'] ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $mhs['email'] ?></td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td><?= $mhs['program_studi'] ?></td>
                            </tr>
                            <tr>
                                <th>Angkatan</th>
                                <td><?= $mhs['angkatan'] ?></td>
                            </tr>
                            <tr>
                                <th>Semester</th>
                                <td><?= $mhs['semester'] ?></td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td><?= $mhs['kelas'] ?? 'Reguler' ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if ($mhs['status'] == 'Aktif') : ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php elseif ($mhs['status'] == 'Cuti') : ?>
                                        <span class="badge bg-warning">Cuti</span>
                                    <?php elseif ($mhs['status'] == 'Lulus') : ?>
                                        <span class="badge bg-info">Lulus</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger">Keluar</span>
                                    <?php endif; ?>
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

<!-- Modal Edit Mahasiswa -->
<div class="modal fade" id="editMahasiswaModal<?= $mhs['id'] ?>" tabindex="-1" aria-labelledby="editMahasiswaModalLabel<?= $mhs['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editMahasiswaModalLabel<?= $mhs['id'] ?>">Edit Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/mahasiswa/edit/' . $mhs['id']) ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nim<?= $mhs['id'] ?>" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim<?= $mhs['id'] ?>" name="nim" value="<?= $mhs['nim'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap<?= $mhs['id'] ?>" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap<?= $mhs['id'] ?>" name="nama_lengkap" value="<?= $mhs['nama_lengkap'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkLaki<?= $mhs['id'] ?>" value="Laki-laki" <?= ($mhs['jenis_kelamin'] == 'Laki-laki') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="jkLaki<?= $mhs['id'] ?>">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkPerempuan<?= $mhs['id'] ?>" value="Perempuan" <?= ($mhs['jenis_kelamin'] == 'Perempuan') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="jkPerempuan<?= $mhs['id'] ?>">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir<?= $mhs['id'] ?>" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir<?= $mhs['id'] ?>" name="tempat_lahir" value="<?= $mhs['tempat_lahir'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir<?= $mhs['id'] ?>" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir<?= $mhs['id'] ?>" name="tanggal_lahir" value="<?= $mhs['tanggal_lahir'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat<?= $mhs['id'] ?>" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat<?= $mhs['id'] ?>" name="alamat" rows="3" required><?= $mhs['alamat'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="no_telepon<?= $mhs['id'] ?>" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="no_telepon<?= $mhs['id'] ?>" name="no_telepon" value="<?= $mhs['no_telepon'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email<?= $mhs['id'] ?>" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email<?= $mhs['id'] ?>" name="email" value="<?= $mhs['email'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi<?= $mhs['id'] ?>" class="form-label">Program Studi</label>
                                <select class="form-select" id="program_studi<?= $mhs['id'] ?>" name="program_studi" required>
                                    <?php foreach ($program_studi as $prodi) : ?>
                                    <option value="<?= $prodi['nama'] ?>" <?= ($mhs['program_studi'] == $prodi['nama']) ? 'selected' : '' ?>><?= $prodi['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="angkatan<?= $mhs['id'] ?>" class="form-label">Angkatan</label>
                                <select class="form-select" id="angkatan<?= $mhs['id'] ?>" name="angkatan" required>
                                    <?php 
                                    $tahun_sekarang = date('Y');
                                    for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 5; $i--) : 
                                    ?>
                                    <option value="<?= $i ?>" <?= ($mhs['angkatan'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="semester<?= $mhs['id'] ?>" class="form-label">Semester</label>
                                <select class="form-select" id="semester<?= $mhs['id'] ?>" name="semester" required>
                                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                                    <option value="<?= $i ?>" <?= ($mhs['semester'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kelas<?= $mhs['id'] ?>" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas<?= $mhs['id'] ?>" name="kelas" value="<?= $mhs['kelas'] ?? 'Reguler' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="status<?= $mhs['id'] ?>" class="form-label">Status</label>
                                <select class="form-select" id="status<?= $mhs['id'] ?>" name="status" required>
                                    <option value="Aktif" <?= ($mhs['status'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                                    <option value="Cuti" <?= ($mhs['status'] == 'Cuti') ? 'selected' : '' ?>>Cuti</option>
                                    <option value="Lulus" <?= ($mhs['status'] == 'Lulus') ? 'selected' : '' ?>>Lulus</option>
                                    <option value="Keluar" <?= ($mhs['status'] == 'Keluar') ? 'selected' : '' ?>>Keluar</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="foto<?= $mhs['id'] ?>" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto<?= $mhs['id'] ?>" name="foto">
                                <small class="text-muted">Format: JPG/PNG, Maks: 2MB. Biarkan kosong jika tidak ingin mengubah foto.</small>
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

<!-- Modal Hapus Mahasiswa -->
<div class="modal fade" id="hapusMahasiswaModal<?= $mhs['id'] ?>" tabindex="-1" aria-labelledby="hapusMahasiswaModalLabel<?= $mhs['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="hapusMahasiswaModalLabel<?= $mhs['id'] ?>">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data mahasiswa:</p>
                <p class="fw-bold"><?= $mhs['nim'] ?> - <?= $mhs['nama_lengkap'] ?></p>
                <p class="text-danger">Perhatian: Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= base_url('administrator/mahasiswa/hapus/' . $mhs['id']) ?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter data
    const searchInput = document.getElementById('searchInput');
    const filterProdi = document.getElementById('filterProdi');
    const filterStatus = document.getElementById('filterStatus');
    const tabelMahasiswa = document.getElementById('tabelMahasiswa').getElementsByTagName('tbody')[0];
    const rows = tabelMahasiswa.getElementsByTagName('tr');
    
    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const prodiValue = filterProdi.value.toLowerCase();
        const statusValue = filterStatus.value.toLowerCase();
        
        for (let i = 0; i < rows.length; i++) {
            const nim = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            const nama = rows[i].getElementsByTagName('td')[3].textContent.toLowerCase();
            const prodi = rows[i].getElementsByTagName('td')[4].textContent.toLowerCase();
            const status = rows[i].getElementsByTagName('td')[7].textContent.toLowerCase();
            
            const matchSearch = nim.includes(searchValue) || nama.includes(searchValue);
            const matchProdi = prodiValue === '' || prodi === prodiValue;
            const matchStatus = statusValue === '' || status.includes(statusValue);
            
            if (matchSearch && matchProdi && matchStatus) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
    
    searchInput.addEventListener('keyup', filterTable);
    filterProdi.addEventListener('change', filterTable);
    filterStatus.addEventListener('change', filterTable);
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>