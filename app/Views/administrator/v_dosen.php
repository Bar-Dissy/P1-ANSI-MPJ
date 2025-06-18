<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold text-primary mb-0">Data Dosen</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDosenModal">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Dosen
                </button>
            </div>
            
            <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari dosen...">
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
                            <select class="form-select" id="filterJabatan">
                                <option value="">Semua Jabatan</option>
                                <?php foreach ($jabatan_dosen as $jabatan) : ?>
                                <option value="<?= $jabatan['nama_jabatan'] ?>"><?= $jabatan['nama_jabatan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabelDosen">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">NIDN</th>
                                    <th width="15%">Foto</th>
                                    <th width="20%">Nama Lengkap</th>
                                    <th width="15%">Program Studi</th>
                                    <th width="10%">Jabatan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dosen as $dsn) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $dsn['nidn'] ?? '-' ?></td>
                                    <td>
                                        <?php if (isset($dsn['foto']) && $dsn['foto'] != 'default.jpg') : ?>
                                            <img src="<?= base_url('uploads/dosen/' . $dsn['foto']) ?>" alt="Foto <?= $dsn['nama_lengkap'] ?? '' ?>" class="img-thumbnail" width="70">
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/img/default.jpg') ?>" alt="Foto Default" class="img-thumbnail" width="70">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $dsn['nama_lengkap'] ?? '-' ?></td>
                                    <td><?= $dsn['program_studi'] ?? '-' ?></td>
                                    <td><?= $dsn['jabatan'] ?? '-' ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailDosenModal<?= $dsn['id'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editDosenModal<?= $dsn['id'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusDosenModal<?= $dsn['id'] ?>">
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

<!-- Modal Tambah Dosen -->
<div class="modal fade" id="tambahDosenModal" tabindex="-1" aria-labelledby="tambahDosenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahDosenModalLabel">Tambah Data Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/dosen/tambah') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nidn" class="form-label">NIDN</label>
                                <input type="text" class="form-control" id="nidn" name="nidn" required>
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
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                                    <option value="" selected disabled>Pilih Pendidikan</option>
                                    <option value="S3">S3 (Doktor)</option>
                                    <option value="S2">S2 (Magister)</option>
                                    <option value="S1">S1 (Sarjana)</option>
                                    <option value="D4">D4</option>
                                    <option value="D3">D3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <select class="form-select" id="jabatan" name="jabatan" required>
                                    <option value="" selected disabled>Pilih Jabatan</option>
                                    <?php foreach ($jabatan_dosen as $jabatan) : ?>
                                    <option value="<?= $jabatan['nama_jabatan'] ?>"><?= $jabatan['nama_jabatan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="bidang_keahlian" class="form-label">Bidang Keahlian</label>
                                <input type="text" class="form-control" id="bidang_keahlian" name="bidang_keahlian">
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

<!-- Modal Detail, Edit dan Hapus Dosen -->
<?php foreach ($dosen as $dsn) : ?>
<!-- Modal Detail Dosen -->
<div class="modal fade" id="detailDosenModal<?= $dsn['id'] ?>" tabindex="-1" aria-labelledby="detailDosenModalLabel<?= $dsn['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detailDosenModalLabel<?= $dsn['id'] ?>">Detail Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <?php if (isset($dsn['foto']) && $dsn['foto'] != 'default.jpg') : ?>
                            <img src="<?= base_url('uploads/dosen/' . $dsn['foto']) ?>" alt="Foto <?= $dsn['nama_lengkap'] ?? '' ?>" class="img-fluid rounded">
                        <?php else : ?>
                            <img src="<?= base_url('assets/img/default.jpg') ?>" alt="Foto Default" class="img-fluid rounded">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <table class="table">
                            <tr>
                                <th width="30%">NIDN</th>
                                <td><?= $dsn['nidn'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><?= $dsn['nama_lengkap'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td><?= $dsn['jenis_kelamin'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Tempat, Tgl Lahir</th>
                                <td><?= ($dsn['tempat_lahir'] ?? '-') . ', ' . (isset($dsn['tanggal_lahir']) ? date('d F Y', strtotime($dsn['tanggal_lahir'])) : '-') ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= $dsn['alamat'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td><?= $dsn['no_telepon'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $dsn['email'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td><?= $dsn['program_studi'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Pendidikan Terakhir</th>
                                <td><?= $dsn['pendidikan_terakhir'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td><?= $dsn['jabatan'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Bidang Keahlian</th>
                                <td><?= $dsn['bidang_keahlian'] ?? '-' ?></td>
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

<!-- Modal Edit Dosen -->
<div class="modal fade" id="editDosenModal<?= $dsn['id'] ?>" tabindex="-1" aria-labelledby="editDosenModalLabel<?= $dsn['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editDosenModalLabel<?= $dsn['id'] ?>">Edit Data Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('administrator/dosen/edit/' . $dsn['id']) ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nidn<?= $dsn['id'] ?>" class="form-label">NIDN</label>
                                <input type="text" class="form-control" id="nidn<?= $dsn['id'] ?>" name="nidn" value="<?= $dsn['nidn'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap<?= $dsn['id'] ?>" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap<?= $dsn['id'] ?>" name="nama_lengkap" value="<?= $dsn['nama_lengkap'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkLaki<?= $dsn['id'] ?>" value="Laki-laki" <?= (isset($dsn['jenis_kelamin']) && $dsn['jenis_kelamin'] == 'Laki-laki') ? 'checked' : '' ?>>

                                        <label class="form-check-label" for="jkLaki<?= $dsn['id'] ?>">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkPerempuan<?= $dsn['id'] ?>" value="Perempuan" <?= (isset($dsn['jenis_kelamin']) && $dsn['jenis_kelamin'] == 'Perempuan') ? 'checked' : '' ?>>

                                        <label class="form-check-label" for="jkPerempuan<?= $dsn['id'] ?>">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir<?= $dsn['id'] ?>" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir<?= $dsn['id'] ?>" name="tempat_lahir" value="<?= $dsn['tempat_lahir'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir<?= $dsn['id'] ?>" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir<?= $dsn['id'] ?>" name="tanggal_lahir" value="<?= $dsn['tanggal_lahir'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat<?= $dsn['id'] ?>" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat<?= $dsn['id'] ?>" name="alamat" rows="3" required><?= $dsn['alamat'] ?? '' ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="no_telepon<?= $dsn['id'] ?>" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="no_telepon<?= $dsn['id'] ?>" name="no_telepon" value="<?= $dsn['no_telepon'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email<?= $dsn['id'] ?>" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email<?= $dsn['id'] ?>" name="email" value="<?= $dsn['email'] ?? '' ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi<?= $dsn['id'] ?>" class="form-label">Program Studi</label>
                                <select class="form-select" id="program_studi<?= $dsn['id'] ?>" name="program_studi" required>
                                    <?php foreach ($program_studi as $prodi) : ?>
                                   <option value="<?= $prodi['nama'] ?>" <?= (isset($dsn['program_studi']) && $dsn['program_studi'] == $prodi['nama']) ? 'selected' : '' ?>><?= $prodi['nama'] ?></option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pendidikan_terakhir<?= $dsn['id'] ?>" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-select" id="pendidikan_terakhir<?= $dsn['id'] ?>" name="pendidikan_terakhir" required>
                                    <option value="S3" <?= (isset($dsn['pendidikan_terakhir']) && $dsn['pendidikan_terakhir'] == 'S3') ? 'selected' : '' ?>>S3 (Doktor)</option>
                                    <option value="S2" <?= (isset($dsn['pendidikan_terakhir']) && $dsn['pendidikan_terakhir'] == 'S2') ? 'selected' : '' ?>>S2 (Magister)</option>
                                    <option value="S1" <?= (isset($dsn['pendidikan_terakhir']) && $dsn['pendidikan_terakhir'] == 'S1') ? 'selected' : '' ?>>S1 (Sarjana)</option>
                                    <option value="D4" <?= (isset($dsn['pendidikan_terakhir']) && $dsn['pendidikan_terakhir'] == 'D4') ? 'selected' : '' ?>>D4</option>
                                    <option value="D3" <?= (isset($dsn['pendidikan_terakhir']) && $dsn['pendidikan_terakhir'] == 'D3') ? 'selected' : '' ?>>D3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan<?= $dsn['id'] ?>" class="form-label">Jabatan</label>
                                <select class="form-select" id="jabatan<?= $dsn['id'] ?>" name="jabatan" required>
                                    <?php foreach ($jabatan_dosen as $jabatan) : ?>
                                    <option value="<?= $jabatan['nama_jabatan'] ?>" <?= (isset($dsn['jabatan']) && $dsn['jabatan'] == $jabatan['nama_jabatan']) ? 'selected' : '' ?>><?= $jabatan['nama_jabatan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="bidang_keahlian<?= $dsn['id'] ?>" class="form-label">Bidang Keahlian</label>
                                <input type="text" class="form-control" id="bidang_keahlian<?= $dsn['id'] ?>" name="bidang_keahlian" value="<?= $dsn['bidang_keahlian'] ?? '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="foto<?= $dsn['id'] ?>" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto<?= $dsn['id'] ?>" name="foto">
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

<!-- Modal Hapus Dosen -->
<div class="modal fade" id="hapusDosenModal<?= $dsn['id'] ?>" tabindex="-1" aria-labelledby="hapusDosenModalLabel<?= $dsn['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="hapusDosenModalLabel<?= $dsn['id'] ?>">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data dosen:</p>
                <p class="fw-bold"><?= $dsn['nidn'] ?? '' ?> - <?= $dsn['nama_lengkap'] ?? '' ?></p>
                <p class="text-danger">Perhatian: Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= base_url('administrator/dosen/hapus/' . $dsn['id']) ?>" class="btn btn-danger">Hapus</a>
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
    const filterJabatan = document.getElementById('filterJabatan');
    const tabelDosen = document.getElementById('tabelDosen').getElementsByTagName('tbody')[0];
    const rows = tabelDosen.getElementsByTagName('tr');
    
    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const prodiValue = filterProdi.value.toLowerCase();
        const jabatanValue = filterJabatan.value.toLowerCase();
        
        for (let i = 0; i < rows.length; i++) {
            const nidn = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            const nama = rows[i].getElementsByTagName('td')[3].textContent.toLowerCase();
            const prodi = rows[i].getElementsByTagName('td')[4].textContent.toLowerCase();
            const jabatan = rows[i].getElementsByTagName('td')[5].textContent.toLowerCase();
            
            const matchSearch = nidn.includes(searchValue) || nama.includes(searchValue);
            const matchProdi = prodiValue === '' || prodi === prodiValue;
            const matchJabatan = jabatanValue === '' || jabatan.includes(jabatanValue);
            
            if (matchSearch && matchProdi && matchJabatan) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
    
    searchInput.addEventListener('keyup', filterTable);
    filterProdi.addEventListener('change', filterTable);
    filterJabatan.addEventListener('change', filterTable);
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>