<?php 
/** @var array $pengumuman */
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container my-4" style="max-width: 800px;">
    <a href="index.php?page=pengumuman&action=index" class="btn btn-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pengumuman</a>
    <div class="card shadow-sm border-0 p-4">
        <div class="card-body">
            <span class="badge bg-primary text-uppercase mb-2"><?= htmlspecialchars($pengumuman['kategori']); ?></span>
            <h2 class="fw-bold mb-3 text-break"><?= htmlspecialchars($pengumuman['judul']); ?></h2>
            <div class="text-muted small border-bottom pb-3 mb-4 d-flex justify-content-between flex-wrap gap-2">
                <span><i class="bi bi-person me-1"></i> Dipublikasikan oleh <strong class="text-break"><?= htmlspecialchars($pengumuman['penulis']); ?></strong></span>
                <span><i class="bi bi-calendar3 me-1"></i> <?= date('d F Y, H:i', strtotime($pengumuman['created_at'])); ?></span>
            </div>
            <div class="content lh-lg text-break">
                <?= nl2br(htmlspecialchars($pengumuman['isi_pengumuman'])); ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>