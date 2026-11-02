<?php 
require_once __DIR__ . '/../models/PengumumanModel.php';

class PengumumanController {
    private $model;

    public function __construct() {
        $this->model = new PengumumanModel();
    }

    public function index() {
        $keyword   = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $limit     = 6;
        $page      = isset($_GET['page_num']) && is_numeric($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
        if ($page < 1) $page = 1;

        $totalData  = $this->model->getTotalPengumuman($keyword);
        $totalPages = ceil($totalData / $limit);
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }

        $offset     = ($page - 1) * $limit;
        $pengumuman = $this->model->getPengumumanPage($limit, $offset, $keyword);

        require_once __DIR__ . '/../views/pengumuman/index.php';
    }

    public function detail($id) {
        $pengumuman = $this->model->getPengumumanById($id);
        if (!$pengumuman) {
            $_SESSION['flash'] = [
                'type'  => 'danger',
                'pesan' => 'Pengumuman tidak ditemukan!'
            ];
            header('Location: index.php?page=pengumuman&action=index');
            exit;
        }
        require_once __DIR__ . '/../views/pengumuman/detail.php';
    }

    public function tambah() {
        require_once __DIR__ . '/../views/pengumuman/tambah.php';
    }

    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $judul          = trim($_POST['judul'] ?? '');
            $kategori       = $_POST['kategori'] ?? '';
            $isi_pengumuman = trim($_POST['isi_pengumuman'] ?? '');

            if (empty($judul)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Judul pengumuman wajib diisi!'];
                header('Location: index.php?page=pengumuman&action=tambah');
                exit;
            }

            if (mb_strlen($judul) > 255) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Judul pengumuman tidak boleh lebih dari 255 karakter!'];
                header('Location: index.php?page=pengumuman&action=tambah');
                exit;
            }

            $allowedKategori = ['Umum', 'Akademik', 'Kemahasiswaan', 'Beasiswa'];
            if (!in_array($kategori, $allowedKategori)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Kategori pengumuman tidak valid!'];
                header('Location: index.php?page=pengumuman&action=tambah');
                exit;
            }

            if (empty($isi_pengumuman)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Isi pengumuman wajib diisi!'];
                header('Location: index.php?page=pengumuman&action=tambah');
                exit;
            }

            if (mb_strlen($isi_pengumuman) > 10000) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Isi pengumuman terlalu panjang (maksimal 10.000 karakter)!'];
                header('Location: index.php?page=pengumuman&action=tambah');
                exit;
            }

            $data = [
                'judul'          => $judul,
                'kategori'       => $kategori,
                'isi_pengumuman' => $isi_pengumuman,
                'penulis_id'     => $_SESSION['user']['id_user']
            ];

            if ($this->model->tambahPengumuman($data)) {
                unset($_SESSION['old_input']);
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Pengumuman berhasil dipublikasikan!'
                ];
                header('Location: index.php?page=pengumuman&action=index');
                exit;
            }
        }
    }

    public function edit($id) {
        $pengumuman = $this->model->getPengumumanById($id);
        if (!$pengumuman) {
            $_SESSION['flash'] = [
                'type'  => 'danger',
                'pesan' => 'Pengumuman tidak ditemukan!'
            ];
            header('Location: index.php?page=pengumuman&action=index');
            exit;
        }
        require_once __DIR__ . '/../views/pengumuman/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id             = $_POST['id_pengumuman'] ?? null;
            $judul          = trim($_POST['judul'] ?? '');
            $kategori       = $_POST['kategori'] ?? '';
            $isi_pengumuman = trim($_POST['isi_pengumuman'] ?? '');

            if (empty($id)) {
                header('Location: index.php?page=pengumuman&action=index');
                exit;
            }

            if (empty($judul)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Judul pengumuman wajib diisi!'];
                header('Location: index.php?page=pengumuman&action=edit&id=' . $id);
                exit;
            }

            if (mb_strlen($judul) > 255) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Judul pengumuman tidak boleh lebih dari 255 karakter!'];
                header('Location: index.php?page=pengumuman&action=edit&id=' . $id);
                exit;
            }

            $allowedKategori = ['Umum', 'Akademik', 'Kemahasiswaan', 'Beasiswa'];
            if (!in_array($kategori, $allowedKategori)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Kategori pengumuman tidak valid!'];
                header('Location: index.php?page=pengumuman&action=edit&id=' . $id);
                exit;
            }

            if (empty($isi_pengumuman)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Isi pengumuman wajib diisi!'];
                header('Location: index.php?page=pengumuman&action=edit&id=' . $id);
                exit;
            }

            if (mb_strlen($isi_pengumuman) > 10000) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Isi pengumuman terlalu panjang (maksimal 10.000 karakter)!'];
                header('Location: index.php?page=pengumuman&action=edit&id=' . $id);
                exit;
            }

            $data = [
                'id_pengumuman'  => $id,
                'judul'          => $judul,
                'kategori'       => $kategori,
                'isi_pengumuman' => $isi_pengumuman
            ];

            if ($this->model->updatePengumuman($data)) {
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Pengumuman berhasil diperbarui!'
                ];
                header('Location: index.php?page=pengumuman&action=index');
                exit;
            }
        }
    }

    public function hapus($id) {
        if ($this->model->hapusPengumuman($id)) {
            $_SESSION['flash'] = [
                'type'  => 'success',
                'pesan' => 'Pengumuman berhasil dihapus!'
            ];
        } else {
            $_SESSION['flash'] = [
                'type'  => 'danger',
                'pesan' => 'Gagal menghapus pengumuman!'
            ];
        }
        header('Location: index.php?page=pengumuman&action=index');
        exit;
    }
}