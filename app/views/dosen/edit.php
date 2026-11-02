<?php 
/** @var array $dosen */ 
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container my-4" style="max-width: 700px;">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Data Dosen</h4>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flash']['pesan']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <form action="index.php?page=dosen&action=update" method="POST">
                <input type="hidden" name="id_dosen" value="<?= $dosen['id_dosen']; ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">NIDN <span class="text-danger">*</span></label>
                        <input type="text" name="nidn" class="form-control" value="<?= htmlspecialchars($dosen['nidn']); ?>" maxlength="30" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">NIP <small class="text-muted">(Opsional)</small></label>
                        <input type="text" name="nip" class="form-control" value="<?= htmlspecialchars($dosen['nip'] ?? ''); ?>" maxlength="30" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap Dosen <span class="text-danger">*</span></label>
                    <input type="text" name="nama_dosen" class="form-control" value="<?= htmlspecialchars($dosen['nama_dosen']); ?>" maxlength="100" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\',\-]/g, '')" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="L" <?= $dosen['jenis_kelamin'] === 'L' ? 'selected' : ''; ?>>Laki-Laki</option>
                            <option value="P" <?= $dosen['jenis_kelamin'] === 'P' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($dosen['email']); ?>" maxlength="100" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Program Studi <span class="text-danger">*</span></label>
                        <input type="text" name="prodi" class="form-control" value="<?= htmlspecialchars($dosen['prodi']); ?>" maxlength="100" oninput="this.value = this.value.replace(/[0-9]/g, '')" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jabatan Fungsional</label>
                        <select name="jabatan_fungsional" class="form-select">
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Tenaga Pengajar" <?= $dosen['jabatan_fungsional'] === 'Tenaga Pengajar' ? 'selected' : ''; ?>>Tenaga Pengajar</option>
                            <option value="Asisten Ahli" <?= $dosen['jabatan_fungsional'] === 'Asisten Ahli' ? 'selected' : ''; ?>>Asisten Ahli</option>
                            <option value="Lektor" <?= $dosen['jabatan_fungsional'] === 'Lektor' ? 'selected' : ''; ?>>Lektor</option>
                            <option value="Lektor Kepala" <?= $dosen['jabatan_fungsional'] === 'Lektor Kepala' ? 'selected' : ''; ?>>Lektor Kepala</option>
                            <option value="Guru Besar" <?= $dosen['jabatan_fungsional'] === 'Guru Besar' ? 'selected' : ''; ?>>Guru Besar</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($dosen['no_hp'] ?? ''); ?>" maxlength="20" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php?page=dosen&action=index" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning fw-bold">Update Data Dosen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>