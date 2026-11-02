<?php 
http_response_code(403);
$userRole = $_SESSION['user']['level_user'] ?? 'guest';
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container my-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0 py-4 px-3">
                <div class="card-body">
                    <div class="mb-3 text-danger">
                        <i class="bi bi-shield-lock-fill display-1"></i>
                    </div>
                    <h1 class="display-3 fw-bold text-dark mb-0">403</h1>
                    <h4 class="fw-bold mb-3">Akses Ditolak! (Access Denied)</h4>
                    <p class="text-muted mb-4">
                        Maaf, akun Anda yang terdaftar sebagai 
                        <span class="badge bg-danger text-uppercase fs-6 ms-1"><?= htmlspecialchars($userRole); ?></span> 
                        tidak memiliki izin untuk mengakses halaman atau menjalankan tindakan ini.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="index.php?page=dashboard" class="btn btn-primary fw-bold">
                            <i class="bi bi-speedometer2 me-1"></i> Kembali ke Dashboard
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Halaman Sebelumnya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>