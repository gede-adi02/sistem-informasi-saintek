<?php 
$old = $_SESSION['old_input'] ?? []; 
unset($_SESSION['old_input']); 
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container my-4" style="max-width: 700px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Tambah Data Pegawai</h4>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flash']['pesan']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <form action="index.php?page=pegawai&action=simpan" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">NIP Pegawai <small class="text-muted">(Opsional untuk Non-PNS/Kontrak)</small></label>
                        <input type="text" name="nip_pegawai" class="form-control" value="<?= htmlspecialchars($old['nip_pegawai'] ?? ''); ?>" placeholder="Contoh: 199001012015011001" maxlength="30" oninput="this.value = this.value.replace(/[^0-9]/g, '')" autofocus>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap Pegawai <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pegawai" class="form-control" value="<?= htmlspecialchars($old['nama_pegawai'] ?? ''); ?>" placeholder="Nama pegawai" maxlength="100" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\',\-]/g, '')" required>
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
                        <label class="form-label fw-bold">Email <small class="text-muted">(Opsional)</small></label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? ''); ?>" placeholder="pegawai@email.com" maxlength="100">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Jenis Pegawai <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_pegawai" class="form-control" value="<?= htmlspecialchars($old['jenis_pegawai'] ?? ''); ?>" placeholder="Staf Administrasi, Teknis, OB, dll." maxlength="50" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Status Kepegawaian <span class="text-danger">*</span></label>
                        <select name="status_pegawai" class="form-select" required>
                            <option value="PNS" <?= ($old['status_pegawai'] ?? '') === 'PNS' ? 'selected' : ''; ?>>PNS</option>
                            <option value="PPPK" <?= ($old['status_pegawai'] ?? '') === 'PPPK' ? 'selected' : ''; ?>>PPPK</option>
                            <option value="Kontrak" <?= ($old['status_pegawai'] ?? '') === 'Kontrak' ? 'selected' : ''; ?>>Kontrak</option>
                            <option value="Tetap Non-PNS" <?= ($old['status_pegawai'] ?? '') === 'Tetap Non-PNS' ? 'selected' : ''; ?>>Tetap Non-PNS</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Status Aktif <span class="text-danger">*</span></label>
                        <select name="status_aktif" class="form-select" required>
                            <option value="Aktif" <?= ($old['status_aktif'] ?? 'Aktif') === 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="Non-Aktif" <?= ($old['status_aktif'] ?? '') === 'Non-Aktif' ? 'selected' : ''; ?>>Non-Aktif</option>
                            <option value="Cuti" <?= ($old['status_aktif'] ?? '') === 'Cuti' ? 'selected' : ''; ?>>Cuti</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($old['no_hp'] ?? ''); ?>" placeholder="081234567890" maxlength="20" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php?page=pegawai&action=index" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success fw-bold">Simpan Data Pegawai</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>