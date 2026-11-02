<?php 
/** 
 * @var int $totalMahasiswa
 * @var int $totalDosen 
 * @var int $totalPegawai
 * @var int $totalPengumuman
 */

$user = $_SESSION['user'] ?? [];
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container my-4">
    <!-- Banner Selamat Datang -->
    <div class="p-4 mb-4 bg-primary text-white rounded-3 shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-9">
                <h3 class="fw-bold mb-1">Selamat Datang, <?= htmlspecialchars($user['nama_lengkap'] ?? 'Pengguna'); ?>!</h3>
                <p class="mb-0 opacity-75">Anda masuk sebagai <span class="badge bg-light text-dark text-uppercase fw-bold"><?= htmlspecialchars($user['level_user'] ?? 'Guest'); ?></span> di Sistem Informasi Fakultas Saintek.</p>
            </div>
            <div class="col-md-3 text-end d-none d-md-block">
                <i class="bi bi-globe-asia-australia display-3 opacity-50"></i>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type']; ?> alert-dismissible fade show mb-4" role="alert">
            <?= $_SESSION['flash']['pesan']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- Kartu Statistik -->
    <div class="row g-3 mb-4">
        <!-- Card Mahasiswa -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm bg-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Mahasiswa</span>
                        <h2 class="fw-bold mb-0 text-primary"><?= $totalMahasiswa; ?></h2>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Dosen -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm bg-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Dosen</span>
                        <h2 class="fw-bold mb-0 text-success"><?= $totalDosen; ?></h2>
                    </div>
                    <div class="p-3 bg-success bg-opacity-10 text-success rounded-circle">
                        <i class="bi bi-person-badge-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pegawai -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm bg-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Pegawai</span>
                        <h2 class="fw-bold mb-0 text-warning"><?= $totalPegawai; ?></h2>
                    </div>
                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-circle">
                        <i class="bi bi-person-workspace fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pengumuman -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm bg-white h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Pengumuman</span>
                        <h2 class="fw-bold mb-0 text-info"><?= $totalPengumuman; ?></h2>
                    </div>
                    <div class="p-3 bg-info bg-opacity-10 text-info rounded-circle">
                        <i class="bi bi-megaphone-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Pengumuman Terbaru -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
            <h5 class="fw-bold mb-0"><i class="bi bi-megaphone me-2 text-primary"></i>Pengumuman Terbaru</h5>
            <a href="index.php?page=pengumuman&action=index" class="btn btn-outline-primary btn-sm fw-bold">Lihat Semua <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($latestPengumuman)): ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($latestPengumuman as $p): ?>
                        <div class="list-group-item p-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge bg-primary small text-uppercase"><?= htmlspecialchars($p['kategori']); ?></span>
                                <small class="text-muted"><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($p['created_at'])); ?></small>
                            </div>
                            <h6 class="fw-bold mb-1">
                                <a href="index.php?page=pengumuman&action=detail&id=<?= $p['id_pengumuman']; ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($p['judul']); ?>
                                </a>
                            </h6>
                            <p class="text-muted small mb-2"><?= htmlspecialchars(substr($p['isi_pengumuman'], 0, 150)); ?>...</p>
                            <small class="text-muted"><i class="bi bi-person me-1"></i>Oleh: <?= htmlspecialchars($p['penulis']); ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                    Belum ada pengumuman terbaru.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>