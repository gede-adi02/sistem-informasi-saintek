<?php
session_start();

$page   = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Pengecekan Akses Halaman Login / Auth
if ($page === 'auth') {
    require_once __DIR__ . '/app/controllers/AuthController.php';
    $controller = new AuthController();
} else {
    // Proteksi Halaman: Wajib Login
    if (!isset($_SESSION['user'])) {
        $_SESSION['flash'] = [
            'type'  => 'warning',
            'pesan' => 'Silakan login terlebih dahulu untuk mengakses sistem.'
        ];
        header('Location: index.php?page=auth&action=login');
        exit;
    }

    $userRole = $_SESSION['user']['level_user'];

    // Matrix Hak Akses Berdasarkan Modul (Page) dan Aksi (Action)
    $rbacMatrix = [
        'user' => [
            'index'  => ['admin'],
            'tambah' => ['admin'],
            'simpan' => ['admin'],
            'edit'   => ['admin'],
            'update' => ['admin'],
            'hapus'  => ['admin'],
        ],
        'dashboard' => [
            'index' => ['admin', 'dosen', 'pegawai', 'mahasiswa'],
        ],
        'pengumuman' => [
            'index'  => ['admin', 'dosen', 'pegawai', 'mahasiswa'],
            'detail' => ['admin', 'dosen', 'pegawai', 'mahasiswa'],
            'tambah' => ['admin', 'pegawai'],
            'simpan' => ['admin', 'pegawai'],
            'edit'   => ['admin', 'pegawai'],
            'update' => ['admin', 'pegawai'],
            'hapus'  => ['admin'],
        ],
        'mahasiswa' => [
            'index'        => ['admin', 'dosen', 'pegawai', 'mahasiswa'],
            'tambah'       => ['admin', 'pegawai'],
            'simpan'       => ['admin', 'pegawai'],
            'edit'         => ['admin', 'pegawai'],
            'update'       => ['admin', 'pegawai'],
            'hapus'        => ['admin'],
            'ekspor_excel' => ['admin', 'dosen', 'pegawai'],
            'cetak_pdf'    => ['admin', 'dosen', 'pegawai'],
        ],
        'dosen' => [
            'index'        => ['admin', 'pegawai', 'dosen'],
            'tambah'       => ['admin', 'pegawai'],
            'simpan'       => ['admin', 'pegawai'],
            'edit'         => ['admin', 'pegawai'],
            'update'       => ['admin', 'pegawai'],
            'hapus'        => ['admin'],
            'ekspor_excel' => ['admin', 'pegawai'],
            'cetak_pdf'    => ['admin', 'pegawai'],
        ],
        'pegawai' => [
            'index'        => ['admin', 'pegawai'],
            'tambah'       => ['admin'],
            'simpan'       => ['admin'],
            'edit'         => ['admin'],
            'update'       => ['admin'],
            'hapus'        => ['admin'],
            'ekspor_excel' => ['admin', 'pegawai'],
            'cetak_pdf'    => ['admin', 'pegawai'],
        ]
        
    ];

    // Cek A: Apakah modul (page) terdaftar? Jika tidak -> 404
    if (!array_key_exists($page, $rbacMatrix)) {
        require_once __DIR__ . '/app/views/errors/404.php';
        exit;
    }

    $allowedRoles = $rbacMatrix[$page][$action] ?? null;

    // Cek B: Apakah aksi (action) terdaftar pada modul? Jika tidak -> 404
    if ($allowedRoles === null) {
        require_once __DIR__ . '/app/views/errors/404.php';
        exit;
    }

    // Cek C: Apakah role user punya izin? Jika tidak -> 403
    if (!in_array($userRole, $allowedRoles)) {
        require_once __DIR__ . '/app/views/errors/403.php';
        exit;
    }

    // Dynamic Controller Selection
    switch ($page) {
        case 'user':
            require_once __DIR__ . '/app/controllers/UserController.php';
            $controller = new UserController();
            break;
        case 'dashboard':
            require_once __DIR__ . '/app/controllers/DashboardController.php';
            $controller = new DashboardController();
            break;
        case 'pengumuman':
            require_once __DIR__ . '/app/controllers/PengumumanController.php';
            $controller = new PengumumanController();
            break;
        case 'mahasiswa':
            require_once __DIR__ . '/app/controllers/MahasiswaController.php';
            $controller = new MahasiswaController();
            break;
        case 'dosen':
            require_once __DIR__ . '/app/controllers/DosenController.php';
            $controller = new DosenController();
            break;
        case 'pegawai':
            require_once __DIR__ . '/app/controllers/PegawaiController.php';
            $controller = new PegawaiController();
            break;
        default:
            require_once __DIR__ . '/app/controllers/DashboardController.php';
            $controller = new DashboardController();
            break;
    }
}

// Invokasi Method Controller (Konversi snake_case ke camelCase)
$methodName = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $action))));

if (method_exists($controller, $methodName)) {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if (in_array($action, ['edit', 'hapus', 'detail'])) {
        $controller->$methodName($id);
    } else {
        $controller->$methodName();
    }
} else {
    require_once __DIR__ . '/app/views/errors/404.php';
    exit;
}