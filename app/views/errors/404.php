<?php 
http_response_code(404);
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container my-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0 py-4 px-3">
                <div class="card-body">
                    <div class="mb-3 text-warning">
                        <i class="bi bi-exclamation-triangle-fill display-1"></i>
                    </div>
                    <h1 class="display-3 fw-bold text-dark mb-0">404</h1>
                    <h4 class="fw-bold mb-3">Halaman Tidak Ditemukan!</h4>
                    <p class="text-muted mb-4">
                        Maaf, modul atau halaman 
                        <strong class="text-dark">"<?= htmlspecialchars($_GET['page'] ?? 'halaman'); ?>"</strong> 
                        dengan aksi <strong class="text-dark">"<?= htmlspecialchars($_GET['action'] ?? 'index'); ?>"</strong> 
                        tidak ditemukan atau tidak terdaftar pada sistem.
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