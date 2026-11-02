<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Fakultas Sains dan Teknologi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<!-- Navbar Utama -->
<nav class="navbar navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <button class="btn btn-primary me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <i class="bi bi-list fs-4"></i>
            </button>
            <a class="navbar-brand d-flex align-items-center gap-2 font-weight-bold" href="index.php">
                <img src="assets/img/logo-fast.png" alt="Logo FAST" width="30" height="30" class="bg-white rounded-circle p-1">
                <span>Sistem Informasi Fakultas Sains dan Teknologi</span>
            </a>
        </div>
        
        <?php if (isset($_SESSION['user'])): ?>
            <div class="dropdown text-end">
                <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-5 me-1"></i>
                    <span class="d-none d-md-inline"><?= htmlspecialchars($_SESSION['user']['nama_lengkap']); ?></span>
                    <span class="badge bg-light text-dark ms-1 text-uppercase"><?= htmlspecialchars($_SESSION['user']['level_user']); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                    <li><span class="dropdown-item-text text-muted small">Login sebagai: <strong><?= htmlspecialchars($_SESSION['user']['username']); ?></strong></span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger fw-bold" href="index.php?page=auth&action=logout" onclick="return confirm('Yakin ingin keluar dari sistem?')">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>

<?php require_once __DIR__ . '/sidebar.php'; ?>