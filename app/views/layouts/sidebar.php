<?php $userLevel = $_SESSION['user']['level_user'] ?? ''; ?>
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel" style="width: 280px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title d-flex align-items-center gap-2" id="sidebarMenuLabel">
            <i class="bi bi-inboxes"></i> Navigasi Sistem
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="list-group list-group-flush mt-2">
            <!-- Menu Dashboard -->
            <a href="index.php?page=dashboard" class="list-group-item list-group-item-action bg-dark text-white border-0 py-3 <?= ($_GET['page'] ?? 'dashboard') === 'dashboard' ? 'active bg-primary' : ''; ?>">
                <i class="bi bi-window-sidebar me-2"></i> Dashboard Utama
            </a>

            <!-- Menu Khusus ADMIN: Manajemen User -->
            <?php if ($userLevel === 'admin'): ?>
                <a href="index.php?page=user" class="list-group-item list-group-item-action bg-dark text-white border-0 py-3 <?= ($_GET['page'] ?? '') === 'user' ? 'active bg-primary' : ''; ?>">
                    <i class="bi bi-person-gear me-2"></i> Manajemen User
                </a>
            <?php endif; ?>

            <!-- Menu Pengumuman -->
            <a href="index.php?page=pengumuman" class="list-group-item list-group-item-action bg-dark text-white border-0 py-3 <?= ($_GET['page'] ?? '') === 'pengumuman' ? 'active bg-primary' : ''; ?>">
                <i class="bi bi-megaphone-fill me-2"></i> Pengumuman
            </a>

            <!-- Data Mahasiswa -->
            <a href="index.php?page=mahasiswa" class="list-group-item list-group-item-action bg-dark text-white border-0 py-3 <?= ($_GET['page'] ?? '') === 'mahasiswa' ? 'active bg-primary' : ''; ?>">
                <i class="bi bi-people-fill me-2"></i> Data Mahasiswa
            </a>

            <!-- Data Dosen -->
            <?php if (in_array($userLevel, ['admin', 'pegawai', 'dosen'])): ?>
                <a href="index.php?page=dosen" class="list-group-item list-group-item-action bg-dark text-white border-0 py-3 <?= ($_GET['page'] ?? '') === 'dosen' ? 'active bg-primary' : ''; ?>">
                    <i class="bi bi-person-badge-fill me-2"></i> Data Dosen
                </a>
            <?php endif; ?>

            <!-- Data Pegawai -->
            <?php if (in_array($userLevel, ['admin', 'pegawai'])): ?>
                <a href="index.php?page=pegawai" class="list-group-item list-group-item-action bg-dark text-white border-0 py-3 <?= ($_GET['page'] ?? '') === 'pegawai' ? 'active bg-primary' : ''; ?>">
                    <i class="bi bi-person-workspace me-2"></i> Data Pegawai
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="p-3 border-top border-secondary text-center">
        <a href="index.php?page=auth&action=logout" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Yakin ingin keluar?')">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </a>
    </div>
</div>