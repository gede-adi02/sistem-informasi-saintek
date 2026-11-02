<?php 
$old = $_SESSION['old_input'] ?? []; 
unset($_SESSION['old_input']); 
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container my-4" style="max-width: 700px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Tambah Data Mahasiswa</h4>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flash']['pesan']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <form action="index.php?page=mahasiswa&action=simpan" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">NIM <span class="text-danger">*</span></label>
                        <input type="text" name="nim" class="form-control" value="<?= htmlspecialchars($old['nim'] ?? ''); ?>" placeholder="Contoh: 22001001" maxlength="20" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($old['nama'] ?? $mahasiswa['nama'] ?? ''); ?>" placeholder="Nama lengkap mahasiswa" maxlength="100" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\',\-]/g, '')" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" <?= ($old['jenis_kelamin'] ?? '') === 'L' ? 'selected' : ''; ?>>Laki-Laki</option>
                            <option value="P" <?= ($old['jenis_kelamin'] ?? '') === 'P' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? $mahasiswa['email'] ?? ''); ?>" placeholder="nama@email.com" maxlength="100" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Program Studi (Prodi) <span class="text-danger">*</span></label>
                        <input type="text" name="prodi" class="form-control" value="<?= htmlspecialchars($old['prodi'] ?? $mahasiswa['prodi'] ?? ''); ?>" placeholder="Informatika" maxlength="100" oninput="this.value = this.value.replace(/[0-9]/g, '')" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                        <input type="number" name="semester" class="form-control" min="1" max="14" value="<?= htmlspecialchars($old['semester'] ?? '1'); ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($old['no_hp'] ?? ''); ?>" placeholder="081234567890" maxlength="20" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" maxlength="1000" placeholder="Alamat domisili/tempat tinggal"><?= htmlspecialchars($old['alamat'] ?? $mahasiswa['alamat'] ?? ''); ?></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php?page=mahasiswa&action=index" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>