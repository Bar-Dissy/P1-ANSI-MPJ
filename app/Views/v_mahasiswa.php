<?= $this->extend('layouts/mhs') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Jadwal Kuliah Semester <?= $semester_aktif ?> - <?= $mahasiswa['program_studi'] ?> (Kelas <?= $mahasiswa['kelas'] ?>)</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($jadwal_kuliah)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Matkul</th>
                                        <th>Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Ruangan</th>
                                        <th>Dosen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($jadwal_kuliah as $jadwal): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($jadwal['kode_matkul']) ?></td>
                                            <td><?= esc($jadwal['nama_matkul']) ?></td>
                                            <td><?= esc($jadwal['sks']) ?></td>
                                            <td><?= esc($jadwal['hari']) ?></td>
                                            <td>
                                                <?= date('H:i', strtotime($jadwal['waktu_mulai'])) ?> - 
                                                <?= date('H:i', strtotime($jadwal['waktu_selesai'])) ?>
                                            </td>
                                            <td><?= esc($jadwal['ruangan']) ?></td>
                                            <td><?= esc($jadwal['nama_dosen']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Tidak ada jadwal kuliah untuk semester <?= $semester_aktif ?> kelas <?= $mahasiswa['kelas'] ?>.
                            <?php if ($semester_aktif > 8): ?>
                                <br>Anda telah menyelesaikan semua semester.
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>