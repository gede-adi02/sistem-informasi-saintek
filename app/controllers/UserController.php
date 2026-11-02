<?php 
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function index() {
        $keyword   = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $limit     = 10;
        $page      = isset($_GET['page_num']) && is_numeric($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
        if ($page < 1) $page = 1;

        $totalData  = $this->model->getTotalUser($keyword);
        $totalPages = ceil($totalData / $limit);
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $limit;
        $users  = $this->model->getUserPage($limit, $offset, $keyword);

        require_once __DIR__ . '/../views/user/index.php';
    }

    public function tambah() {
        require_once __DIR__ . '/../views/user/tambah.php';
    }

    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username     = trim($_POST['username'] ?? '');
            $password     = trim($_POST['password'] ?? '');
            $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
            $level_user   = $_POST['level_user'] ?? '';
            $status_akun  = $_POST['status_akun'] ?? '';

            // Validasi Username
            if (empty($username)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username wajib diisi!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }
            if (strlen($username) > 50) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username tidak boleh lebih dari 50 karakter!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username hanya boleh berisi huruf, angka, dan underscore (_)!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }

            // Validasi Password
            if (empty($password)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Password wajib diisi!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }
            if (strlen($password) > 100) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Password tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }

            // Validasi Nama Lengkap
            if (empty($nama_lengkap)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama lengkap pengguna wajib diisi!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }
            if (!preg_match("/^[a-zA-Z\s\.\',\-]+$/", $nama_lengkap)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama lengkap hanya boleh berisi huruf, spasi, titik, koma, petik, dan tanda hubung!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }
            if (strlen($nama_lengkap) > 100) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama lengkap tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }

            // Validasi Level User & Status Akun
            $allowedRoles  = ['admin', 'dosen', 'pegawai', 'mahasiswa'];
            $allowedStatus = ['aktif', 'nonaktif'];

            if (!in_array($level_user, $allowedRoles)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Role / Level User tidak valid!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }
            if (!in_array($status_akun, $allowedStatus)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Status Akun tidak valid!'];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }

            // Cek Duplikasi Username
            if ($this->model->checkDuplicateUsername($username)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Username <strong>' . htmlspecialchars($username) . '</strong> sudah digunakan!'
                ];
                header('Location: index.php?page=user&action=tambah');
                exit;
            }

            $data = [
                'username'     => $username,
                'password'     => password_hash($password, PASSWORD_BCRYPT),
                'nama_lengkap' => $nama_lengkap,
                'level_user'   => $level_user,
                'status_akun'  => $status_akun
            ];

            if ($this->model->tambahUser($data)) {
                unset($_SESSION['old_input']);
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'User baru berhasil ditambahkan!'
                ];
                header('Location: index.php?page=user&action=index');
                exit;
            }
        }
    }

    public function edit($id) {
        $user = $this->model->getUserById($id);
        if (!$user) {
            $_SESSION['flash'] = [
                'type'  => 'danger',
                'pesan' => 'User tidak ditemukan!'
            ];
            header('Location: index.php?page=user&action=index');
            exit;
        }
        require_once __DIR__ . '/../views/user/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id           = $_POST['id_user'] ?? null;
            $username     = trim($_POST['username'] ?? '');
            $password     = trim($_POST['password'] ?? '');
            $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
            $level_user   = $_POST['level_user'] ?? '';
            $status_akun  = $_POST['status_akun'] ?? '';

            if (empty($id)) {
                header('Location: index.php?page=user&action=index');
                exit;
            }

            // Validasi Username
            if (empty($username)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username wajib diisi!'];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }
            if (strlen($username) > 50) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username tidak boleh lebih dari 50 karakter!'];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username hanya boleh berisi huruf, angka, dan underscore (_)!'];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }

            // Validasi Password Baru (Opsional)
            if (!empty($password) && strlen($password) > 100) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Password baru tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }

            // Validasi Nama Lengkap
            if (empty($nama_lengkap)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama lengkap pengguna wajib diisi!'];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }
            if (!preg_match("/^[a-zA-Z\s\.\',\-]+$/", $nama_lengkap)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama lengkap hanya boleh berisi huruf, spasi, titik, koma, petik, dan tanda hubung!'];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }
            if (strlen($nama_lengkap) > 100) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama lengkap tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }

            // Validasi Role & Status Akun
            $allowedRoles  = ['admin', 'dosen', 'pegawai', 'mahasiswa'];
            $allowedStatus = ['aktif', 'nonaktif'];

            if (!in_array($level_user, $allowedRoles)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Role / Level User tidak valid!'];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }
            if (!in_array($status_akun, $allowedStatus)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Status Akun tidak valid!'];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }

            // Cek Duplikasi Username
            if ($this->model->checkDuplicateUsername($username, $id)) {
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => 'Username <strong>' . htmlspecialchars($username) . '</strong> sudah digunakan oleh user lain!'
                ];
                header('Location: index.php?page=user&action=edit&id=' . $id);
                exit;
            }

            $data = [
                'id_user'      => $id,
                'username'     => $username,
                'nama_lengkap' => $nama_lengkap,
                'level_user'   => $level_user,
                'status_akun'  => $status_akun,
                'password'     => !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null
            ];

            if ($this->model->updateUser($data)) {
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Data user berhasil diperbarui!'
                ];
                header('Location: index.php?page=user&action=index');
                exit;
            }
        }
    }

    public function hapus($id) {
        if ($id == $_SESSION['user']['id_user']) {
            $_SESSION['flash'] = [
                'type'  => 'danger',
                'pesan' => 'Anda tidak bisa menghapus akun Anda sendiri saat sedang login!'
            ];
            header('Location: index.php?page=user&action=index');
            exit;
        }

        if ($this->model->hapusUser($id)) {
            $_SESSION['flash'] = [
                'type'  => 'success',
                'pesan' => 'User berhasil dihapus!'
            ];
        } else {
            $_SESSION['flash'] = [
                'type'  => 'danger',
                'pesan' => 'Gagal menghapus user!'
            ];
        }
        header('Location: index.php?page=user&action=index');
        exit;
    }
}