<?php 
/** 
 * @var array $mahasiswa 
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
            <h4 class="mb-0 font-weight-bold"><i class="bi bi-people-fill me-2"></i>Data Mahasiswa</h4>
            <div class="d-flex gap-2">
                <!-- Tombol Ekspor & Cetak: Hanya untuk Admin, Dosen, dan Pegawai -->
                <?php if (in_array($userRole, ['admin', 'dosen', 'pegawai'])): ?>
                    <a href="index.php?page=mahasiswa&action=ekspor_excel&keyword=<?= urlencode($keyword ?? ''); ?>" class="btn btn-success btn-sm fw-bold" target="_blank"><i class="bi bi-file-earmark-excel"></i> Ekspor Excel</a>
                    <a href="index.php?page=mahasiswa&action=cetak_pdf&keyword=<?= urlencode($keyword ?? ''); ?>" class="btn btn-warning btn-sm fw-bold text-dark" target="_blank"><i class="bi bi-printer"></i> Cetak / PDF</a>
                <?php endif; ?>

                <!-- Tombol Tambah Mahasiswa: Hanya untuk Admin dan Pegawai -->
                <?php if (in_array($userRole, ['admin', 'pegawai'])): ?>
                    <a href="index.php?page=mahasiswa&action=tambah" class="btn btn-light btn-sm fw-bold">+ Tambah Mahasiswa</a>
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
                        <input type="hidden" name="page" value="mahasiswa">
                        <input type="hidden" name="action" value="index">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari berdasarkan Nama atau NIM..." value="<?= htmlspecialchars($keyword ?? ''); ?>">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <?php if (!empty($keyword)): ?>
                            <a href="index.php?page=mahasiswa&action=index" class="btn btn-secondary">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="col-md-6 text-end text-muted small">
                    Total Data: <strong><?= $totalData; ?></strong> Mahasiswa
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Email</th>
                            <th>Prodi</th>
                            <th>Semester</th>
                            <th>No HP</th>
                            <!-- Header Kolom Aksi: Hanya Tampil untuk Admin dan Pegawai -->
                            <?php if (in_array($userRole, ['admin', 'pegawai'])): ?>
                                <th class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($mahasiswa)): ?>
                            <?php $no = $offset + 1; foreach ($mahasiswa as $mhs): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><strong><?= htmlspecialchars($mhs['nim']); ?></strong></td>
                                    <td><?= htmlspecialchars($mhs['nama']); ?></td>
                                    <td><?= $mhs['jenis_kelamin'] === 'L' ? 'Laki-Laki' : 'Perempuan'; ?></td>
                                    <td><?= htmlspecialchars($mhs['email']); ?></td>
                                    <td><?= htmlspecialchars($mhs['prodi']); ?></td>
                                    <td><span class="badge bg-info text-dark">Semester <?= htmlspecialchars($mhs['semester']); ?></span></td>
                                    <td><?= htmlspecialchars($mhs['no_hp'] ?? '-'); ?></td>
                                    
                                    <!-- Isi Kolom Aksi -->
                                    <?php if (in_array($userRole, ['admin', 'pegawai'])): ?>
                                        <td class="text-center">
                                            <!-- Tombol Edit: Muncul untuk Admin dan Pegawai -->
                                            <a href="index.php?page=mahasiswa&action=edit&id=<?= $mhs['id_mahasiswa']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                            
                                            <!-- Tombol Hapus: Hanya Muncul untuk Admin -->
                                            <?php if ($userRole === 'admin'): ?>
                                                <a href="index.php?page=mahasiswa&action=hapus&id=<?= $mhs['id_mahasiswa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i> Hapus</a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <!-- Sesuaikan Colspan Jika Kolom Aksi Diberlakukan atau Disembunyikan -->
                                <td colspan="<?= in_array($userRole, ['admin', 'pegawai']) ? '9' : '8'; ?>" class="text-center py-4 text-muted">
                                    <?= !empty($keyword) ? 'Data tidak ditemukan.' : 'Belum ada data mahasiswa.'; ?>
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
                            <a class="page-link" href="index.php?page=mahasiswa&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page - 1; ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?page=mahasiswa&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?page=mahasiswa&action=index&keyword=<?= urlencode($keyword); ?>&page_num=<?= $page + 1; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>