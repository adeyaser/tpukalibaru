<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= base_url('compro-settings/messages') ?>" class="btn btn-outline-secondary btn-sm rounded-pill mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h4 class="mb-0 fw-bold"><?= esc($title) ?></h4>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white border-bottom p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bold mb-1 text-white"><?= esc($message['subject']) ?></h5>
                        <p class="mb-0 text-white-50 small">
                            Dari: <span class="fw-medium text-white"><?= esc($message['nama']) ?></span> (&lt;<?= esc($message['email']) ?>&gt;)
                        </p>
                    </div>
                    <div class="text-end">
                        <span class="small text-white-50"><?= date('d M Y, H:i', strtotime($message['created_at'])) ?></span>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="message-content bg-light p-4 rounded-3 mb-4" style="min-height: 200px; white-space: pre-wrap;"><?= esc($message['pesan']) ?></div>
                
                <div class="d-flex gap-2">
                    <a href="mailto:<?= esc($message['email']) ?>" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-reply-fill me-2"></i> Balas via Email
                    </a>
                    <a href="<?= base_url('compro-settings/messages/delete/' . $message['id']) ?>" class="btn btn-outline-danger rounded-pill px-4" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                        <i class="bi bi-trash me-2"></i> Hapus Pesan
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Informasi Tambahan</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <small class="text-muted d-block">IP Address</small>
                        <span><?= esc($message['ip_address'] ?? 'Tidak tercatat') ?></span>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block">Browser / User Agent</small>
                        <small class="text-dark"><?= esc($message['user_agent'] ?? 'Tidak tercatat') ?></small>
                    </li>
                    <li>
                        <small class="text-muted d-block">Status</small>
                        <span class="badge bg-success">Sudah Dibaca</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
