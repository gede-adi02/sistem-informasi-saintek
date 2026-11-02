<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: Arial, sans-serif; 
        }
        table {
            width: 100%;
            table-layout: fixed; /* Memaksa lebar kolom konsisten */
        }
        th, td {
            word-wrap: break-word;
            word-break: break-word; /* Mencegah teks panjang merusak batas kertas */
        }
        @media print { 
            .no-print { display: none !important; } 
        }
    </style>
</head>
<body class="p-4" onload="window.print()">
    <div class="text-center mb-4">
        <div class="d-flex justify-content-center align-items-center gap-3 mb-2">
            <img src="assets/img/logo.png" alt="Logo" width="60" height="60">
            <h3 class="fw-bold mb-0">FAKULTAS SAINTEK</h3>
        </div>
        <h5 class="text-muted">LAPORAN DATA PEGAWAI</h5>
        <p class="text-muted small mb-0">Tanggal Cetak: <?= date('d F Y'); ?></p>
        <hr>
    </div>
    <table class="table table-bordered align-middle">
        <thead class="table-light text-center">
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
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pegawai)): ?>
                <?php $no = 1; foreach ($pegawai as $p): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><strong><?= htmlspecialchars($p['nip_pegawai'] ?? '-'); ?></strong></td>
                        <td><?= htmlspecialchars($p['nama_pegawai']); ?></td>
                        <td class="text-center"><?= htmlspecialchars($p['jenis_kelamin']); ?></td>
                        <td><?= htmlspecialchars($p['email'] ?? '-'); ?></td>
                        <td><?= htmlspecialchars($p['jenis_pegawai']); ?></td>
                        <td><?= htmlspecialchars($p['status_pegawai']); ?></td>
                        <td class="text-center"><?= htmlspecialchars($p['status_aktif']); ?></td>
                        <td><?= htmlspecialchars($p['no_hp'] ?? '-'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center py-3">Tidak ada data pegawai.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4 no-print text-center">
        <button onclick="window.print()" class="btn btn-primary">Cetak / Simpan PDF</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>
</body>
</html>