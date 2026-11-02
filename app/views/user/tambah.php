<?php  
$old = $_SESSION['old_input'] ?? []; 
unset($_SESSION['old_input']); 
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container my-4" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-3">
            <h4 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Tambah User Baru</h4>
        </div>
        <div class="card-body p-4">
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flash']['pesan']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <form action="index.php?page=user&action=simpan" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($old['username'] ?? ''); ?>" placeholder="Contoh: admin2 atau mhs_2026" maxlength="50" oninput="this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '')" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password user" maxlength="100" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap Pengguna <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($old['nama_lengkap'] ?? ''); ?>" placeholder="Nama pemilik akun" maxlength="100" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\',\-]/g, '')" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Role / Level User <span class="text-danger">*</span></label>
                        <select name="level_user" class="form-select" required>
                            <option value="admin" <?= ($old['level_user'] ?? '') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="dosen" <?= ($old['level_user'] ?? '') === 'dosen' ? 'selected' : ''; ?>>Dosen</option>
                            <option value="pegawai" <?= ($old['level_user'] ?? '') === 'pegawai' ? 'selected' : ''; ?>>Pegawai</option>
                            <option value="mahasiswa" <?= ($old['level_user'] ?? '') === 'mahasiswa' ? 'selected' : ''; ?>>Mahasiswa</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Status Akun <span class="text-danger">*</span></label>
                        <select name="status_akun" class="form-select" required>
                            <option value="aktif" <?= ($old['status_akun'] ?? 'aktif') === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="nonaktif" <?= ($old['status_akun'] ?? '') === 'nonaktif' ? 'selected' : ''; ?>>Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php?page=user&action=index" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success fw-bold">Simpan User Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>