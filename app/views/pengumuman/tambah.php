<?php 
$old = $_SESSION['old_input'] ?? []; 
unset($_SESSION['old_input']); 
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container my-4" style="max-width: 700px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Buat Pengumuman Baru</h4>
        </div>
        <div class="card-body p-4">
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flash']['pesan']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <form action="index.php?page=pengumuman&action=simpan" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Pengumuman <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($old['judul'] ?? ''); ?>" placeholder="Masukkan judul pengumuman" maxlength="255" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori" class="form-select" required>
                        <option value="Umum" <?= ($old['kategori'] ?? '') === 'Umum' ? 'selected' : ''; ?>>Umum</option>
                        <option value="Akademik" <?= ($old['kategori'] ?? '') === 'Akademik' ? 'selected' : ''; ?>>Akademik</option>
                        <option value="Kemahasiswaan" <?= ($old['kategori'] ?? '') === 'Kemahasiswaan' ? 'selected' : ''; ?>>Kemahasiswaan</option>
                        <option value="Beasiswa" <?= ($old['kategori'] ?? '') === 'Beasiswa' ? 'selected' : ''; ?>>Beasiswa</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Pengumuman <span class="text-danger">*</span></label>
                    <textarea name="isi_pengumuman" class="form-control" rows="8" placeholder="Tuliskan isi pengumuman secara detail (maksimal 10.000 karakter)..." maxlength="10000" required><?= htmlspecialchars($old['isi_pengumuman'] ?? ''); ?></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php?page=pengumuman&action=index" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary fw-bold">Publikasikan Pengumuman</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>