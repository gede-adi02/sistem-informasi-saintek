<?php 
/** 
 * @var array $dosen
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
            <h4 class="mb-0 font-weight-bold"><i class="bi bi-person-badge-fill me-2"></i>Data Dosen</h4>
            <div class="d-flex gap-2">
                <?php if (in_array($userRole, ['admin', 'pegawai'])): ?>
                    <a href="index.php?page=dosen&action=ekspor_excel&keyword=<?= urlencode($keyword ?? ''); ?>" class="btn btn-success btn-sm fw-bold" target="_blank"><i class="bi bi-file-earmark-excel"></i> Ekspor Excel</a>
                    <a href="index.php?page=dosen&action=cetak_pdf&keyword=<?= urlencode($keyword ?? ''); ?>" class="btn btn-warning btn-sm fw-bold text-dark" target="_blank"><i class="bi bi-printer"></i> Cetak / PDF</a>
                    <a href="index.php?page=dosen&action=tambah" class="btn btn-light btn-sm fw-bold">+ Tambah Dosen</a>
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
                        <input type="hidden" name="page" value="dosen">
                        <input type="hidden" name="action" value="index">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari Nama, NIDN, atau NIP..." value="<?= htmlspecialchars($keyword ?? ''); ?>">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <?php if (!empty($keyword)): ?>
                            <a href="index.php?page=dosen&action=index" class="btn btn-secondary">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="col-md-6 text-end text-muted small">
                    Total Data: <strong><?= $totalData; ?></strong> Dosen
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIDN</th>
                            <th>NIP</th>
                            <th>Nama Dosen</th>
                            <th>JK</th>
                            <th>Email</th>
                            <th>Prodi</th>
                            <th>Jabatan Fungsional</th>
                            <th>No HP</th>
                            <?php if (in_array($userRole, ['admin', 'pegawai'])): ?>
                                <th class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dosen)): ?>
                            <?php $no = $offset + 1; foreach ($dosen as $d): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><strong><?= htmlspecialchars($d['nidn']); ?></strong></td>
                                    <td><?= htmlspecialchars($d['nip'] ?? '-'); ?></td>
                                    <td><?= htmlspecialchars($d['nama_dosen']); ?></td>
                                    <td><?= $d['jenis_kelamin'] === 'L' ? 'Laki-Laki' : 'Perempuan'; ?></td>
                                    <td><?= htmlspecialchars($d['email']); ?></td>
                                    <td><?= htmlspecialchars($d['prodi']); ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($d['jabatan_fungsional'] ?? '-'); ?></span></td>
                                    <td><?= htmlspecialchars($d['no_hp'] ?? '-'); ?></td>
                                    <?php if (in_array($userRole, ['admin', 'pegawai'])): ?>
                                        <td class="text-center">
                                            <a href="index.php?page=dosen&action=edit&id=<?= $d['id_dosen']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <?php if ($userRole === 'admin'): ?>
                                                <a href="index.php?page=dosen&action=hapus&id=<?= $d['id_dosen']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data dosen ini?')"><i class="bi bi-trash"></i> Hapus</a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= in_array($userRole, ['admin', 'pegawai']) ? '10' : '9'; ?>" class="text-center py-4 text-muted">
                                    <?= !empty($keyword) ? 'Data dosen tidak ditemukan.' : 'Belum ada data dosen.'; ?>
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
                            <a class="page-link" href="index.php?page=dosen&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page - 1; ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?page=dosen&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?page=dosen&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page + 1; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>