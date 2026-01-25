<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-people me-2"></i><?= esc($title) ?></h4>
    <a href="<?= base_url('keluarga/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Data
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Nama Keluarga</th>
                        <th>Relasi</th>
                        <th>Jenazah Terkait</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keluarga as $item): ?>
                        <tr>
                            <td><?= esc($item['nama_lengkap']) ?></td>
                            <td><?= esc($item['hubungan']) ?></td>
                            <td><?= esc($item['nama_jenazah']) ?></td>
                            <td><?= esc($item['no_telepon']) ?></td>
                            <td><?= esc($item['alamat']) ?></td>
                            <td>
                                <a href="<?= base_url('keluarga/edit/' . $item['id']) ?>" 
                                   class="btn btn-warning btn-sm" 
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="confirmDelete('<?= base_url('keluarga/delete/' . $item['id']) ?>')"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
