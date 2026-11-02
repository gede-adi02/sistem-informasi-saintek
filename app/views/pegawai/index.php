<?php 
/** 
 * @var array $pegawai
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
            <h4 class="mb-0 font-weight-bold"><i class="bi bi-person-workspace me-2"></i>Data Pegawai</h4>
            <div class="d-flex gap-2">
                <?php if (in_array($userRole, ['admin', 'pegawai'])): ?>
                    <a href="index.php?page=pegawai&action=ekspor_excel&keyword=<?= urlencode($keyword ?? ''); ?>" class="btn btn-success btn-sm fw-bold" target="_blank"><i class="bi bi-file-earmark-excel"></i> Ekspor Excel</a>
                    <a href="index.php?page=pegawai&action=cetak_pdf&keyword=<?= urlencode($keyword ?? ''); ?>" class="btn btn-warning btn-sm fw-bold text-dark" target="_blank"><i class="bi bi-printer"></i> Cetak / PDF</a>
                <?php endif; ?>
                <?php if ($userRole === 'admin'): ?>
                    <a href="index.php?page=pegawai&action=tambah" class="btn btn-light btn-sm fw-bold">+ Tambah Pegawai</a>
                <?php endif; ?>
            </div>
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
                        <input type="hidden" name="page" value="pegawai">
                        <input type="hidden" name="action" value="index">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari Nama, NIP, atau Jenis Pegawai..." value="<?= htmlspecialchars($keyword ?? ''); ?>">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <?php if (!empty($keyword)): ?>
                            <a href="index.php?page=pegawai&action=index" class="btn btn-secondary">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="col-md-6 text-end text-muted small">
                    Total Data: <strong><?= $totalData; ?></strong> Pegawai
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIP Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>JK</th>
                            <th>Email</th>
                            <th>Jenis Pegawai</th>
                            <th>Status Pegawai</th>
                            <th>Status Aktif</th>
                            <th>No HP</th>
                            <?php if ($userRole === 'admin'): ?>
                                <th class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pegawai)): ?>
                            <?php $no = $offset + 1; foreach ($pegawai as $p): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><strong><?= htmlspecialchars($p['nip_pegawai'] ?? '-'); ?></strong></td>
                                    <td><?= htmlspecialchars($p['nama_pegawai']); ?></td>
                                    <td><?= $p['jenis_kelamin'] === 'L' ? 'Laki-Laki' : 'Perempuan'; ?></td>
                                    <td><?= htmlspecialchars($p['email'] ?? '-'); ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($p['jenis_pegawai']); ?></span></td>
                                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($p['status_pegawai']); ?></span></td>
                                    <td>
                                        <?php if ($p['status_aktif'] === 'Aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php elseif ($p['status_aktif'] === 'Cuti'): ?>
                                            <span class="badge bg-warning text-dark">Cuti</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($p['no_hp'] ?? '-'); ?></td>
                                    <?php if ($userRole === 'admin'): ?>
                                        <td class="text-center">
                                            <a href="index.php?page=pegawai&action=edit&id=<?= $p['id_pegawai']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <a href="index.php?page=pegawai&action=hapus&id=<?= $p['id_pegawai']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data pegawai ini?')"><i class="bi bi-trash"></i> Hapus</a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= $userRole === 'admin' ? '10' : '9'; ?>" class="text-center py-4 text-muted">
                                    <?= !empty($keyword) ? 'Data pegawai tidak ditemukan.' : 'Belum ada data pegawai.'; ?>
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
                            <a class="page-link" href="index.php?page=pegawai&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page - 1; ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?page=pegawai&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?page=pegawai&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page + 1; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>