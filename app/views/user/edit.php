<?php 
/** @var array $user */
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container my-4" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Data User</h4>
        </div>
        <div class="card-body p-4">
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flash']['pesan']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <form action="index.php?page=user&action=update" method="POST">
                <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">
                                
                <div class="mb-3">
                    <label class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" maxlength="50" oninput="this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '')" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah password)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="Ketik password baru jika ingin diganti" maxlength="100">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap Pengguna <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($user['nama_lengkap']); ?>" maxlength="100" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\',\-]/g, '')" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Role / Level User <span class="text-danger">*</span></label>
                        <select name="level_user" class="form-select" required>
                            <option value="admin" <?= $user['level_user'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="dosen" <?= $user['level_user'] === 'dosen' ? 'selected' : ''; ?>>Dosen</option>
                            <option value="pegawai" <?= $user['level_user'] === 'pegawai' ? 'selected' : ''; ?>>Pegawai</option>
                            <option value="mahasiswa" <?= $user['level_user'] === 'mahasiswa' ? 'selected' : ''; ?>>Mahasiswa</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Status Akun <span class="text-danger">*</span></label>
                        <select name="status_akun" class="form-select" required>
                            <option value="aktif" <?= $user['status_akun'] === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="nonaktif" <?= $user['status_akun'] === 'nonaktif' ? 'selected' : ''; ?>>Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php?page=user&action=index" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning fw-bold">Update Data User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>