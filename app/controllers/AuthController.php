<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        // Jika sudah login, lempar ke halaman default
        if (isset($_SESSION['user'])) {
            header('Location: index.php?page=mahasiswa&action=index');
            exit;
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function prosesLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Username dan Password wajib diisi!'
                ];
                header('Location: index.php?page=auth&action=login');
                exit;
            }

            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Simpan data login ke Session
                $_SESSION['user'] = [
                    'id_user'      => $user['id_user'],
                    'username'     => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'level_user'   => $user['level_user'],
                    'id_referensi' => $user['id_referensi']
                ];

                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Selamat datang kembali, ' . htmlspecialchars($user['nama_lengkap']) . '!'
                ];

                header('Location: index.php?page=mahasiswa&action=index');
                exit;
            } else {
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Username atau Password salah/tidak aktif!'
                ];
                header('Location: index.php?page=auth&action=login');
                exit;
            }
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        session_start();
        $_SESSION['flash'] = [
            'type'  => 'info',
            'pesan' => 'Anda telah berhasil keluar dari sistem.'
        ];
        header('Location: index.php?page=auth&action=login');
        exit;
    }
}