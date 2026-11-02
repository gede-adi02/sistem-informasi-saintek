<?php  
/**
  * @var int $totalData
  * @var int $totalPages
  * @var int $page
  * @var int $offset
  * @var string $keyword
  */
$userRole = $_SESSION['user']['level_user'] ?? '';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0"><i class="bi bi-megaphone-fill me-2 text-primary"></i>Pengumuman & Informasi</h3>
            <p class="text-muted small mb-0">Informasi resmi seputar akademis dan kegiatan Fakultas Saintek</p>
        </div>
        <?php if (in_array($userRole, ['admin', 'pegawai'])): ?>
            <a href="index.php?page=pengumuman&action=tambah" class="btn btn-primary fw-bold">+ Buat Pengumuman</a>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash']['pesan']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-6">
            <form action="index.php" method="GET" class="d-flex gap-2">
                <input type="hidden" name="page" value="pengumuman">
                <input type="hidden" name="action" value="index">
                <input type="text" name="keyword" class="form-control" placeholder="Cari judul atau kategori pengumuman..." value="<?= htmlspecialchars($keyword ?? ''); ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
                <?php if (!empty($keyword)): ?>
                    <a href="index.php?page=pengumuman&action=index" class="btn btn-secondary">Reset</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php if (!empty($pengumuman)): ?>
            <?php foreach ($pengumuman as $p): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary text-uppercase"><?= htmlspecialchars($p['kategori']); ?></span>
                                <small class="text-muted"><?= date('d M Y', strtotime($p['created_at'])); ?></small>
                            </div>
                            <h5 class="card-title fw-bold text-dark text-break"><?= htmlspecialchars($p['judul']); ?></h5>
                            <p class="card-text text-muted flex-grow-1 small text-break">
                                <?= htmlspecialchars(mb_substr($p['isi_pengumuman'], 0, 120)); ?><?= mb_strlen($p['isi_pengumuman']) > 120 ? '...' : ''; ?>
                            </p>
                            <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center">
                                <small class="text-muted text-break"><i class="bi bi-person me-1"></i><?= htmlspecialchars($p['penulis']); ?></small>
                                <div class="d-flex gap-1">
                                    <a href="index.php?page=pengumuman&action=detail&id=<?= $p['id_pengumuman']; ?>" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                                    
                                    <?php if (in_array($userRole, ['admin', 'pegawai'])): ?>
                                        <a href="index.php?page=pengumuman&action=edit&id=<?= $p['id_pengumuman']; ?>" class="btn btn-warning btn-sm text-dark"><i class="bi bi-pencil-square"></i></a>
                                    <?php endif; ?>
                                    
                                    <?php if ($userRole === 'admin'): ?>
                                        <a href="index.php?page=pengumuman&action=hapus&id=<?= $p['id_pengumuman']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pengumuman ini?')"><i class="bi bi-trash"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                <?= !empty($keyword) ? 'Pengumuman tidak ditemukan.' : 'Belum ada pengumuman yang dipublikasikan.'; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center mb-0">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?page=pengumuman&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page - 1; ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?page=pengumuman&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?page=pengumuman&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page + 1; ?>">Next</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>