<?php
require_once __DIR__ . '/../models/DosenModel.php';

class DosenController {
    private $model;

    public function __construct() {
        $this->model = new DosenModel();
    }

    public function index() {
        $keyword   = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $limit     = 10;
        $page      = isset($_GET['page_num']) && is_numeric($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
        if ($page < 1) $page = 1;
        $totalData  = $this->model->getTotalDosen($keyword);
        $totalPages = ceil($totalData / $limit);
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $limit;
        $dosen  = $this->model->getDosenPage($limit, $offset, $keyword);
        require_once __DIR__ . '/../views/dosen/index.php';
    }

    public function tambah() {
        require_once __DIR__ . '/../views/dosen/tambah.php';
    }

    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nidn               = trim($_POST['nidn']);
            $nip                = !empty($_POST['nip']) ? trim($_POST['nip']) : null;
            $nama_dosen         = trim($_POST['nama_dosen']);
            $email              = trim($_POST['email']);
            $prodi              = trim($_POST['prodi']);
            $jabatan_fungsional = trim($_POST['jabatan_fungsional'] ?? '');
            $no_hp              = trim($_POST['no_hp'] ?? '');

            if (!ctype_digit($nidn)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIDN hanya boleh berisi angka!'];
                header('Location: index.php?page=dosen&action=tambah');
                exit;
            }
            if (strlen($nidn) > 30) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIDN tidak boleh lebih dari 30 digit!'];
                header('Location: index.php?page=dosen&action=tambah');
                exit;
            }

            if (!empty($nip)) {
                if (!ctype_digit($nip)) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIP hanya boleh berisi angka!'];
                    header('Location: index.php?page=dosen&action=tambah');
                    exit;
                }
                if (strlen($nip) > 30) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIP tidak boleh lebih dari 30 digit!'];
                    header('Location: index.php?page=dosen&action=tambah');
                    exit;
                }
            }

            if (!preg_match("/^[a-zA-Z\s\.\',\-]+$/", $nama_dosen)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama Dosen hanya boleh berisi huruf, spasi, titik, koma, petik, dan tanda hubung!'];
                header('Location: index.php?page=dosen&action=tambah');
                exit;
            }
            if (strlen($nama_dosen) > 100) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama Dosen tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=dosen&action=tambah');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Format email tidak valid!'];
                header('Location: index.php?page=dosen&action=tambah');
                exit;
            }
            if (strlen($email) > 100) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Email tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=dosen&action=tambah');
                exit;
            }

            if (preg_match('/[0-9]/', $prodi)) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Program Studi tidak boleh mengandung angka!'];
                header('Location: index.php?page=dosen&action=tambah');
                exit;
            }
            if (strlen($prodi) > 100) {
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Program Studi tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=dosen&action=tambah');
                exit;
            }

            if (!empty($no_hp)) {
                if (!ctype_digit($no_hp)) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP hanya boleh berisi angka!'];
                    header('Location: index.php?page=dosen&action=tambah');
                    exit;
                }
                if (strlen($no_hp) > 20) {
                    $_SESSION['old_input'] = $_POST;
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP tidak boleh lebih dari 20 digit!'];
                    header('Location: index.php?page=dosen&action=tambah');
                    exit;
                }
            }

            $check = $this->model->checkDuplicate($nidn, $nip, $email);
            if ($check) {
                $duplikat = [];
                if ($check['nidn'] === $nidn) $duplikat[] = "NIDN";
                if ($nip && $check['nip'] === $nip) $duplikat[] = "NIP";
                if ($check['email'] === $email) $duplikat[] = "Email";
                $_SESSION['old_input'] = $_POST;
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => implode(', ', $duplikat) . ' sudah terdaftar!'
                ];
                header('Location: index.php?page=dosen&action=tambah');
                exit;
            }

            $data = [
                'nidn'               => $nidn,
                'nip'                => $nip,
                'nama_dosen'         => $nama_dosen,
                'jenis_kelamin'      => $_POST['jenis_kelamin'],
                'email'              => $email,
                'prodi'              => $prodi,
                'jabatan_fungsional' => $jabatan_fungsional,
                'no_hp'              => $no_hp
            ];

            if ($this->model->tambahDosen($data)) {
                unset($_SESSION['old_input']);
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Data dosen berhasil ditambahkan!'
                ];
                header('Location: index.php?page=dosen&action=index');
                exit;
            }
        }
    }

    public function edit($id) {
        $dosen = $this->model->getDosenById($id);
        require_once __DIR__ . '/../views/dosen/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id                 = $_POST['id_dosen'];
            $nidn               = trim($_POST['nidn']);
            $nip                = !empty($_POST['nip']) ? trim($_POST['nip']) : null;
            $nama_dosen         = trim($_POST['nama_dosen']);
            $email              = trim($_POST['email']);
            $prodi              = trim($_POST['prodi']);
            $jabatan_fungsional = trim($_POST['jabatan_fungsional'] ?? '');
            $no_hp              = trim($_POST['no_hp'] ?? '');

            if (!ctype_digit($nidn)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIDN hanya boleh berisi angka!'];
                header('Location: index.php?page=dosen&action=edit&id=' . $id);
                exit;
            }
            if (strlen($nidn) > 30) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIDN tidak boleh lebih dari 30 digit!'];
                header('Location: index.php?page=dosen&action=edit&id=' . $id);
                exit;
            }

            if (!empty($nip)) {
                if (!ctype_digit($nip)) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIP hanya boleh berisi angka!'];
                    header('Location: index.php?page=dosen&action=edit&id=' . $id);
                    exit;
                }
                if (strlen($nip) > 30) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'NIP tidak boleh lebih dari 30 digit!'];
                    header('Location: index.php?page=dosen&action=edit&id=' . $id);
                    exit;
                }
            }

            if (!preg_match("/^[a-zA-Z\s\.\',\-]+$/", $nama_dosen)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama Dosen hanya boleh berisi huruf, spasi, titik, koma, petik, dan tanda hubung!'];
                header('Location: index.php?page=dosen&action=edit&id=' . $id);
                exit;
            }
            if (strlen($nama_dosen) > 100) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama Dosen tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=dosen&action=edit&id=' . $id);
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Format email tidak valid!'];
                header('Location: index.php?page=dosen&action=edit&id=' . $id);
                exit;
            }
            if (strlen($email) > 100) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Email tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=dosen&action=edit&id=' . $id);
                exit;
            }

            if (preg_match('/[0-9]/', $prodi)) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Program Studi tidak boleh mengandung angka!'];
                header('Location: index.php?page=dosen&action=edit&id=' . $id);
                exit;
            }
            if (strlen($prodi) > 100) {
                $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Program Studi tidak boleh lebih dari 100 karakter!'];
                header('Location: index.php?page=dosen&action=edit&id=' . $id);
                exit;
            }

            if (!empty($no_hp)) {
                if (!ctype_digit($no_hp)) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP hanya boleh berisi angka!'];
                    header('Location: index.php?page=dosen&action=edit&id=' . $id);
                    exit;
                }
                if (strlen($no_hp) > 20) {
                    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'No. HP tidak boleh lebih dari 20 digit!'];
                    header('Location: index.php?page=dosen&action=edit&id=' . $id);
                    exit;
                }
            }

            $check = $this->model->checkDuplicate($nidn, $nip, $email, $id);
            if ($check) {
                $duplikat = [];
                if ($check['nidn'] === $nidn) $duplikat[] = "NIDN";
                if ($nip && $check['nip'] === $nip) $duplikat[] = "NIP";
                if ($check['email'] === $email) $duplikat[] = "Email";
                $_SESSION['flash'] = [
                    'type'  => 'danger',
                    'pesan' => implode(', ', $duplikat) . ' sudah terdaftar!'
                ];
                header('Location: index.php?page=dosen&action=edit&id=' . $id);
                exit;
            }

            $data = [
                'id_dosen'           => $id,
                'nidn'               => $nidn,
                'nip'                => $nip,
                'nama_dosen'         => $nama_dosen,
                'jenis_kelamin'      => $_POST['jenis_kelamin'],
                'email'              => $email,
                'prodi'              => $prodi,
                'jabatan_fungsional' => $jabatan_fungsional,
                'no_hp'              => $no_hp
            ];

            if ($this->model->updateDosen($data)) {
                $_SESSION['flash'] = [
                    'type'  => 'success',
                    'pesan' => 'Data dosen berhasil diperbarui!'
                ];
                header('Location: index.php?page=dosen&action=index');
                exit;
            }
        }
    }

    public function hapus($id) {
        if ($this->model->hapusDosen($id)) {
            $_SESSION['flash'] = [
                'type'  => 'success',
                'pesan' => 'Data dosen berhasil dihapus!'
            ];
        } else {
            $_SESSION['flash'] = [
                'type'  => 'danger',
                'pesan' => 'Gagal menghapus data dosen!'
            ];
        }
        header('Location: index.php?page=dosen&action=index');
        exit;
    }

    public function eksporExcel() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $dosen   = $this->model->getAllDosenExport($keyword);
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Data_Dosen_" . date('Ymd_His') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo "<table border='1'>";
        echo "<thead>
                <tr style='background-color: #007bff; color: #ffffff;'>
                    <th>No</th><th>NIDN</th><th>NIP</th><th>Nama Dosen</th><th>JK</th><th>Email</th><th>Prodi</th><th>Jabatan Fungsional</th><th>No HP</th>
                </tr>
            </thead><tbody>";
        if (!empty($dosen)) {
            $no = 1;
            foreach ($dosen as $d) {
                echo "<tr>
                        <td>" . $no++ . "</td>
                        <td>'" . htmlspecialchars($d['nidn']) . "</td>
                        <td>" . (!empty($d['nip']) ? "'" . htmlspecialchars($d['nip']) : '-') . "</td>
                        <td>" . htmlspecialchars($d['nama_dosen']) . "</td>
                        <td>" . htmlspecialchars($d['jenis_kelamin']) . "</td>
                        <td>" . htmlspecialchars($d['email']) . "</td>
                        <td>" . htmlspecialchars($d['prodi']) . "</td>
                        <td>" . htmlspecialchars($d['jabatan_fungsional']) . "</td>
                        <td>" . htmlspecialchars($d['no_hp']) . "</td>
                    </tr>";
            }
        }
        echo "</tbody></table>";
        exit;
    }

    public function cetakPdf() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $dosen   = $this->model->getAllDosenExport($keyword);
        require_once __DIR__ . '/../views/dosen/cetak.php';
    }
}