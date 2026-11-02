<?php
require_once __DIR__ . '/../models/PegawaiModel.php';

class PegawaiController {
    private $model;

    public function __construct() {
        $this->model = new PegawaiModel();
    }

    public function index() {
        $keyword   = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $limit     = 10;
        $page      = isset($_GET['page_num']) && is_numeric($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
        if ($page < 1) $page = 1;
        $totalData  = $this->model->getTotalPegawai($keyword);
        $totalPages = ceil($totalData / $limit);
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }
        $offset  = ($page - 1) * $limit;
        $pegawai = $this->model->getPegawaiPage($limit, $offset, $keyword);
        require_once __DIR__ . '/../views/pegawai/index.php';
    }

    public function tambah() {
        require_once __DIR__ . '/../views/pegawai/tambah.php';
    }

    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nip_pegawai   = !empty($_POST['nip_pegawai']) ? trim($_POST['nip_pegawai']) : null;
            $nama_pegawai  = trim($_POST['nama_pegawai']);
            $email         = !empty($_POST['email']) ? trim($_POST['email']) : null;
            $jenis_pegawai = trim($_POST['jenis_pegawai']);
            $no_hp         = trim($_POST['no_hp'] ?? '');

            if (!empty($nip_pegawai)) {
                if (!ctype_digit($nip_pegawai)) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIP Pegawai hanya boleh berisi angka!'];
                    header('Location: index.php?page=pegawai&action=tambah');
                    exit;
                }
                if (strlen($nip_pegawai) > 30) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIP Pegawai tidak boleh lebih dari 30 digit!'];
                    header('Location: index.php?page=pegawai&action=tambah');
                    exit;
                }
            }

            if (!preg_match("/^[a-zA-Z\s\.\',\-]+$/", $nama_pegawai)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama Pegawai hanya boleh berisi huruf, spasi, titik, koma, petik, dan tanda hubung!'];
                header('Location: index.php?page=pegawai&action=tambah');
                exit;
            }
            if (strlen($nama_pegawai) > 100) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama Pegawai tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=pegawai&action=tambah');
                exit;
            }

            if (!empty($email)) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Format email pegawai tidak valid!'];
                    header('Location: index.php?page=pegawai&action=tambah');
                    exit;
                }
                if (strlen($email) > 100) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Email tidak boleh lebih dari 100 karakter!'];
                    header('Location: index.php?page=pegawai&action=tambah');
                    exit;
                }
            }

            if (strlen($jenis_pegawai) > 50) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Jenis Pegawai tidak boleh lebih dari 50 karakter!'];
                header('Location: index.php?page=pegawai&action=tambah');
                exit;
            }

            if (!empty($no_hp)) {
                if (!ctype_digit($no_hp)) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP hanya boleh berisi angka!'];
                    header('Location: index.php?page=pegawai&action=tambah');
                    exit;
                }
                if (strlen($no_hp) > 20) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP tidak boleh lebih dari 20 digit!'];
                    header('Location: index.php?page=pegawai&action=tambah');
                    exit;
                }
            }

            $check = $this->model->checkDuplicate($nip_pegawai, $email);
            if ($check) {
                $duplikat = [];
                if ($nip_pegawai && $check['nip_pegawai'] === $nip_pegawai) $duplikat[] = "NIP Pegawai";
                if ($email && $check['email'] === $email) $duplikat[] = "Email";
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => implode(', ', $duplikat) . ' sudah terdaftar!'
                ];
                header('Location: index.php?page=pegawai&action=tambah');
                exit;
            }

            $data = [
                'nip_pegawai'    => $nip_pegawai,
                'nama_pegawai'   => $nama_pegawai,
                'jenis_kelamin'  => $_POST['jenis_kelamin'],
                'email'          => $email,
                'jenis_pegawai'  => $jenis_pegawai,
                'status_pegawai' => $_POST['status_pegawai'],
                'status_aktif'   => $_POST['status_aktif'],
                'no_hp'          => $no_hp
            ];

            if ($this->model->tambahPegawai($data)) {
                unset($_SESSION['old_input']);
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Data pegawai berhasil ditambahkan!'
                ];
                header('Location: index.php?page=pegawai&action=index');
                exit;
            }
        }
    }

    public function edit($id) {
        $pegawai = $this->model->getPegawaiById($id);
        require_once __DIR__ . '/../views/pegawai/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id            = $_POST['id_pegawai'];
            $nip_pegawai   = !empty($_POST['nip_pegawai']) ? trim($_POST['nip_pegawai']) : null;
            $nama_pegawai  = trim($_POST['nama_pegawai']);
            $email         = !empty($_POST['email']) ? trim($_POST['email']) : null;
            $jenis_pegawai = trim($_POST['jenis_pegawai']);
            $no_hp         = trim($_POST['no_hp'] ?? '');

            if (!empty($nip_pegawai)) {
                if (!ctype_digit($nip_pegawai)) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIP Pegawai hanya boleh berisi angka!'];
                    header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                    exit;
                }
                if (strlen($nip_pegawai) > 30) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIP Pegawai tidak boleh lebih dari 30 digit!'];
                    header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                    exit;
                }
            }

            if (!preg_match("/^[a-zA-Z\s\.\',\-]+$/", $nama_pegawai)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama Pegawai hanya boleh berisi huruf, spasi, titik, koma, petik, dan tanda hubung!'];
                header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                exit;
            }
            if (strlen($nama_pegawai) > 100) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama Pegawai tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                exit;
            }

            if (!empty($email)) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Format email pegawai tidak valid!'];
                    header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                    exit;
                }
                if (strlen($email) > 100) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Email tidak boleh lebih dari 100 karakter!'];
                    header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                    exit;
                }
            }

            if (strlen($jenis_pegawai) > 50) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Jenis Pegawai tidak boleh lebih dari 50 karakter!'];
                header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                exit;
            }

            if (!empty($no_hp)) {
                if (!ctype_digit($no_hp)) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP hanya boleh berisi angka!'];
                    header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                    exit;
                }
                if (strlen($no_hp) > 20) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP tidak boleh lebih dari 20 digit!'];
                    header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                    exit;
                }
            }

            $check = $this->model->checkDuplicate($nip_pegawai, $email, $id);
            if ($check) {
                $duplikat = [];
                if ($nip_pegawai && $check['nip_pegawai'] === $nip_pegawai) $duplikat[] = "NIP Pegawai";
                if ($email && $check['email'] === $email) $duplikat[] = "Email";
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => implode(', ', $duplikat) . ' sudah terdaftar!'
                ];
                header('Location: index.php?page=pegawai&action=edit&id=' . $id);
                exit;
            }

            $data = [
                'id_pegawai'     => $id,
                'nip_pegawai'    => $nip_pegawai,
                'nama_pegawai'   => $nama_pegawai,
                'jenis_kelamin'  => $_POST['jenis_kelamin'],
                'email'          => $email,
                'jenis_pegawai'  => $jenis_pegawai,
                'status_pegawai' => $_POST['status_pegawai'],
                'status_aktif'   => $_POST['status_aktif'],
                'no_hp'          => $no_hp
            ];

            if ($this->model->updatePegawai($data)) {
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Data pegawai berhasil diperbarui!'
                ];
                header('Location: index.php?page=pegawai&action=index');
                exit;
            }
        }
    }

    public function hapus($id) {
        if ($this->model->hapusPegawai($id)) {
            $_SESSION['flash'] = [
                'type'  => 'success',
                'pesan' => 'Data pegawai berhasil dihapus!'
            ];
        } else {
            $_SESSION['flash'] = [
                'type'  => 'danger',
                'pesan' => 'Gagal menghapus data pegawai!'
            ];
        }
        header('Location: index.php?page=pegawai&action=index');
        exit;
    }

    public function eksporExcel() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $pegawai = $this->model->getAllPegawaiExport($keyword);
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Data_Pegawai_" . date('Ymd_His') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo "<table border='1'>";
        echo "<thead>
                <tr style='background-color: #007bff; color: #ffffff;'>
                    <th>No</th><th>NIP Pegawai</th><th>Nama Pegawai</th><th>JK</th><th>Email</th><th>Jenis Pegawai</th><th>Status Pegawai</th><th>Status Aktif</th><th>No HP</th>
                </tr>
            </thead><tbody>";
        if (!empty($pegawai)) {
            $no = 1;
            foreach ($pegawai as $p) {
                echo "<tr>
                        <td>" . $no++ . "</td>
                        <td>" . (!empty($p['nip_pegawai']) ? "'" . htmlspecialchars($p['nip_pegawai']) : '-') . "</td>
                        <td>" . htmlspecialchars($p['nama_pegawai']) . "</td>
                        <td>" . htmlspecialchars($p['jenis_kelamin']) . "</td>
                        <td>" . htmlspecialchars($p['email'] ?? '-') . "</td>
                        <td>" . htmlspecialchars($p['jenis_pegawai']) . "</td>
                        <td>" . htmlspecialchars($p['status_pegawai']) . "</td>
                        <td>" . htmlspecialchars($p['status_aktif']) . "</td>
                        <td>" . htmlspecialchars($p['no_hp'] ?? '-') . "</td>
                    </tr>";
            }
        }
        echo "</tbody></table>";
        exit;
    }

    public function cetakPdf() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $pegawai = $this->model->getAllPegawaiExport($keyword);
        require_once __DIR__ . '/../views/pegawai/cetak.php';
    }
}