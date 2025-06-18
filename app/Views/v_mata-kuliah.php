<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Daftar Mata Kuliah</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($mata_kuliah)): ?>
                        <div class="alert alert-info">
                            Tidak ada mata kuliah yang tersedia saat ini.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Semester</th>
                                        <th>Program Studi</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($mata_kuliah as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['kode_matkul'] ?></td>
                                        <td><?= $row['nama_matkul'] ?></td>
                                        <td><?= $row['sks'] ?></td>
                                        <td><?= $row['semester'] ?></td>
                                        <td><?= $row['nama_prodi'] ?></td>
                                        <td><?= $row['deskripsi'] ? $row['deskripsi'] : '-' ?></td>
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