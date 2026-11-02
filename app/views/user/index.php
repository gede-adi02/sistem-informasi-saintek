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
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0 font-weight-bold"><i class="bi bi-person-gear me-2"></i>Manajemen User & Akun</h4>
            <a href="index.php?page=user&action=tambah" class="btn btn-light btn-sm fw-bold">+ Tambah User</a>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['flash']['pesan']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <form action="index.php" method="GET" class="d-flex gap-2">
                        <input type="hidden" name="page" value="user">
                        <input type="hidden" name="action" value="index">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari Username, Nama, atau Role..." value="<?= htmlspecialchars($keyword ?? ''); ?>">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <?php if (!empty($keyword)): ?>
                            <a href="index.php?page=user&action=index" class="btn btn-secondary">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="col-md-6 text-end text-muted small">
                    Total User: <strong><?= $totalData; ?></strong> Pengguna
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Role / Level</th>
                            <th>Status Akun</th>
                            <th>Dibuat Pada</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php $no = $offset + 1; foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><strong><?= htmlspecialchars($u['username']); ?></strong></td>
                                    <td><?= htmlspecialchars($u['nama_lengkap']); ?></td>
                                    <td>
                                        <?php 
                                        $badgeColor = [
                                            'admin'     => 'bg-danger',
                                            'dosen'     => 'bg-success',
                                            'pegawai'   => 'bg-warning text-dark',
                                            'mahasiswa' => 'bg-info text-dark'
                                        ];
                                        ?>
                                        <span class="badge <?= $badgeColor[$u['level_user']] ?? 'bg-secondary'; ?> text-uppercase">
                                            <?= htmlspecialchars($u['level_user']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($u['status_akun'] === 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><small class="text-muted"><?= date('d M Y, H:i', strtotime($u['created_at'])); ?></small></td>
                                    <td class="text-center">
                                        <a href="index.php?page=user&action=edit&id=<?= $u['id_user']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                        <?php if ($u['id_user'] != $_SESSION['user']['id_user']): ?>
                                            <a href="index.php?page=user&action=hapus&id=<?= $u['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')"><i class="bi bi-trash"></i> Hapus</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <?= !empty($keyword) ? 'Data user tidak ditemukan.' : 'Belum ada data user.'; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($totalPages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?page=user&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page - 1; ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?page=user&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?page=user&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page + 1; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>