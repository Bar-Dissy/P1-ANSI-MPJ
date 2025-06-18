<?= $this->extend('administrator/v_dashboard.php'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <div>
            <a href="<?= base_url('jadwal/export'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export
            </a>
            <?php if(session()->get('role') == 'admin'): ?>
            <a href="<?= base_url('jadwal/create'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal
            </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('jadwal'); ?>" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tahun_akademik_id">Tahun Akademik</label>
                            <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-control">
                                <option value="">-- Pilih Tahun Akademik --</option>
                                <?php foreach($tahun_akademik as $ta): ?>
                                <option value="<?= $ta['id']; ?>" <?= (isset($filter['tahun_akademik_id']) && $filter['tahun_akademik_id'] == $ta['id']) ? 'selected' : ''; ?>>
                                    <?= $ta['nama']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="hari">Hari</label>
                            <select name="hari" id="hari" class="form-control">
                                <option value="">-- Pilih Hari --</option>
                                <?php foreach($hari as $h): ?>
                                <option value="<?= $h; ?>" <?= (isset($filter['hari']) && $filter['hari'] == $h) ? 'selected' : ''; ?>>
                                    <?= $h; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dosen_id">Dosen</label>
                            <select name="dosen_id" id="dosen_id" class="form-control">
                                <option value="">-- Pilih Dosen --</option>
                                <?php foreach($dosen as $d): ?>
                                <option value="<?= $d['id']; ?>" <?= (isset($filter['dosen_id']) && $filter['dosen_id'] == $d['id']) ? 'selected' : ''; ?>>
                                    <?= $d['nama']; ?> <?= $d['gelar'] ? ', '.$d['gelar'] : ''; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ruangan_id">Ruangan</label>
                            <select name="ruangan_id" id="ruangan_id" class="form-control">
                                <option value="">-- Pilih Ruangan --</option>
                                <?php foreach($ruangan as $r): ?>
                                <option value="<?= $r['id']; ?>" <?= (isset($filter['ruangan_id']) && $filter['ruangan_id'] == $r['id']) ? 'selected' : ''; ?>>
                                    <?= $r['kode']; ?> - <?= $r['nama']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="<?= base_url('jadwal'); ?>" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Perkuliahan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Dosen</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Ruangan</th>
                            <th>Tahun Akademik</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach($jadwal as $j): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $j['kode_mk']; ?></td>
                            <td><?= $j['nama_mk']; ?></td>
                            <td><?= $j['sks']; ?></td>
                            <td><?= $j['nama_dosen']; ?><?= $j['gelar'] ? ', '.$j['gelar'] : ''; ?></td>
                            <td><?= $j['hari']; ?></td>
                            <td><?= date('H:i', strtotime($j['jam_mulai'])) . ' - ' . date('H:i', strtotime($j['jam_selesai'])); ?></td>
                            <td><?= $j['kode_ruangan']; ?> - <?= $j['nama_ruangan']; ?></td>
                            <td><?= $j['tahun_akademik']; ?> (<?= $j['semester']; ?>)</td>
                            <td>
                                <?php if($j['status_jadwal'] == 'aktif'): ?>
                                    <span class="badge badge-success">Aktif</span>
                                <?php elseif($j['status_jadwal'] == 'ditunda'): ?>
                                    <span class="badge badge-warning">Ditunda</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Dibatalkan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('jadwal/detail/' . $j['id']); ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if(session()->get('role') == 'admin' || session()->get('role') == 'dosen'): ?>
                                <a href="<?= base_url('jadwal/edit/' . $j['id']); ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(session()->get('role') == 'admin'): ?>
                                <form action="<?= base_url('jadwal/delete/' . $j['id']); ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($jadwal)): ?>
                        <tr>
                            <td colspan="11" class="text-center">Tidak ada data jadwal yang tersedia</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
<?= $this->endSection(); ?>