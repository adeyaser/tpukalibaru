<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-chat-left-text me-2"></i><?= esc($title) ?></h4>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Pengirim</th>
                        <th>Subjek</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($messages)) : ?>
                        <?php $no = 1; foreach ($messages as $msg) : ?>
                            <tr class="<?= $msg['is_read'] ? 'text-muted' : 'fw-bold' ?>">
                                <td><?= $no++ ?></td>
                                <td>
                                    <div><?= esc($msg['nama']) ?></div>
                                    <small class="text-muted"><?= esc($msg['email']) ?></small>
                                </td>
                                <td><?= esc($msg['subject']) ?></td>
                                <td><?= date('d M Y H:i', strtotime($msg['created_at'])) ?></td>
                                <td>
                                    <?php if ($msg['is_read']) : ?>
                                        <span class="badge bg-light text-dark border">Dibaca</span>
                                    <?php else : ?>
                                        <span class="badge bg-primary">Baru</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('compro-settings/messages/view/' . $msg['id']) ?>" class="btn btn-info text-white" title="Baca">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('compro-settings/messages/delete/' . $msg['id']) ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada pesan masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
