<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Jadwal Perkuliahan</h5>
                </div>
                <div class="card-body">
                    <!-- Form Filter -->
                    <form method="get" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="prodi_id" class="form-label">Program Studi</label>
                            <select class="form-select" id="prodi_id" name="prodi_id">
                                <option value="">Semua Program Studi</option>
                                <?php foreach ($program_studi as $prodi): ?>
                                    <option value="<?= $prodi['id'] ?>" <?= (isset($prodi_id) && $prodi_id == $prodi['id']) ? 'selected' : '' ?>>
                                        <?= $prodi['nama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-select" id="semester" name="semester">
                                <option value="">Semua Semester</option>
                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?= $i ?>" <?= (isset($semester) && $semester == $i) ? 'selected' : '' ?>>
                                        Semester <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas" name="kelas">
                                <option value="">Semua Kelas</option>
                                <?php foreach ($kelas_options as $kelas_option): ?>
                                    <option value="<?= $kelas_option['kelas'] ?>" <?= (isset($kelas) && $kelas == $kelas_option['kelas']) ? 'selected' : '' ?>>
                                        <?= $kelas_option['kelas'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <?php if ($prodi_id || $semester || $kelas): ?>
                                <a href="<?= current_url() ?>" class="btn btn-outline-secondary ms-2">Reset</a>
                            <?php endif; ?>
                        </div>
                    </form>
                    
                    <?php if (empty($jadwal)): ?>
                        <div class="alert alert-info">
                            Tidak ada jadwal perkuliahan yang tersedia dengan filter yang dipilih.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Semester</th>
                                        <th>Hari</th>
                                        <th>Waktu</th>
                                        <th>Ruangan</th>
                                        <th>Dosen</th>
                                        <th>Kelas</th>
                                        <th>Tahun Akademik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($jadwal as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['kode_matkul'] ?></td>
                                        <td><?= $row['nama_matkul'] ?></td>
                                        <td><?= $row['sks'] ?></td>
                                        <td><?= $row['semester'] ?></td>
                                        <td><?= $row['hari'] ?></td>
                                        <td><?= date('H:i', strtotime($row['waktu_mulai'])) ?> - <?= date('H:i', strtotime($row['waktu_selesai'])) ?></td>
                                        <td><?= $row['ruangan'] ?></td>
                                        <td><?= $row['nama_dosen'] ?></td>
                                        <td><?= $row['kelas'] ?></td>
                                        <td><?= $row['tahun_akademik'] ?></td>
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
<?= $this->endSection() ?>